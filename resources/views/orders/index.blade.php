@extends('layouts.rewear')
@section('title', 'Mis Compras')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Mis Compras</h1>
            <p class="text-[#607D8B]">Historial de todas tus compras en ReWear.</p>
        </div>
    </div>

    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden">
                    <!-- Header del pedido -->
                    <div class="bg-[#F8FAF7] border-b border-[#E5E7EB] px-6 py-4 flex flex-col md:flex-row justify-between md:items-center gap-4">
                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-10">
                            <div>
                                <p class="text-xs text-[#607D8B] uppercase tracking-wider mb-1">Fecha de pedido</p>
                                <p class="font-medium text-[#263238]">{{ $order->created_at->isoFormat('D [de] MMMM YYYY') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-[#607D8B] uppercase tracking-wider mb-1">Total</p>
                                <p class="font-medium text-[#263238]">{{ $order->formatted_total }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-[#607D8B] uppercase tracking-wider mb-1">Nº Orden</p>
                                <p class="font-medium text-[#263238]">{{ $order->order_number }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            @if($order->status === 'enviado')
                                <a href="{{ route('orders.confirm-delivery', $order) }}" class="inline-flex items-center gap-1 bg-[#2E7D32] text-white hover:bg-[#1B5E20] px-4 py-2 rounded-xl text-sm font-semibold transition-colors shadow-sm">
                                    <i class='bx bx-qr-scan text-base'></i> Recibir pedido
                                </a>
                            @endif
                            <a href="{{ route('orders.show', $order) }}" class="inline-block border border-[#2E7D32] text-[#2E7D32] hover:bg-[#2E7D32] hover:text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                                Ver detalle
                            </a>
                        </div>
                    </div>

                    <!-- Items del pedido -->
                    <div class="p-6">
                        <div class="mb-4">
                            @php
                                $statusColor = match($order->status) {
                                    'pendiente' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'pagado' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'enviado' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                    'entregado' => 'bg-green-100 text-green-800 border-green-200',
                                    'cancelado' => 'bg-red-100 text-red-800 border-red-200',
                                    default => 'bg-gray-100 text-gray-800 border-gray-200',
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider border {{ $statusColor }}">
                                Estado: {{ $order->status_label }}
                            </span>
                        </div>

                        <div class="flex flex-col gap-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-4">
                                    <div class="w-20 h-24 rounded-lg overflow-hidden border border-[#E5E7EB] flex-shrink-0">
                                        <!-- En un caso real mostraríamos la foto original o un placeholder si se borró -->
                                        <img src="{{ $item->product ? $item->product->cover_url : asset('images/placeholder.jpg') }}" alt="" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-[#263238] mb-1">
                                            @if($item->product)
                                                <a href="{{ route('products.show', $item->product) }}" class="hover:text-[#2E7D32]">{{ $item->product_title }}</a>
                                            @else
                                                {{ $item->product_title }}
                                            @endif
                                        </h3>
                                        <p class="text-sm text-[#607D8B]">Vendedor: {{ $item->seller->name }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-white border border-[#E5E7EB] rounded-3xl p-12 text-center flex flex-col items-center">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <i class='bx bx-package text-5xl text-[#607D8B]'></i>
            </div>
            <h2 class="font-outfit text-2xl font-bold text-[#263238] mb-2">Aún no tienes compras</h2>
            <p class="text-[#607D8B] mb-8">Cuando realices una compra, aparecerá aquí su historial y estado.</p>
            <a href="{{ route('catalog') }}" class="px-8 py-3.5 bg-[#2E7D32] text-white font-semibold rounded-full shadow-soft hover:bg-[#1B5E20] transition-colors inline-flex items-center gap-2">
                Explorar catálogo
            </a>
        </div>
    @endif

</div>
@endsection
