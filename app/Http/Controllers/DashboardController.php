<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard del usuario comprador (o redirección a admin/vendedor según el rol principal).
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Si es admin, redirigir al panel de admin
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Si es seller, redirigir al panel de seller
        if ($user->isSeller()) {
            return redirect()->route('seller.dashboard');
        }

        // Si es solo comprador, mostrar un panel básico con sus compras y favoritos recientes
        $recentOrders = $user->orders()->latest()->take(5)->get();
        $recentFavorites = $user->favorites()->with('product')->latest()->take(4)->get();

        return view('dashboard', compact('recentOrders', 'recentFavorites'));
    }
}
