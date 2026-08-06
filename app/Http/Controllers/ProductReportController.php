<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReport;
use Illuminate\Http\Request;

class ProductReportController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'reason'  => 'required|string|max:150',
            'details' => 'nullable|string|max:1000',
        ]);

        // Un usuario no puede reportar el mismo producto dos veces
        $already = ProductReport::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->exists();

        if ($already) {
            return back()->with('error', 'Ya has enviado un reporte para esta publicación.');
        }

        ProductReport::create([
            'user_id'    => $request->user()->id,
            'product_id' => $product->id,
            'reason'     => $validated['reason'],
            'details'    => $validated['details'] ?? null,
            'status'     => 'pendiente',
        ]);

        return back()->with('success', 'Reporte enviado. Nuestro equipo lo revisará pronto.');
    }
}
