<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRevenueController extends Controller
{
    const COMMISSION_RATE = 0.05; // 5% por venta

    public function index(Request $request)
    {
        $period    = $request->input('period', 'month'); // today, week, month, year, custom
        $status    = $request->input('status', 'all');
        $dateFrom  = $request->input('date_from');
        $dateTo    = $request->input('date_to');

        // Base query (excluye canceladas)
        $baseQuery = Order::query()->where('status', '!=', 'cancelado');

        if ($status !== 'all') {
            $baseQuery->where('status', $status);
        }

        // Aplicar filtro de período
        if ($period === 'custom' && $dateFrom && $dateTo) {
            $baseQuery->whereBetween(DB::raw('DATE(created_at)'), [$dateFrom, $dateTo]);
        } else {
            match ($period) {
                'today' => $baseQuery->whereDate('created_at', today()),
                'week'  => $baseQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                'year'  => $baseQuery->whereYear('created_at', now()->year),
                default => $baseQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
            };
        }

        $orders        = (clone $baseQuery)->latest()->get();
        $totalSales    = (clone $baseQuery)->sum('total');
        $totalCommission = $totalSales * self::COMMISSION_RATE;
        $ordersCount   = (clone $baseQuery)->count();
        $avgOrder      = $ordersCount > 0 ? $totalSales / $ordersCount : 0;

        // Ganancias por mes (últimos 12 meses) para gráfico
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

        // Top 5 vendedores por comisión generada en el período
        $topSellers = (clone $baseQuery)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('users', 'products.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                DB::raw('SUM(orders.total) as total_ventas'),
                DB::raw('SUM(orders.total) * ' . self::COMMISSION_RATE . ' as comision'),
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
}
