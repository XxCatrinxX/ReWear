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
        
        // Simular ganancias (suma del total de items vendidos por este vendedor)
        $simulatedEarnings = $user->salesItems()->sum('subtotal');
        
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
        $conditions = Product::$conditions;
        $sizes = Product::$sizes;
        
        return view('seller.products.create', compact('categories', 'conditions', 'sizes'));
    }

    /**
     * Guarda el nuevo producto.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        
        $product = $request->user()->products()->create($validated);
        
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
        $sizes = Product::$sizes;
        
        return view('seller.products.edit', compact('product', 'categories', 'conditions', 'sizes'));
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
                'status' => 'en_transito',
                'carrier' => 'ReWear Delivery',
                'tracking_number' => 'RW-' . strtoupper(\Illuminate\Support\Str::random(10)),
                'shipped_at' => now(),
            ]);
        }
        
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

        $order->load(['buyer', 'address']);
        $confirmationUrl = route('orders.confirm-delivery', $order);
        
        return view('seller.orders.label', compact('order', 'confirmationUrl'));
    }
}
