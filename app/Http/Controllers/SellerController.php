<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Services\ProductService;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function __construct(private ProductService $productService) {}

    /**
     * Dashboard del vendedor.
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();
        
        $activeProductsCount = $user->products()->active()->count();
        $soldProductsCount = $user->products()->where('is_sold', true)->count();
        
        // Ganancias netas (subtotal - 5% comisión - $50 envío por cada ítem vendido)
        $simulatedEarnings = $user->salesItems()->get()->sum(function ($item) {
            return max(0, $item->subtotal - ($item->subtotal * 0.05) - 50.00);
        });
        
        $recentProducts = $user->products()->with('category')->latest()->take(5)->get();
        $recentSales = $user->salesItems()->with('order')->latest()->take(5)->get();
        
        return view('seller.dashboard', compact(
            'activeProductsCount', 
            'soldProductsCount', 
            'simulatedEarnings',
            'recentProducts',
            'recentSales'
        ));
    }

    /**
     * Lista de publicaciones del vendedor.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $products = $user->products()
            ->with(['category', 'images'])
            ->latest()
            ->paginate(15);
            
        return view('seller.products.index', compact('products'));
    }

    /**
     * Formulario para crear un producto.
     */
    public function create()
{
    $categories = Category::active()->roots()->with('children')->get();

    if ($categories->isEmpty()) {
        \Illuminate\Support\Facades\Artisan::call('db:seed', [
            '--class' => 'CategorySeeder',
            '--force' => true,
        ]);
        $categories = Category::active()->roots()->with('children')->get();
    }

    $conditions = Product::$conditions;
    $sizes      = Product::$sizes;
    $colors     = Product::$colors;
    $brands     = Product::$brands;
    
    return view('seller.products.create', compact('categories', 'conditions', 'sizes', 'colors', 'brands'));
}

    /**
     * Guarda el nuevo producto.
     */
    public function store(StoreProductRequest $request)
    {
        $user = $request->user();

        // Verificar límite mensual para vendedores sin membresía premium
        if (!$user->hasPremiumMembership()) {
            $limit     = 10;
            $published = $user->publishedThisMonth();

            if ($published >= $limit) {
                return back()->with(
                    'error',
                    "Has alcanzado el límite de {$limit} publicaciones gratuitas este mes. " .
                    "Activa la Membresía Premium para publicaciones ilimitadas."
                );
            }
        }

        $validated = $request->validated();
        $product   = $user->products()->create($validated);

        if ($request->hasFile('images')) {
            $this->productService->uploadImages($product, $request->file('images'));
            $this->productService->setCoverImage($product);
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Publicación creada exitosamente.');
    }

    /**
     * Formulario para editar un producto.
     */
    public function edit(Product $product)
{
    $this->authorize('update', $product);
    
    $categories = Category::active()->roots()->with('children')->get();
    $conditions = Product::$conditions;
    $sizes      = Product::$sizes;
    $colors     = Product::$colors;
    $brands     = Product::$brands;
    
    return view('seller.products.edit', compact('product', 'categories', 'conditions', 'sizes', 'colors', 'brands'));
}

    /**
     * Actualiza el producto.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        
        // Eliminar imágenes seleccionadas
        if (!empty($validated['delete_images'])) {
            $this->productService->deleteImages($product, $validated['delete_images']);
        }
        
        // Subir nuevas imágenes
        if ($request->hasFile('images')) {
            $this->productService->uploadImages($product, $request->file('images'));
        }
        
        // Asegurar que siempre tenga portada si quedan imágenes
        $this->productService->setCoverImage($product);
        
        // Determinar si la prenda sigue agotada o no en función del nuevo stock
        $newStock = isset($validated['stock']) ? (int) $validated['stock'] : $product->stock;
        $validated['is_sold'] = $newStock <= 0;
        
        // Actualizar datos
        $product->update($validated);
        
        return redirect()->route('seller.products.index')
            ->with('success', 'Publicación actualizada exitosamente.' . ($newStock > 0 ? ' ¡El producto está disponible de nuevo en el catálogo!' : ''));
    }

    /**
     * Elimina (soft delete) un producto.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        
        $product->delete(); // Soft delete
        
        return redirect()->route('seller.products.index')
            ->with('success', 'Publicación eliminada.');
    }

    /**
     * Lista de ventas (pedidos) del vendedor.
     */
    public function ordersIndex(Request $request)
    {
        $user = $request->user();
        $orderIds = $user->salesItems()->pluck('order_id')->unique();
        
        $orders = Order::whereIn('id', $orderIds)
            ->with(['buyer', 'items' => function($q) use ($user) {
                $q->where('seller_id', $user->id);
            }])
            ->latest()
            ->paginate(15);
            
        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Detalle de una venta (pedido) del vendedor.
     */
    public function ordersShow(Request $request, Order $order)
    {
        $user = $request->user();
        $hasItems = $order->items()->where('seller_id', $user->id)->exists();
        if (!$hasItems) {
            abort(403, 'No tienes permiso para ver esta orden.');
        }
        
        $order->load(['buyer', 'address', 'shipment', 'payment', 'items' => function($q) use ($user) {
            $q->where('seller_id', $user->id);
        }]);

        if (!$order->shipment) {
            $order->shipment()->create([
                'status'          => 'preparando',
                'carrier'         => 'ReWear Delivery',
                'tracking_number' => 'RW-' . strtoupper(\Illuminate\Support\Str::random(10)),
            ]);
            $order->load('shipment');
        } elseif (!$order->shipment->tracking_number) {
            $order->shipment->update([
                'tracking_number' => 'RW-' . strtoupper(\Illuminate\Support\Str::random(10)),
            ]);
        }
        
        return view('seller.orders.show', compact('order'));
    }

    /**
     * Marca un pedido como enviado.
     */
    public function shipOrder(Request $request, Order $order)
    {
        $user = $request->user();
        $hasItems = $order->items()->where('seller_id', $user->id)->exists();
        if (!$hasItems) {
            abort(403, 'No tienes permiso.');
        }

        $order->update(['status' => 'enviado']);
        
        if ($order->shipment) {
            $order->shipment->update([
                'status'     => 'en_transito',
                'shipped_at' => now(),
            ]);
        }

        // Notificación al comprador
        \App\Services\NotificationService::send(
            $order->buyer_id,
            '¡Tu pedido ha sido enviado! 🚚',
            "Tu compra #{$order->order_number} ya va en camino con paquetería FedEx. Guía: " . ($order->shipment->tracking_number ?? 'N/A'),
            route('orders.show', $order),
            'shipment'
        );
        
        return back()->with('success', 'Pedido marcado como enviado. Imprime la etiqueta de envío con el código QR.');
    }

    /**
     * Vista de impresión de etiqueta con código QR.
     */
    public function printLabel(Request $request, Order $order)
    {
        $user = $request->user();
        $hasItems = $order->items()->where('seller_id', $user->id)->exists();
        if (!$hasItems) {
            abort(403);
        }

        $order->load(['buyer', 'address', 'shipment', 'items.product.user']);

        // Asegurar que exista shipment y tenga número de rastreo
        if (!$order->shipment) {
            $order->shipment()->create([
                'status'          => 'preparando',
                'carrier'         => 'FedEx',
                'tracking_number' => '7489 ' . implode(' ', str_split(substr(str_pad($order->id, 8, '0', STR_PAD_LEFT) . rand(10000000, 99999999), 0, 12), 4)),
            ]);
            $order->load('shipment');
        } elseif (!$order->shipment->tracking_number) {
            $order->shipment->update([
                'tracking_number' => '7489 ' . implode(' ', str_split(substr(str_pad($order->id, 8, '0', STR_PAD_LEFT) . rand(10000000, 99999999), 0, 12), 4)),
            ]);
        }

        $confirmationUrl = route('orders.confirm-delivery', $order);
        
        return view('seller.orders.label', compact('order', 'confirmationUrl'));
    }
}
