<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories    = Category::active()->roots()->withCount('products')->get();
        $featuredItems = Product::active()->featured()->with(['images', 'user', 'category'])->latest()->take(8)->get();
        $recentItems   = Product::active()->with(['images', 'user', 'category'])->latest()->take(12)->get();

        return view('home.index', compact('categories', 'featuredItems', 'recentItems'));
    }
}
