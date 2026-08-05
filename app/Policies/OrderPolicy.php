<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Admin puede ver todas las órdenes.
     */
    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * El comprador solo puede ver sus propias órdenes.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id;
    }

    /**
     * Solo el comprador puede cancelar su propia orden si está pendiente.
     */
    public function cancel(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id && $order->status === 'pendiente';
    }
}
