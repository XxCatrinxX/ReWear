<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderReport;
use Illuminate\Http\Request;

class OrderReportController extends Controller
{
    /**
     * Permite al comprador generar un reporte sobre una compra/envío.
     */
    public function store(Request $request, Order $order)
    {
        $this->authorize('view', $order);

        $validated = $request->validate([
            'type'        => 'required|in:producto,envio,otro',
            'reason'      => 'required|string|max:255',
            'description' => 'required|string|max:2000',
        ], [
            'type.required'        => 'Por favor selecciona el tipo de problema.',
            'reason.required'      => 'El motivo del reporte es obligatorio.',
            'description.required' => 'Describe lo sucedido para que soporte pueda ayudarte.',
        ]);

        OrderReport::create([
            'order_id'    => $order->id,
            'user_id'     => $request->user()->id,
            'type'        => $validated['type'],
            'reason'      => $validated['reason'],
            'description' => $validated['description'],
            'status'      => 'pendiente',
        ]);

        return back()->with('success', 'Tu reporte ha sido enviado con éxito. El equipo de administración de ReWear lo revisará a la brevedad.');
    }
}
