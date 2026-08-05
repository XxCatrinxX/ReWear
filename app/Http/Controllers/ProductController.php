<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Catálogo principal de productos con filtros y búsqueda.
     */
    public function index(Request $request)
    {
        $query = Product::active()->with(['user', 'category', 'images']);

        // Búsqueda por texto
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($childQ) use ($search) {
                      $childQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filtro por categoría
        if ($categorySlug = $request->input('category')) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Filtro por estado de prenda
        if ($condition = $request->input('condition')) {
            $query->where('condition', $condition);
        }

        // Filtro por precio
        $query->priceBetween($request->input('min_price'), $request->input('max_price'));

        // Ordenamiento
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::active()->roots()->with('children')->get();

        return view('catalog.index', compact('products', 'categories'));
    }

    /**
     * Muestra el detalle de un producto específico.
     */
    public function show(Product $product)
    {
        // Si el producto está vendido o inactivo, solo el admin o el dueño pueden verlo
        if (!$product->is_active || $product->is_sold) {
            if (!auth()->check() || (!auth()->user()->isAdmin() && auth()->id() !== $product->user_id)) {
                abort(404);
            }
        }

        $product->load(['user.profile', 'category', 'images', 'questions.user']);
        
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
