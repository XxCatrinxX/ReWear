<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutService
{
    public function __construct(private CartService $cartService) {}

    /**
     * Procesa el checkout y crea la orden.
     * Procesa el pago seguro, vacía el carrito y actualiza el inventario.
     */
    public function process(User $user, ?int $addressId = null, string $notes = '', array $paymentDetails = []): Order
    {
        return DB::transaction(function () use ($user, $addressId, $notes, $paymentDetails) {
            $cart = $this->cartService->getCartWithItems($user);

            if ($cart->items->isEmpty()) {
                throw new \Exception('El carrito está vacío.');
            }

            // Verificar stock antes de proceder
            foreach ($cart->items as $item) {
                $product = $item->product;
                if ($product->is_sold || !$product->is_active || $product->stock < $item->quantity) {
                    throw new \Exception("El producto '{$product->title}' ya no está disponible.");
                }
            }

            // Calcular totales
            $subtotal = $cart->items->sum(fn ($item) => $item->unit_price * $item->quantity);
            $shippingCost = 0; // Gratis por ahora
            $total = $subtotal + $shippingCost;

            // Crear orden
            $order = Order::create([
                'order_number'  => $this->generateOrderNumber(),
                'buyer_id'      => $user->id,
                'address_id'    => $addressId,
                'status'        => 'pagado',  // Pago procesado con éxito
                'subtotal'      => $subtotal,
                'shipping_cost' => $shippingCost,
                'total'         => $total,
                'notes'         => $notes,
            ]);

            // Crear ítems de la orden y actualizar stock
            foreach ($cart->items as $item) {
                $product = $item->product;

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $product->id,
                    'seller_id'     => $product->user_id,
                    'product_title' => $product->title,
                    'product_image' => $product->cover_image,
                    'unit_price'    => $item->unit_price,
                    'quantity'      => $item->quantity,
                    'subtotal'      => $item->unit_price * $item->quantity,
                ]);

                // Actualizar stock
                $newStock = $product->stock - $item->quantity;
                $product->update([
                    'stock'   => $newStock,
                    'is_sold' => $newStock <= 0,
                ]);

                // Acreditar el saldo pendiente al vendedor
                $itemSubtotal = $item->unit_price * $item->quantity;
                $seller = User::find($product->user_id);
                if ($seller) {
                    $seller->increment('pending_balance', $itemSubtotal);
                }
            }

            // Registrar pago simulado
            Payment::create([
                'order_id'        => $order->id,
                'transaction_id'  => 'SIM-' . strtoupper(Str::random(10)),
                'method'          => 'tarjeta',
                'card_type'       => $paymentDetails['card_type'] ?? 'credito',
                'bank_name'       => $paymentDetails['bank_name'] ?? 'Desconocido',
                'status'          => 'completado',
                'amount'          => $total,
                'currency'        => 'MXN',
                'gateway_response'=> ['simulated' => true, 'processed_at' => now()],
                'paid_at'         => now(),
            ]);

            // Crear envío pendiente (con código de rastreo pre-generado)
            Shipment::create([
                'order_id'       => $order->id,
                'status'         => 'preparando',
                'carrier'        => 'ReWear Delivery',
                'tracking_number'=> 'RW-' . strtoupper(Str::random(10)),
            ]);

            // Vaciar carrito
            $this->cartService->clear($user);

            return $order->load(['items', 'payment', 'shipment']);
        });
    }

    /**
     * Genera un número de orden único.
     */
    private function generateOrderNumber(): string
    {
        $year   = date('Y');
        $count  = Order::whereYear('created_at', $year)->count() + 1;
        return "RW-{$year}-" . str_pad($count, 6, '0', STR_PAD_LEFT);
    }
}
