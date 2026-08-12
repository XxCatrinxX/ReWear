<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRevenueController extends Controller
{
    const COMMISSION_RATE = 0.05;

    public function index(Request $request)
    {
        $period   = $request->input('period', 'month');
        $status   = $request->input('status', 'all');
        $dateFrom = $request->input('date_from');
        $dateTo   = $request->input('date_to');

        $baseQuery = Order::query()->where('status', '!=', 'cancelado');

        if ($status !== 'all') {
            $baseQuery->where('status', $status);
        }

        if ($period === 'custom' && $dateFrom && $dateTo) {
            $baseQuery->whereBetween(DB::raw('DATE(orders.created_at)'), [$dateFrom, $dateTo]);
        } else {
            match ($period) {
                'today' => $baseQuery->whereDate('orders.created_at', today()),
                'week'  => $baseQuery->whereBetween('orders.created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                'year'  => $baseQuery->whereYear('orders.created_at', now()->year),
                default => $baseQuery->whereMonth('orders.created_at', now()->month)->whereYear('orders.created_at', now()->year),
            };
        }

        $orders          = (clone $baseQuery)->with('buyer')->latest()->get();
        $totalSales      = (clone $baseQuery)->sum('total');
        $totalCommission = $totalSales * self::COMMISSION_RATE;
        $ordersCount     = (clone $baseQuery)->count();
        $avgOrder        = $ordersCount > 0 ? $totalSales / $ordersCount : 0;

        // Ganancias por mes (últimos 12 meses)
        $monthlyData = Order::where('status', '!=', 'cancelado')
            ->where('created_at', '>=', now()->subMonths(12)->startOfMonth())
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total_sales'),
                DB::raw('SUM(total) * ' . self::COMMISSION_RATE . ' as commission'),
                DB::raw('COUNT(*) as orders_count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')->orderBy('month')
            ->get();

        // Top 5 vendedores — join via order_items.seller_id (evita problema con soft-delete de products)
        $topSellersQuery = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('users', 'order_items.seller_id', '=', 'users.id')
            ->where('orders.status', '!=', 'cancelado');

        if ($status !== 'all') {
            $topSellersQuery->where('orders.status', $status);
        }

        if ($period === 'custom' && $dateFrom && $dateTo) {
            $topSellersQuery->whereBetween(DB::raw('DATE(orders.created_at)'), [$dateFrom, $dateTo]);
        } else {
            match ($period) {
                'today' => $topSellersQuery->whereDate('orders.created_at', today()),
                'week'  => $topSellersQuery->whereBetween('orders.created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                'year'  => $topSellersQuery->whereYear('orders.created_at', now()->year),
                default => $topSellersQuery->whereMonth('orders.created_at', now()->month)->whereYear('orders.created_at', now()->year),
            };
        }

        $topSellers = $topSellersQuery
            ->select(
                'users.id',
                'users.name',
                DB::raw('SUM(order_items.subtotal) as total_ventas'),
                DB::raw('SUM(order_items.subtotal) * ' . self::COMMISSION_RATE . ' as comision'),
                DB::raw('COUNT(DISTINCT orders.id) as num_ordenes')
            )
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('comision')
            ->take(5)
            ->get();

        return view('admin.revenue.index', compact(
            'orders', 'totalSales', 'totalCommission',
            'ordersCount', 'avgOrder', 'monthlyData', 'topSellers',
            'period', 'status', 'dateFrom', 'dateTo'
        ));
    }

    /**
     * Genera la vista imprimible/PDF del reporte de ganancias y ventas.
     */
    public function exportPdf(Request $request)
    {
        $period   = $request->input('period', 'month');
        $status   = $request->input('status', 'all');
        $dateFrom = $request->input('date_from');
        $dateTo   = $request->input('date_to');

        $baseQuery = Order::query()->where('status', '!=', 'cancelado');

        if ($status !== 'all') {
            $baseQuery->where('status', $status);
        }

        if ($period === 'custom' && $dateFrom && $dateTo) {
            $baseQuery->whereBetween(DB::raw('DATE(orders.created_at)'), [$dateFrom, $dateTo]);
        } else {
            match ($period) {
                'today' => $baseQuery->whereDate('orders.created_at', today()),
                'week'  => $baseQuery->whereBetween('orders.created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                'year'  => $baseQuery->whereYear('orders.created_at', now()->year),
                default => $baseQuery->whereMonth('orders.created_at', now()->month)->whereYear('orders.created_at', now()->year),
            };
        }

        $orders          = (clone $baseQuery)->with(['buyer', 'items.product'])->latest()->get();
        $totalSales      = (clone $baseQuery)->sum('total');
        $totalCommission = $totalSales * self::COMMISSION_RATE;
        $ordersCount     = (clone $baseQuery)->count();
        $avgOrder        = $ordersCount > 0 ? $totalSales / $ordersCount : 0;

        return view('admin.revenue.pdf', compact(
            'orders', 'totalSales', 'totalCommission',
            'ordersCount', 'avgOrder', 'period', 'status', 'dateFrom', 'dateTo'
        ));
    }
}
