<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->withCount('products')->latest()->paginate(15);
        $parents = Category::roots()->get();
        
        return view('admin.categories.index', compact('categories', 'parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories'],
            'parent_id'   => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon'        => ['nullable', 'string', 'max:50'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        Category::create($validated);
        
        return back()->with('success', 'Categoría creada correctamente.');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories,name,' . $category->id],
            'parent_id'   => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon'        => ['nullable', 'string', 'max:50'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        // Evitar que sea padre de sí misma
        if ($validated['parent_id'] == $category->id) {
            return back()->with('error', 'Una categoría no puede ser padre de sí misma.');
        }

        $category->update($validated);
        
        return back()->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists() || $category->children()->exists()) {
            return back()->with('error', 'No se puede eliminar porque tiene productos o subcategorías asociadas.');
        }

        $category->delete();
        return back()->with('success', 'Categoría eliminada correctamente.');
    }
}
