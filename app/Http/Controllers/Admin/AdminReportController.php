<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderReport;
use App\Models\ProductReport;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    /**
     * Lista reportes de publicaciones y reportes de envíos/compras.
     */
    public function index(Request $request)
    {
        $tab    = $request->input('tab', 'products'); // 'products' o 'orders'
        $status = $request->input('status');

        if ($tab === 'orders') {
            $query = OrderReport::with(['user', 'order', 'order.shipment', 'order.items.product'])
                ->latest();

            if ($status) {
                $query->where('status', $status);
            }

            $reports = $query->paginate(15)->withQueryString();

            $counts = [
                'pendiente'   => OrderReport::where('status', 'pendiente')->count(),
                'en_revision' => OrderReport::where('status', 'en_revision')->count(),
                'resuelto'    => OrderReport::where('status', 'resuelto')->count(),
                'desestimado' => OrderReport::where('status', 'desestimado')->count(),
            ];
        } else {
            $query = ProductReport::with(['user', 'product', 'product.user'])
                ->latest();

            if ($status) {
                $query->where('status', $status);
            }

            $reports = $query->paginate(15)->withQueryString();

            $counts = [
                'pendiente'   => ProductReport::where('status', 'pendiente')->count(),
                'revisado'    => ProductReport::where('status', 'revisado')->count(),
                'desestimado' => ProductReport::where('status', 'desestimado')->count(),
            ];
        }

        $pendingProductReports = ProductReport::where('status', 'pendiente')->count();
        $pendingOrderReports   = OrderReport::where('status', 'pendiente')->count();

        return view('admin.reports.index', compact(
            'reports', 'counts', 'tab', 'status',
            'pendingProductReports', 'pendingOrderReports'
        ));
    }

    /** Cambia el estado de un reporte de publicación. */
    public function update(Request $request, ProductReport $report)
    {
        $validated = $request->validate([
            'status'         => 'required|in:pendiente,revisado,desestimado',
            'delete_product' => 'nullable|boolean',
        ]);

        $report->update(['status' => $validated['status']]);

        if (!empty($validated['delete_product']) && $validated['status'] === 'revisado') {
            $report->product?->delete();
            return back()->with('success', 'Reporte marcado como revisado y publicación eliminada.');
        }

        return back()->with('success', 'Estado del reporte de publicación actualizado.');
    }

    /** Cambia el estado de un reporte de envío/pedido. */
    public function updateOrderReport(Request $request, OrderReport $report)
    {
        $validated = $request->validate([
            'status'      => 'required|in:pendiente,en_revision,resuelto,desestimado',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'status'      => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $report->admin_notes,
        ]);

        return back()->with('success', 'Estado del reporte de envío/pedido actualizado correctamente.');
    }
}
