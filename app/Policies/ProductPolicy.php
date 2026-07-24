<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Admin puede hacer todo.
     */
    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Cualquier usuario autenticado puede ver productos.
     */
    public function view(?User $user, Product $product): bool
    {
        return true;
    }

    /**
     * Solo vendedores pueden crear publicaciones.
     */
    public function create(User $user): bool
    {
        return $user->isSeller();
    }

    /**
     * Solo el dueño del producto puede editarlo.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }

    /**
     * Solo el dueño puede eliminar su producto.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }
}
