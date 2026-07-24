@extends('layouts.admin')
@section('title', 'Gestión de Órdenes')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
    <div>
        <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Órdenes</h1>
        <p class="text-[#607D8B]">Supervisa y gestiona las ventas de la plataforma.</p>
    </div>
    
    <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="relative">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="text" name="search" placeholder="Nº de orden, cliente..." value="{{ request('search') }}"
                class="w-full md:w-64 bg-white border border-[#E5E7EB] rounded-full py-2 pl-10 pr-4 text-sm focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
            <i class='bx bx-search absolute left-3.5 top-1/2 -translate-y-1/2 text-[#607D8B] text-lg'></i>
        </form>
        
        <form action="{{ route('admin.orders.index') }}" method="GET">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <select name="status" onchange="this.form.submit()" class="w-full bg-white border border-[#E5E7EB] rounded-full py-2 px-4 text-sm focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                <option value="">Todos los estados</option>
                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-[#E5E7EB] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
            <thead>
                <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-xs text-[#607D8B] uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium">Nº Orden</th>
                    <th class="px-6 py-4 font-medium">Comprador</th>
                    <th class="px-6 py-4 font-medium">Fecha</th>
                    <th class="px-6 py-4 font-medium">Total</th>
                    <th class="px-6 py-4 font-medium text-center">Estado</th>
                    <th class="px-6 py-4 font-medium text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E7EB]">
                @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-[#263238] text-sm">
                            <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-[#2E7D32]">{{ $order->order_number }}</a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-[#263238]">{{ $order->buyer->name }}</span>
                                <span class="text-xs text-[#607D8B]">{{ $order->buyer->email }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-[#607D8B]">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-[#263238]">
                            {{ $order->formatted_total }}
                        </td>
                        <td class="px-6 py-4 text-center">
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
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="p-2 text-[#607D8B] hover:text-[#2E7D32] hover:bg-[#F8FAF7] rounded-lg transition-colors inline-block" title="Ver Detalle">
                                <i class='bx bx-show text-xl'></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $orders->links() }}
</div>
@endsection
