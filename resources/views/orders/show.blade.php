@extends('layouts.rewear')
@section('title', 'Detalle de Pedido ' . $order->order_number)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Breadcrumbs -->
    <nav class="flex text-sm text-[#607D8B] mb-8">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('home') }}" class="hover:text-[#2E7D32]">Inicio</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a href="{{ route('orders.index') }}" class="hover:text-[#2E7D32]">Mis Compras</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li class="text-[#263238] font-medium">Pedido {{ $order->order_number }}</li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Detalles Principales -->
        <div class="w-full lg:w-2/3 space-y-8">
            
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-1">Pedido #{{ $order->order_number }}</h1>
                    <p class="text-[#607D8B]">Realizado el {{ $order->created_at->isoFormat('D [de] MMMM YYYY [a las] H:mm') }}</p>
                </div>
                
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
                <div class="px-4 py-2 rounded-full font-bold uppercase tracking-wider text-sm {{ $statusColor }}">
                    {{ $order->status_label }}
                </div>
            </div>

            <!-- Items -->
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden">
                <div class="p-6 border-b border-[#E5E7EB] bg-[#F8FAF7]">
                    <h2 class="font-outfit font-semibold text-[#263238] text-lg">Artículos</h2>
                </div>
                <ul class="divide-y divide-[#E5E7EB]">
                    @foreach($order->items as $item)
                        <li class="p-6 flex flex-col sm:flex-row gap-6">
                            <div class="flex-shrink-0 w-24 aspect-[4/5] bg-gray-100 rounded-xl overflow-hidden border border-[#E5E7EB]">
                                <img src="{{ $item->product ? $item->product->cover_url : asset('images/placeholder.jpg') }}" class="w-full h-full object-cover">
                            </div>
                            
                            <div class="flex-1 flex flex-col justify-center">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-medium text-[#263238]">
                                            @if($item->product)
                                                <a href="{{ route('products.show', $item->product) }}" class="hover:text-[#2E7D32]">{{ $item->product_title }}</a>
                                            @else
                                                {{ $item->product_title }}
                                            @endif
                                        </h3>
                                        <p class="text-sm text-[#607D8B] mt-1">Vendedor: {{ $item->seller->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-[#263238]">{{ $item->formatted_unit_price }}</p>
                                        <p class="text-sm text-[#607D8B]">Cant: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Envío -->
            @if($order->shipment)
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden p-6">
                <h2 class="font-outfit font-semibold text-[#263238] text-lg mb-4">Estado del Envío</h2>
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center text-2xl">
                            <i class='bx bx-truck'></i>
                        </div>
                        <div>
                            <p class="font-medium text-[#263238]">{{ \App\Models\Shipment::$statuses[$order->shipment->status] ?? $order->shipment->status }}</p>
                            @if($order->shipment->tracking_number)
                                <p class="text-sm text-[#607D8B] mt-1">Guía: <span class="font-medium text-[#263238]">{{ $order->shipment->tracking_number }}</span></p>
                            @endif
                        </div>
                    </div>
                    @if($order->status === 'enviado')
                        <div class="w-full sm:w-auto pt-4 sm:pt-0">
                            <a href="{{ route('orders.confirm-delivery', $order) }}" class="btn-primary py-2.5 px-5 text-sm w-full text-center">
                                <i class='bx bx-check-double'></i> Confirmar Recepción
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            @endif

        </div>
        
        <!-- Sidebar Detalles -->
        <div class="w-full lg:w-1/3 space-y-6">
            
            <!-- Resumen -->
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden p-6">
                <h2 class="font-outfit font-semibold text-[#263238] text-lg mb-4">Resumen de pago</h2>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-sm text-[#607D8B]">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-[#607D8B]">
                        <span>Envío</span>
                        <span>${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                </div>
                
                <div class="border-t border-[#E5E7EB] pt-4">
                    <div class="flex justify-between items-end">
                        <span class="font-medium text-[#263238]">Total</span>
                        <span class="font-outfit font-bold text-2xl text-[#2E7D32]">{{ $order->formatted_total }}</span>
                    </div>
                </div>

                @if($order->payment)
                <div class="mt-4 pt-4 border-t border-[#E5E7EB]">
                    <p class="text-sm text-[#607D8B] flex items-center gap-2">
                        <i class='bx bx-check-shield text-[#2E7D32]'></i> Pagado con {{ ucfirst($order->payment->method) }}
                    </p>
                </div>
                @endif
            </div>

            <!-- Dirección -->
            @if($order->address)
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden p-6">
                <h2 class="font-outfit font-semibold text-[#263238] text-lg mb-4">Dirección de entrega</h2>
                
                <p class="font-medium text-[#263238] mb-1">{{ $order->address->recipient_name }}</p>
                <p class="text-sm text-[#607D8B] leading-relaxed">
                    {{ $order->address->street }} {{ $order->address->exterior_number }}
                    @if($order->address->interior_number) Int {{ $order->address->interior_number }} @endif<br>
                    Col. {{ $order->address->neighborhood }}<br>
                    {{ $order->address->city }}, {{ $order->address->state }}<br>
                    CP {{ $order->address->postal_code }}, {{ $order->address->country }}
                </p>
            </div>
            @endif

        </div>

    </div>
</div>
@endsection
