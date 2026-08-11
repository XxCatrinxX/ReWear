@extends('layouts.admin')
@section('title', 'Gestión de Reportes')

@section('content')
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-outfit text-3xl font-bold text-[#263238]">Centro de Reportes</h1>
            <p class="text-[#607D8B] mt-1">Supervisa y resuelve incidencias de publicaciones, compras y envíos.</p>
        </div>
    </div>
</div>

<!-- Alertas -->
@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 flex items-center gap-2">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
@endif

<!-- Tabs: Publicaciones vs Envíos y Pedidos -->
<div class="flex border-b border-[#E5E7EB] mb-6">
    <a href="{{ route('admin.reports.index', ['tab' => 'products']) }}"
       class="py-3 px-6 font-semibold text-sm transition flex items-center gap-2 border-b-2 {{ $tab === 'products' ? 'border-[#2E7D32] text-[#2E7D32] bg-[#2E7D32]/5 rounded-t-xl' : 'border-transparent text-[#607D8B] hover:text-[#263238]' }}">
        <i class='bx bx-flag text-lg'></i> Reportes de Publicaciones
        @if($pendingProductReports > 0)
            <span class="bg-red-500 text-white text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $pendingProductReports }}</span>
        @endif
    </a>
    <a href="{{ route('admin.reports.index', ['tab' => 'orders']) }}"
       class="py-3 px-6 font-semibold text-sm transition flex items-center gap-2 border-b-2 {{ $tab === 'orders' ? 'border-[#2E7D32] text-[#2E7D32] bg-[#2E7D32]/5 rounded-t-xl' : 'border-transparent text-[#607D8B] hover:text-[#263238]' }}">
        <i class='bx bx-package text-lg'></i> Reportes de Envíos y Compras
        @if($pendingOrderReports > 0)
            <span class="bg-red-500 text-white text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $pendingOrderReports }}</span>
        @endif
    </a>
</div>

@if($tab === 'orders')
    <!-- ═════════════════ PESTAÑA: REPORTES DE ENVÍOS Y COMPRAS ═════════════════ -->
    <div class="bg-white rounded-3xl border border-[#E5E7EB] overflow-hidden shadow-sm">
        <div class="p-6 border-b border-[#E5E7EB] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-outfit font-bold text-lg text-[#263238]">Incidencias de Envíos y Productos Recibidos</h2>
            <div class="flex gap-2 flex-wrap">
                <a href="{{ route('admin.reports.index', ['tab' => 'orders']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold {{ !$status ? 'bg-[#2E7D32] text-white' : 'bg-gray-100 text-[#607D8B]' }}">Todos</a>
                <a href="{{ route('admin.reports.index', ['tab' => 'orders', 'status' => 'pendiente']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold {{ $status === 'pendiente' ? 'bg-amber-500 text-white' : 'bg-amber-50 text-amber-700' }}">Pendientes ({{ $counts['pendiente'] }})</a>
                <a href="{{ route('admin.reports.index', ['tab' => 'orders', 'status' => 'en_revision']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold {{ $status === 'en_revision' ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-700' }}">En Revisión ({{ $counts['en_revision'] }})</a>
                <a href="{{ route('admin.reports.index', ['tab' => 'orders', 'status' => 'resuelto']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold {{ $status === 'resuelto' ? 'bg-green-600 text-white' : 'bg-green-50 text-green-700' }}">Resueltos ({{ $counts['resuelto'] }})</a>
            </div>
        </div>

        @if($reports->isEmpty())
            <div class="py-16 text-center text-[#607D8B]">
                <i class='bx bx-check-double text-5xl mb-3 block text-green-500'></i>
                <p class="font-semibold text-lg">No hay reportes de envíos con este filtro.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-[#607D8B] text-xs uppercase tracking-wider">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold">Orden / Guía</th>
                            <th class="text-left px-6 py-3 font-semibold">Tipo y Motivo</th>
                            <th class="text-left px-6 py-3 font-semibold">Comprador</th>
                            <th class="text-left px-6 py-3 font-semibold">Estado</th>
                            <th class="text-left px-6 py-3 font-semibold">Fecha</th>
                            <th class="text-right px-6 py-3 font-semibold">Gestión</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        @foreach($reports as $report)
                        <tr class="hover:bg-[#F8FAF7] transition">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders.show', $report->order) }}" class="font-mono font-bold text-[#2E7D32] hover:underline">
                                    #{{ $report->order->order_number }}
                                </a>
                                <p class="text-xs text-[#607D8B] mt-0.5 font-mono">Guía: {{ $report->order->shipment->tracking_number ?? 'RW-N/A' }}</p>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] uppercase font-bold bg-amber-100 text-amber-800 mb-1">
                                    {{ \App\Models\OrderReport::$types[$report->type] ?? ucfirst($report->type) }}
                                </span>
                                <p class="font-bold text-[#263238] text-xs">{{ $report->reason }}</p>
                                <p class="text-xs text-[#607D8B] mt-1 line-clamp-2">{{ $report->description }}</p>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                <p class="font-semibold text-[#263238]">{{ $report->user->name }}</p>
                                <p class="text-[#607D8B]">{{ $report->user->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $st = \App\Models\OrderReport::$statuses[$report->status] ?? ['label' => $report->status, 'bg' => 'bg-gray-100 text-gray-800'];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $st['bg'] }}">
                                    {{ $st['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-[#607D8B] whitespace-nowrap">
                                {{ $report->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.reports.order.update', $report) }}" class="space-y-2 text-right">
                                    @csrf @method('PATCH')
                                    <div class="flex items-center justify-end gap-2">
                                        <select name="status" class="text-xs rounded-xl border border-[#E5E7EB] px-2 py-1 bg-white">
                                            <option value="pendiente"   {{ $report->status === 'pendiente'   ? 'selected' : '' }}>Pendiente</option>
                                            <option value="en_revision" {{ $report->status === 'en_revision' ? 'selected' : '' }}>En Revisión</option>
                                            <option value="resuelto"    {{ $report->status === 'resuelto'    ? 'selected' : '' }}>Resuelto</option>
                                            <option value="desestimado" {{ $report->status === 'desestimado' ? 'selected' : '' }}>Desestimado</option>
                                        </select>
                                        <button type="submit" class="px-3 py-1 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-xs font-semibold rounded-xl transition">
                                            Guardar
                                        </button>
                                    </div>
                                    <input type="text" name="admin_notes" value="{{ $report->admin_notes }}" placeholder="Notas de resolución del admin…"
                                           class="w-full text-xs border border-[#E5E7EB] rounded-lg px-2 py-1 placeholder-gray-400">
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($reports->hasPages())
                <div class="px-6 py-4 border-t border-[#E5E7EB]">
                    {{ $reports->links() }}
                </div>
            @endif
        @endif
    </div>

@else
    <!-- ═════════════════ PESTAÑA: REPORTES DE PUBLICACIONES ═════════════════ -->
    <div class="bg-white rounded-3xl border border-[#E5E7EB] overflow-hidden shadow-sm">
        <div class="p-6 border-b border-[#E5E7EB] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-outfit font-bold text-lg text-[#263238]">Reportes de Publicaciones</h2>
            <div class="flex gap-2 flex-wrap">
                <a href="{{ route('admin.reports.index', ['tab' => 'products']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold {{ !$status ? 'bg-[#2E7D32] text-white' : 'bg-gray-100 text-[#607D8B]' }}">Todos</a>
                <a href="{{ route('admin.reports.index', ['tab' => 'products', 'status' => 'pendiente']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold {{ $status === 'pendiente' ? 'bg-amber-500 text-white' : 'bg-amber-50 text-amber-700' }}">Pendientes ({{ $counts['pendiente'] }})</a>
                <a href="{{ route('admin.reports.index', ['tab' => 'products', 'status' => 'revisado']) }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold {{ $status === 'revisado' ? 'bg-green-600 text-white' : 'bg-green-50 text-green-700' }}">Revisados ({{ $counts['revisado'] }})</a>
            </div>
        </div>

        @if($reports->isEmpty())
            <div class="py-16 text-center text-[#607D8B]">
                <i class='bx bx-check-shield text-5xl mb-3 block text-green-400'></i>
                <p class="font-semibold text-lg">No hay reportes de publicaciones con este filtro.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-[#607D8B] text-xs uppercase tracking-wider">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold">Publicación</th>
                            <th class="text-left px-6 py-3 font-semibold">Motivo</th>
                            <th class="text-left px-6 py-3 font-semibold">Reportado por</th>
                            <th class="text-left px-6 py-3 font-semibold">Estado</th>
                            <th class="text-left px-6 py-3 font-semibold">Fecha</th>
                            <th class="text-right px-6 py-3 font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        @foreach($reports as $report)
                        <tr class="hover:bg-[#F8FAF7] transition">
                            <td class="px-6 py-4">
                                @if($report->product)
                                    <a href="{{ route('products.show', $report->product) }}" target="_blank"
                                       class="font-medium text-[#263238] hover:text-[#2E7D32] transition line-clamp-1 max-w-[200px] block">
                                        {{ $report->product->title }}
                                    </a>
                                    <span class="text-xs text-[#607D8B]">por {{ $report->product->user?->name ?? '—' }}</span>
                                @else
                                    <span class="text-[#607D8B] italic text-xs">Publicación eliminada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-[#263238]">{{ $report->reason }}</p>
                                @if($report->details)
                                    <p class="text-xs text-[#607D8B] mt-0.5 max-w-[200px] line-clamp-2">{{ $report->details }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[#263238]">{{ $report->user?->name ?? '—' }}</span>
                                <br><span class="text-xs text-[#607D8B]">{{ $report->user?->email }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $badge = match($report->status) {
                                        'pendiente'   => 'bg-amber-100 text-amber-700',
                                        'revisado'    => 'bg-green-100 text-green-700',
                                        'desestimado' => 'bg-gray-100 text-gray-600',
                                        default       => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-[#607D8B] text-xs">
                                {{ $report->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.reports.update', $report) }}" class="flex items-center justify-end gap-2">
                                    @csrf @method('PATCH')
                                    <button type="submit" name="status" value="desestimado"
                                        onclick="this.form.querySelector('[name=delete_product]').value='0'"
                                        class="px-3 py-1.5 text-xs rounded-xl border border-[#E5E7EB] text-[#607D8B] hover:bg-gray-50 transition">
                                        Ignorar
                                    </button>
                                    @if($report->product)
                                    <button type="submit" name="status" value="revisado"
                                        onclick="this.form.querySelector('[name=delete_product]').value='0'"
                                        class="px-3 py-1.5 text-xs rounded-xl border border-green-300 text-green-700 hover:bg-green-50 transition">
                                        Revisado
                                    </button>
                                    <button type="submit" name="status" value="revisado"
                                        onclick="if(!confirm('¿Eliminar esta publicación?')) return false; this.form.querySelector('[name=delete_product]').value='1'"
                                        class="px-3 py-1.5 text-xs rounded-xl bg-red-500 text-white hover:bg-red-600 transition">
                                        <i class='bx bx-trash'></i> Eliminar
                                    </button>
                                    @endif
                                    <input type="hidden" name="delete_product" value="0">
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($reports->hasPages())
                <div class="px-6 py-4 border-t border-[#E5E7EB]">
                    {{ $reports->links() }}
                </div>
            @endif
        @endif
    </div>
@endif
@endsection
