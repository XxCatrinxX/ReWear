<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Muestra la lista de pedidos del usuario actual.
     */
    public function index(Request $request)
    {
        $orders = Order::where('buyer_id', $request->user()->id)
            ->with(['items.product', 'payment', 'shipment'])
            ->latest()
            ->paginate(10);
            
        return view('orders.index', compact('orders'));
    }

    /**
     * Muestra el detalle de un pedido.
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        
        $order->load(['items.product', 'items.seller', 'payment', 'shipment', 'address']);
        
        return view('orders.show', compact('order'));
    }

    /**
     * Muestra la página de confirmación de entrega (desde el escaneo QR).
     */
    public function confirmDeliveryPage(Order $order)
    {
        $this->authorize('view', $order);
        
        if ($order->status === 'entregado') {
            return redirect()->route('orders.show', $order)->with('info', 'Este pedido ya ha sido entregado y liberado.');
        }

        $order->load(['items.product', 'items.seller', 'address', 'shipment']);
        return view('orders.confirm-delivery', compact('order'));
    }

    /**
     * Confirma la entrega física y libera los fondos retenidos al vendedor.
     */
    public function processConfirmDelivery(Request $request, Order $order)
    {
        $this->authorize('view', $order);

        if ($order->status === 'entregado') {
            return redirect()->route('orders.show', $order)->with('info', 'El pedido ya estaba confirmado.');
        }

        // Actualizar estados
        $order->update(['status' => 'entregado']);

        if ($order->shipment) {
            $order->shipment->update([
                'status' => 'entregado',
                'delivered_at' => now(),
            ]);
        }

        // Liberar el dinero de saldo pendiente a saldo disponible para cada vendedor
        foreach ($order->items as $item) {
            $seller = \App\Models\User::find($item->seller_id);
            if ($seller) {
                $amount = $item->subtotal;
                // Prevenir saldos negativos en caso de ajuste manual
                $deduct = min($seller->pending_balance, $amount);
                $seller->decrement('pending_balance', $deduct);
                $seller->increment('available_balance', $amount);
            }
        }

        return redirect()->route('orders.show', $order)->with('success', '¡Entrega confirmada! Los fondos se han liberado y están disponibles en la billetera del vendedor.');
    }
}
