<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard general de administración.
     */
    public function dashboard()
    {
        $stats = [
            'total_users'     => User::count(),
            'total_sellers'   => User::where('is_seller', true)->count(),
            'total_products'  => Product::count(),
            'total_orders'    => Order::count(),
            'revenue_sim'     => Order::where('status', '!=', 'cancelado')->sum('total'),
        ];

        $recentUsers    = User::latest()->take(5)->get();
        $recentOrders   = Order::with(['buyer'])->latest()->take(5)->get();
        $recentProducts = Product::with(['user'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentOrders', 'recentProducts'));
    }
}
