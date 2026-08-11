@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="font-outfit text-3xl font-bold text-[#263238]">Ganancias de la Plataforma</h1>
            <p class="text-[#607D8B] mt-1">Comisión del 5% sobre ventas completadas.</p>
        </div>
        <span class="inline-flex items-center gap-2 bg-amber-100 text-amber-800 text-xs font-semibold px-3 py-1.5 rounded-full self-start">
            <i class='bx bx-percent'></i> Comisión: 5% por venta
        </span>
    </div>
</div>

<!-- ── Filtros ───────────────────────────────────────────────── -->
<form method="GET" action="{{ route('admin.revenue.index') }}" class="bg-white rounded-2xl border border-[#E5E7EB] shadow-sm p-5 mb-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-xs font-semibold text-[#607D8B] mb-1 uppercase tracking-wider">Período</label>
            <select name="period" id="period-select" onchange="toggleCustomDates(this.value)"
                class="w-full rounded-xl border border-[#E5E7EB] px-3 py-2 text-sm text-[#263238] focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/30">
                <option value="today"  {{ $period === 'today'  ? 'selected' : '' }}>Hoy</option>
                <option value="week"   {{ $period === 'week'   ? 'selected' : '' }}>Esta semana</option>
                <option value="month"  {{ $period === 'month'  ? 'selected' : '' }}>Este mes</option>
                <option value="year"   {{ $period === 'year'   ? 'selected' : '' }}>Este año</option>
                <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Rango personalizado</option>
            </select>
        </div>
        <div id="custom-dates" class="{{ $period !== 'custom' ? 'hidden' : '' }} grid grid-cols-2 gap-2 sm:col-span-2 lg:col-span-1">
            <div>
                <label class="block text-xs font-semibold text-[#607D8B] mb-1 uppercase tracking-wider">Desde</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}"
                    class="w-full rounded-xl border border-[#E5E7EB] px-3 py-2 text-sm text-[#263238] focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/30">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#607D8B] mb-1 uppercase tracking-wider">Hasta</label>
                <input type="date" name="date_to" value="{{ $dateTo }}"
                    class="w-full rounded-xl border border-[#E5E7EB] px-3 py-2 text-sm text-[#263238] focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/30">
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-[#607D8B] mb-1 uppercase tracking-wider">Estado de la orden</label>
            <select name="status"
                class="w-full rounded-xl border border-[#E5E7EB] px-3 py-2 text-sm text-[#263238] focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/30">
                <option value="all"       {{ $status === 'all'       ? 'selected' : '' }}>Todos (excepto cancelados)</option>
                <option value="pagado"    {{ $status === 'pagado'    ? 'selected' : '' }}>Pagado</option>
                <option value="enviado"   {{ $status === 'enviado'   ? 'selected' : '' }}>Enviado</option>
                <option value="entregado" {{ $status === 'entregado' ? 'selected' : '' }}>Entregado</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold px-4 py-2 rounded-xl transition flex items-center justify-center gap-2">
                <i class='bx bx-filter-alt'></i> Aplicar
            </button>
            <a href="{{ route('admin.revenue.index') }}" class="px-4 py-2 rounded-xl border border-[#E5E7EB] text-sm text-[#607D8B] hover:bg-[#F8FAF7] transition flex items-center justify-center">
                <i class='bx bx-x'></i>
            </a>
        </div>
    </div>
</form>

<!-- ── Tarjetas de resumen ───────────────────────────────────── -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-6 rounded-2xl text-white shadow-md">
        <div class="flex items-center justify-between mb-3">
            <p class="text-amber-100 text-xs font-semibold uppercase tracking-wider">Ganancias ReWear</p>
            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-xl">
                <i class='bx bx-dollar-circle'></i>
            </div>
        </div>
        <p class="font-outfit text-3xl font-bold">${{ number_format($totalCommission, 2) }}</p>
        <p class="text-amber-100 text-xs mt-1">5% sobre ${{ number_format($totalSales, 2) }} en ventas</p>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-[#E5E7EB] shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[#607D8B] text-xs font-semibold uppercase tracking-wider">Total Ventas</p>
            <div class="w-10 h-10 bg-[#2E7D32]/10 rounded-full flex items-center justify-center text-xl text-[#2E7D32]">
                <i class='bx bx-trending-up'></i>
            </div>
        </div>
        <p class="font-outfit text-3xl font-bold text-[#263238]">${{ number_format($totalSales, 2) }}</p>
        <p class="text-[#607D8B] text-xs mt-1">Monto total facturado</p>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-[#E5E7EB] shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[#607D8B] text-xs font-semibold uppercase tracking-wider">Órdenes</p>
            <div class="w-10 h-10 bg-purple-50 rounded-full flex items-center justify-center text-xl text-purple-600">
                <i class='bx bxs-shopping-bags'></i>
            </div>
        </div>
        <p class="font-outfit text-3xl font-bold text-[#263238]">{{ $ordersCount }}</p>
        <p class="text-[#607D8B] text-xs mt-1">En el período seleccionado</p>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-[#E5E7EB] shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[#607D8B] text-xs font-semibold uppercase tracking-wider">Ticket Promedio</p>
            <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center text-xl text-blue-600">
                <i class='bx bx-receipt'></i>
            </div>
        </div>
        <p class="font-outfit text-3xl font-bold text-[#263238]">${{ number_format($avgOrder, 2) }}</p>
        <p class="text-[#607D8B] text-xs mt-1">Por orden</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- ── Gráfico de barras por mes ─────────────────────────── -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E5E7EB] shadow-sm p-6">
        <h2 class="font-outfit font-bold text-[#263238] text-lg mb-1">Evolución de Ganancias</h2>
        <p class="text-xs text-[#607D8B] mb-5">Últimos 12 meses — comisión del 5%</p>
        <div class="overflow-x-auto">
            <div class="flex items-end gap-2 min-w-[500px] h-40">
                @forelse($monthlyData as $row)
                    @php
                        $maxCommission = $monthlyData->max('commission') ?: 1;
                        $barH = max(4, round(($row->commission / $maxCommission) * 128));
                        $monthNames = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
                        $label = $monthNames[$row->month - 1] . ' ' . substr($row->year, 2);
                    @endphp
                    <div class="flex-1 flex flex-col items-center gap-1 group cursor-default" title="${{ number_format($row->commission,2) }} ({{ $row->orders_count }} órdenes)">
                        <span class="text-[9px] text-amber-600 font-bold opacity-0 group-hover:opacity-100 transition whitespace-nowrap">${{ number_format($row->commission,0) }}</span>
                        <div class="w-full bg-amber-400 hover:bg-amber-500 rounded-t-md transition" style="height: {{ $barH }}px;"></div>
                        <span class="text-[10px] text-[#607D8B] whitespace-nowrap">{{ $label }}</span>
                    </div>
                @empty
                    <p class="text-[#607D8B] text-sm text-center w-full self-center">Sin datos disponibles.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ── Top vendedores ───────────────────────────────────── -->
    <div class="bg-white rounded-2xl border border-[#E5E7EB] shadow-sm p-6">
        <h2 class="font-outfit font-bold text-[#263238] text-lg mb-1">Top Vendedores</h2>
        <p class="text-xs text-[#607D8B] mb-5">Mayor comisión generada en el período</p>
        @forelse($topSellers as $i => $seller)
            <div class="flex items-center gap-3 py-3 {{ !$loop->last ? 'border-b border-[#F3F4F6]' : '' }}">
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold
                    {{ $i === 0 ? 'bg-amber-400 text-white' : ($i === 1 ? 'bg-gray-200 text-[#607D8B]' : ($i === 2 ? 'bg-orange-200 text-orange-700' : 'bg-[#F3F4F6] text-[#607D8B]')) }}">
                    {{ $i + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-[#263238] truncate">{{ $seller->name }}</p>
                    <p class="text-[11px] text-[#607D8B]">{{ $seller->num_ordenes }} {{ $seller->num_ordenes === 1 ? 'orden' : 'órdenes' }}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-sm font-bold text-amber-600">${{ number_format($seller->comision, 2) }}</p>
                    <p class="text-[10px] text-[#607D8B]">comisión</p>
                </div>
            </div>
        @empty
            <p class="text-[#607D8B] text-sm text-center py-6">Sin datos en este período.</p>
        @endforelse
    </div>
</div>

<!-- ── Tabla de órdenes ──────────────────────────────────────── -->
<div class="bg-white rounded-2xl border border-[#E5E7EB] shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-[#E5E7EB] flex items-center justify-between">
        <h2 class="font-outfit font-bold text-[#263238]">Detalle de Órdenes</h2>
        <span class="text-xs text-[#607D8B]">{{ $orders->count() }} resultado{{ $orders->count() !== 1 ? 's' : '' }}</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-[#F8FAF7] text-[#607D8B] text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Orden</th>
                    <th class="px-4 py-3 text-left font-semibold">Comprador</th>
                    <th class="px-4 py-3 text-left font-semibold">Estado</th>
                    <th class="px-4 py-3 text-right font-semibold">Total Venta</th>
                    <th class="px-4 py-3 text-right font-semibold text-amber-700">Ganancia (5%)</th>
                    <th class="px-4 py-3 text-left font-semibold">Fecha</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#F3F4F6]">
                @forelse($orders as $order)
                    @php $commission = $order->total * 0.05; @endphp
                    <tr class="hover:bg-[#F8FAF7] transition-colors">
                        <td class="px-4 py-3 font-mono text-xs text-[#263238] font-medium">
                            <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-[#2E7D32] hover:underline">#{{ $order->order_number }}</a>
                        </td>
                        <td class="px-4 py-3 text-[#263238]">{{ $order->buyer?->name ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @php
                                $colors = ['pendiente'=>'bg-yellow-100 text-yellow-700','pagado'=>'bg-blue-100 text-blue-700','enviado'=>'bg-purple-100 text-purple-700','entregado'=>'bg-green-100 text-green-700'];
                                $bg = $colors[$order->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $bg }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="px-4 py-3 text-right font-medium text-[#263238]">${{ number_format($order->total, 2) }}</td>
                        <td class="px-4 py-3 text-right font-bold text-amber-600">${{ number_format($commission, 2) }}</td>
                        <td class="px-4 py-3 text-[#607D8B] text-xs whitespace-nowrap">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-[#607D8B]">
                            <i class='bx bx-search-alt text-4xl block mb-2 text-[#B0BEC5]'></i>
                            No hay órdenes en el período o filtro seleccionado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if($orders->count() > 0)
            <tfoot class="bg-amber-50 text-sm">
                <tr>
                    <td colspan="3" class="px-4 py-3 font-semibold text-[#263238]">Totales del período</td>
                    <td class="px-4 py-3 text-right font-bold text-[#263238]">${{ number_format($totalSales, 2) }}</td>
                    <td class="px-4 py-3 text-right font-bold text-amber-700">${{ number_format($totalCommission, 2) }}</td>
                    <td class="px-4 py-3"></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

<script>
function toggleCustomDates(val) {
    document.getElementById('custom-dates').classList.toggle('hidden', val !== 'custom');
}
</script>
@endsection
