<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['buyer', 'payment', 'shipment']);

        if ($search = $request->input('search')) {
            $query->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('buyer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(15);
        $statuses = Order::$statuses;
        
        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load(['buyer', 'items.product', 'items.seller', 'payment', 'shipment', 'address']);
        $statuses = Order::$statuses;
        
        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', array_keys(Order::$statuses))],
        ]);

        $order->update(['status' => $validated['status']]);
        
        // Sincronizar estado del envío básico
        if ($order->shipment) {
            $shipmentStatus = match($validated['status']) {
                'enviado'   => 'en_transito',
                'entregado' => 'entregado',
                'cancelado' => 'fallido',
                default     => $order->shipment->status,
            };
            $order->shipment->update(['status' => $shipmentStatus]);
        }
        
        return back()->with('success', 'Estado de la orden actualizado.');
    }
}
