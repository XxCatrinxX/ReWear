<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Muestra los productos favoritos del usuario.
     */
    public function index(Request $request)
    {
        $favorites = Product::whereIn('id', $request->user()->favorites()->pluck('product_id'))
            ->with(['images', 'category'])
            ->latest()
            ->paginate(12);
            
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Alterna (agrega o elimina) un producto de favoritos.
     */
    public function toggle(Request $request, Product $product)
    {
        $favorite = $request->user()->favorites()->where('product_id', $product->id)->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Producto eliminado de favoritos.');
        } else {
            $request->user()->favorites()->create(['product_id' => $product->id]);
            return back()->with('success', 'Producto agregado a favoritos.');
        }
    }
}
