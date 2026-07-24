<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * Obtiene o crea el carrito del usuario.
     */
    public function getOrCreate(User $user): Cart
    {
        return Cart::firstOrCreate(['user_id' => $user->id]);
    }

    /**
     * Agrega un producto al carrito.
     * Si ya existe, incrementa la cantidad.
     */
    public function addItem(User $user, Product $product, int $quantity = 1): CartItem
    {
        $cart = $this->getOrCreate($user);

        // Verificar disponibilidad
        if ($product->is_sold || !$product->is_active || $product->stock < $quantity) {
            throw new \Exception('Este producto no está disponible.');
        }

        // No puede comprar sus propios productos
        if ($product->user_id === $user->id) {
            throw new \Exception('No puedes agregar tus propios productos al carrito.');
        }

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $newQty = $item->quantity + $quantity;
            if ($newQty > $product->stock) {
                throw new \Exception('No hay suficiente stock disponible.');
            }
            $item->update(['quantity' => $newQty]);
        } else {
            $item = CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'unit_price' => $product->price,
            ]);
        }

        return $item->load('product');
    }

    /**
     * Elimina un ítem del carrito.
     */
    public function removeItem(User $user, int $cartItemId): void
    {
        $cart = $this->getOrCreate($user);
        CartItem::where('cart_id', $cart->id)->where('id', $cartItemId)->delete();
    }

    /**
     * Actualiza la cantidad de un ítem.
     */
    public function updateQuantity(User $user, int $cartItemId, int $quantity): CartItem
    {
        $cart = $this->getOrCreate($user);
        $item = CartItem::where('cart_id', $cart->id)->where('id', $cartItemId)->firstOrFail();

        if ($quantity <= 0) {
            $item->delete();
            throw new \Exception('Ítem eliminado del carrito.');
        }

        if ($quantity > $item->product->stock) {
            throw new \Exception('No hay suficiente stock.');
        }

        $item->update(['quantity' => $quantity]);
        return $item;
    }

    /**
     * Vacía el carrito completo.
     */
    public function clear(User $user): void
    {
        $cart = $this->getOrCreate($user);
        $cart->items()->delete();
    }

    /**
     * Obtiene el carrito con items y productos cargados.
     */
    public function getCartWithItems(User $user): Cart
    {
        $cart = $this->getOrCreate($user);
        return $cart->load(['items.product.images', 'items.product.user']);
    }

    /**
     * Cuenta la cantidad de ítems en el carrito (para badge en navbar).
     */
    public function getItemCount(User $user): int
    {
        return Cart::where('user_id', $user->id)
            ->withCount('items')
            ->first()
            ?->items_count ?? 0;
    }
}
