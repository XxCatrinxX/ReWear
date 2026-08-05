<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    /**
     * Muestra el carrito del usuario.
     */
    public function index(Request $request)
    {
        $cart = $this->cartService->getCartWithItems($request->user());
        return view('cart.index', compact('cart'));
    }

    /**
     * Añade un producto al carrito.
     */
    public function store(Request $request, Product $product)
    {
        try {
            $quantity = $request->input('quantity', 1);
            $this->cartService->addItem($request->user(), $product, $quantity);
            
            return redirect()->back()->with('success', 'Producto agregado al carrito.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Actualiza la cantidad de un ítem en el carrito.
     */
    public function update(Request $request, int $itemId)
    {
        try {
            $quantity = $request->input('quantity');
            $this->cartService->updateQuantity($request->user(), $itemId, $quantity);
            
            return redirect()->back()->with('success', 'Carrito actualizado.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Elimina un ítem del carrito.
     */
    public function destroy(Request $request, int $itemId)
    {
        $this->cartService->removeItem($request->user(), $itemId);
        return redirect()->back()->with('success', 'Producto eliminado del carrito.');
    }
}
