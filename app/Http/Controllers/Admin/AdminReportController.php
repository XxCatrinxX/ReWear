<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReport;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    /** Lista todos los reportes con filtros. */
    public function index(Request $request)
    {
        $query = ProductReport::with(['user', 'product', 'product.user'])
            ->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $reports = $query->paginate(20)->withQueryString();

        $counts = [
            'pendiente'   => ProductReport::where('status', 'pendiente')->count(),
            'revisado'    => ProductReport::where('status', 'revisado')->count(),
            'desestimado' => ProductReport::where('status', 'desestimado')->count(),
        ];

        return view('admin.reports.index', compact('reports', 'counts'));
    }

    /** Cambia el estado de un reporte y opcionalmente elimina el producto. */
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

        return back()->with('success', 'Estado del reporte actualizado.');
    }
}
