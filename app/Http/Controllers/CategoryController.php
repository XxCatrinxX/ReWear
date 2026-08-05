<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Muestra las subcategorías o redirecciona al catálogo filtrado por esta categoría.
     */
    public function show(Category $category)
    {
        if ($category->children()->count() > 0) {
            $category->load('children');
            return view('categories.show', compact('category'));
        }

        return redirect()->route('catalog', ['category' => $category->slug]);
    }
}
