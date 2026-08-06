@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Dashboard</h1>
    <p class="text-[#607D8B]">Resumen general de la plataforma.</p>
</div>

<!-- Estadísticas -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#E5E7EB]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-[#607D8B] font-medium text-sm uppercase tracking-wider">Usuarios</h3>
            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class='bx bxs-user'></i>
            </div>
        </div>
        <p class="font-outfit text-3xl font-bold text-[#263238]">{{ $stats['total_users'] }}</p>
        <p class="text-sm text-[#607D8B] mt-2">Vendedores: <span class="font-medium text-[#263238]">{{ $stats['total_sellers'] }}</span></p>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#E5E7EB]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-[#607D8B] font-medium text-sm uppercase tracking-wider">Productos</h3>
            <div class="w-10 h-10 rounded-full bg-[#2E7D32]/10 text-[#2E7D32] flex items-center justify-center text-xl">
                <i class='bx bxs-t-shirt'></i>
            </div>
        </div>
        <p class="font-outfit text-3xl font-bold text-[#263238]">{{ $stats['total_products'] }}</p>
        <p class="text-sm text-[#607D8B] mt-2">En el catálogo</p>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#E5E7EB]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-[#607D8B] font-medium text-sm uppercase tracking-wider">Órdenes</h3>
            <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                <i class='bx bxs-shopping-bags'></i>
            </div>
        </div>
        <p class="font-outfit text-3xl font-bold text-[#263238]">{{ $stats['total_orders'] }}</p>
        <p class="text-sm text-[#607D8B] mt-2">Totales</p>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#E5E7EB]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-[#607D8B] font-medium text-sm uppercase tracking-wider">Ingresos Sim.</h3>
            <div class="w-10 h-10 rounded-full bg-[#D4A373]/10 text-[#D4A373] flex items-center justify-center text-xl">
                <i class='bx bx-dollar'></i>
            </div>
        </div>
        <p class="font-outfit text-3xl font-bold text-[#263238]">${{ number_format($stats['revenue_sim'], 2) }}</p>
        <p class="text-sm text-[#607D8B] mt-2">Volumen de ventas</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-amber-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-[#607D8B] font-medium text-sm uppercase tracking-wider">Premium</h3>
            <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-xl">
                <i class='bx bxs-crown'></i>
            </div>
        </div>
        <p class="font-outfit text-3xl font-bold text-[#263238]">{{ $stats['premium_sellers'] }}</p>
        <p class="text-sm text-[#607D8B] mt-2">Vendedores Premium</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border {{ $stats['pending_reports'] > 0 ? 'border-red-300' : 'border-[#E5E7EB]' }}">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-[#607D8B] font-medium text-sm uppercase tracking-wider">Reportes</h3>
            <div class="w-10 h-10 rounded-full {{ $stats['pending_reports'] > 0 ? 'bg-red-50 text-red-500' : 'bg-gray-50 text-gray-400' }} flex items-center justify-center text-xl">
                <i class='bx bx-flag'></i>
            </div>
        </div>
        <p class="font-outfit text-3xl font-bold {{ $stats['pending_reports'] > 0 ? 'text-red-600' : 'text-[#263238]' }}">{{ $stats['pending_reports'] }}</p>
        <a href="{{ route('admin.reports.index', ['status' => 'pendiente']) }}" class="text-sm text-red-500 hover:underline mt-2 inline-block">Revisar pendientes</a>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
    
    <!-- Últimos Usuarios -->
    <div class="bg-white rounded-2xl shadow-sm border border-[#E5E7EB] overflow-hidden">
        <div class="px-6 py-4 border-b border-[#E5E7EB] flex justify-between items-center bg-[#F8FAF7]">
            <h2 class="font-outfit font-semibold text-[#263238]">Usuarios Registrados Recientemente</h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-[#2E7D32] hover:underline">Ver todos</a>
        </div>
        <div class="divide-y divide-[#E5E7EB]">
            @foreach($recentUsers as $user)
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ $user->avatar_url }}" class="w-10 h-10 rounded-full border border-[#E5E7EB]">
                        <div>
                            <p class="font-medium text-[#263238] text-sm">{{ $user->name }}</p>
                            <p class="text-xs text-[#607D8B]">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div>
                        @if($user->is_seller)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#D4A373]/20 text-[#b88c63] uppercase tracking-wider">Vendedor</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600 uppercase tracking-wider">Comprador</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Últimas Órdenes -->
    <div class="bg-white rounded-2xl shadow-sm border border-[#E5E7EB] overflow-hidden">
        <div class="px-6 py-4 border-b border-[#E5E7EB] flex justify-between items-center bg-[#F8FAF7]">
            <h2 class="font-outfit font-semibold text-[#263238]">Últimas Órdenes</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-[#2E7D32] hover:underline">Ver todas</a>
        </div>
        <div class="divide-y divide-[#E5E7EB]">
            @foreach($recentOrders as $order)
                <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <p class="font-medium text-[#263238] text-sm">
                            <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-[#2E7D32]">{{ $order->order_number }}</a>
                        </p>
                        <p class="text-xs text-[#607D8B]">Por {{ $order->buyer->name }}</p>
                    </div>
                    <div class="flex items-center gap-4 justify-between sm:justify-end w-full sm:w-auto">
                        <span class="font-bold text-[#2E7D32] text-sm">{{ $order->formatted_total }}</span>
                        
                        @php
                            $statusColor = match($order->status) {
                                'pendiente' => 'bg-yellow-100 text-yellow-800',
                                'pagado' => 'bg-blue-100 text-blue-800',
                                'enviado' => 'bg-indigo-100 text-indigo-800',
                                'entregado' => 'bg-green-100 text-green-800',
                                'cancelado' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $statusColor }}">
                            {{ $order->status_label }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Reportes Pendientes -->
@if($pendingReports->isNotEmpty())
<div class="mt-8 bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-red-100 flex justify-between items-center bg-red-50">
        <h2 class="font-outfit font-semibold text-red-700 flex items-center gap-2">
            <i class='bx bx-flag'></i> Reportes Pendientes de Revisión
        </h2>
        <a href="{{ route('admin.reports.index') }}" class="text-sm text-red-600 hover:underline">Ver todos</a>
    </div>
    <div class="divide-y divide-[#E5E7EB]">
        @foreach($pendingReports as $report)
            <div class="p-4 flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-[#263238] text-sm truncate">{{ $report->product?->title ?? 'Publicación eliminada' }}</p>
                    <p class="text-xs text-[#607D8B]">Reportado por {{ $report->user?->name }} &mdash; {{ $report->reason }}</p>
                </div>
                <a href="{{ route('admin.reports.index', ['status'=>'pendiente']) }}"
                   class="flex-shrink-0 px-3 py-1.5 text-xs rounded-xl bg-red-100 text-red-700 hover:bg-red-200 transition font-medium">
                    Revisar
                </a>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection
