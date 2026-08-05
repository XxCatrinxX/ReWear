@extends('layouts.rewear')
@section('title', 'Mis Ventas')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Mis Ventas</h1>
            <p class="text-[#607D8B]">Gestiona los pedidos de tus compradores.</p>
        </div>
        <a href="{{ route('seller.dashboard') }}" class="btn-secondary">
            <i class='bx bx-arrow-back'></i> Volver al Panel
        </a>
    </div>

    @if($orders->count() > 0)
        <div class="bg-white rounded-3xl border border-[#E5E7EB] overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB]">
                            <th class="p-4 font-semibold text-sm text-[#263238]">Pedido</th>
                            <th class="p-4 font-semibold text-sm text-[#263238]">Comprador</th>
                            <th class="p-4 font-semibold text-sm text-[#263238]">Fecha</th>
                            <th class="p-4 font-semibold text-sm text-[#263238]">Total (Tus prendas)</th>
                            <th class="p-4 font-semibold text-sm text-[#263238]">Estado</th>
                            <th class="p-4 font-semibold text-sm text-[#263238] text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        @foreach($orders as $order)
                            @php
                                $sellerSubtotal = $order->items->sum('subtotal');
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="p-4">
                                    <span class="font-mono font-bold text-[#263238]">{{ $order->order_number }}</span>
                                </td>
                                <td class="p-4">
                                    <div class="text-sm font-semibold text-[#263238]">{{ $order->buyer->name }}</div>
                                    <div class="text-xs text-[#607D8B]">{{ $order->buyer->email }}</div>
                                </td>
                                <td class="p-4 text-sm text-[#607D8B]">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="p-4 font-semibold text-[#2E7D32]">
                                    ${{ number_format($sellerSubtotal, 2) }}
                                </td>
                                <td class="p-4">
                                    @if($order->status === 'pendiente')
                                        <span class="badge-yellow">Pendiente de Pago</span>
                                    @elseif($order->status === 'pagado')
                                        <span class="badge-green">Pagado (Listo para envío)</span>
                                    @elseif($order->status === 'enviado')
                                        <span class="badge-accent">En camino</span>
                                    @elseif($order->status === 'entregado')
                                        <span class="bg-[#2E7D32]/10 text-[#2E7D32] badge">Entregado & Liberado</span>
                                    @else
                                        <span class="badge-gray">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('seller.orders.show', $order) }}" class="inline-flex items-center gap-1 text-sm font-bold text-[#2E7D32] hover:text-[#1B5E20]">
                                        Detalles <i class='bx bx-chevron-right'></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-white border border-[#E5E7EB] rounded-3xl p-12 text-center flex flex-col items-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <i class='bx bx-package text-4xl text-[#607D8B]'></i>
            </div>
            <h2 class="font-outfit text-xl font-bold text-[#263238] mb-2">Aún no tienes ventas</h2>
            <p class="text-[#607D8B] mb-6 max-w-sm">Cuando los compradores adquieran tus prendas publicadas, aparecerán aquí.</p>
            <a href="{{ route('seller.products.create') }}" class="btn-primary">
                Publicar una prenda
            </a>
        </div>
    @endif

</div>
@endsection
