@extends('layouts.rewear')
@section('title', 'Detalle de Venta ' . $order->order_number)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="font-outfit text-3xl font-bold text-[#263238]">Venta #{{ $order->order_number }}</h1>
                @if($order->status === 'pagado')
                    <span class="bg-[#2E7D32]/10 text-[#2E7D32] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Listo para enviar</span>
                @elseif($order->status === 'enviado')
                    <span class="bg-[#D4A373]/10 text-[#D4A373] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">En camino</span>
                @elseif($order->status === 'entregado')
                    <span class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Entregado</span>
                @endif
            </div>
            <p class="text-sm text-[#607D8B] mt-1">Realizado el {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('seller.orders.index') }}" class="btn-secondary">
                Volver
            </a>
            @if($order->status === 'pagado')
                <a href="{{ route('seller.orders.label', $order) }}" target="_blank" class="btn-secondary bg-[#D4A373]/10 text-[#D4A373] border-[#D4A373]/20 hover:bg-[#D4A373]/20 font-bold">
                    <i class='bx bx-printer'></i> 1. Imprimir Etiqueta QR
                </a>
                <form action="{{ route('seller.orders.ship', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary font-bold">
                        <i class='bx bx-send'></i> 2. Marcar como Enviado
                    </button>
                </form>
            @elseif($order->status === 'enviado' || $order->status === 'entregado')
                <a href="{{ route('seller.orders.label', $order) }}" target="_blank" class="btn-secondary bg-[#D4A373]/10 text-[#D4A373] border-[#D4A373]/20 hover:bg-[#D4A373]/20">
                    <i class='bx bx-printer'></i> Imprimir Etiqueta QR
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Detalles de las prendas vendidas -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-[#E5E7EB] p-6 shadow-sm">
                <h3 class="font-outfit font-semibold text-lg text-[#263238] mb-4 pb-2 border-b border-[#E5E7EB]">
                    Prendas de tu propiedad vendidas
                </h3>
                <ul class="divide-y divide-[#E5E7EB]">
                    @foreach($order->items as $item)
                        <li class="py-4 flex gap-4">
                            <img src="{{ $item->product->cover_url }}" class="w-16 h-20 rounded-xl object-cover bg-gray-50 flex-shrink-0 border border-[#E5E7EB]">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-sm text-[#263238] truncate">{{ $item->product_title }}</h4>
                                <p class="text-xs text-[#607D8B] mt-1">Talla: {{ $item->product->size ?? 'N/A' }} | Color: {{ $item->product->color ?? 'N/A' }}</p>
                                <p class="text-xs text-[#607D8B]">Cant: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-[#263238]">${{ number_format($item->subtotal, 2) }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                
                <div class="border-t border-[#E5E7EB] pt-4 mt-4 flex justify-between items-center">
                    <span class="font-semibold text-sm text-[#607D8B]">Tus ganancias totales</span>
                    <span class="font-outfit font-bold text-2xl text-[#2E7D32]">${{ number_format($order->items->sum('subtotal'), 2) }}</span>
                </div>
            </div>

            @if($order->status === 'enviado')
                <div class="bg-yellow-50 border border-yellow-100 rounded-3xl p-6 text-yellow-800 flex gap-4">
                    <i class='bx bx-time-five text-3xl text-yellow-600 flex-shrink-0'></i>
                    <div>
                        <p class="font-bold mb-1">Esperando confirmación del comprador</p>
                        <p class="text-sm">
                            Ya marcaste este pedido como enviado. Imprime la etiqueta y pégala en el paquete. Cuando el comprador reciba su paquete, debe escanear el código QR para liberar tu dinero.
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Información del comprador y envío -->
        <div class="space-y-6">
            <!-- Datos del Comprador -->
            <div class="bg-white rounded-3xl border border-[#E5E7EB] p-6 shadow-sm">
                <h3 class="font-outfit font-semibold text-md text-[#263238] mb-4 pb-2 border-b border-[#E5E7EB]">
                    Datos del Comprador
                </h3>
                <div class="space-y-2 text-sm text-[#607D8B]">
                    <p class="font-semibold text-[#263238]">{{ $order->buyer->name }}</p>
                    <p><i class='bx bx-envelope align-middle mr-1'></i> {{ $order->buyer->email }}</p>
                    <p><i class='bx bx-phone align-middle mr-1'></i> {{ $order->address->phone ?? 'Sin teléfono' }}</p>
                </div>
            </div>

            <!-- Dirección de Envío -->
            <div class="bg-white rounded-3xl border border-[#E5E7EB] p-6 shadow-sm">
                <h3 class="font-outfit font-semibold text-md text-[#263238] mb-4 pb-2 border-b border-[#E5E7EB]">
                    Dirección de Envío
                </h3>
                <div class="text-xs text-[#607D8B] leading-relaxed">
                    <p class="font-semibold text-sm text-[#263238] mb-2">{{ $order->address->recipient_name }}</p>
                    <p>{{ $order->address->street }} {{ $order->address->exterior_number }} 
                       @if($order->address->interior_number) Int {{ $order->address->interior_number }} @endif</p>
                    <p>Col. {{ $order->address->neighborhood }}</p>
                    <p>{{ $order->address->city }}, {{ $order->address->state }}</p>
                    <p class="font-bold mt-1">C.P. {{ $order->address->postal_code }}</p>
                </div>
            </div>

            <!-- Estado de Envío -->
            <div class="bg-white rounded-3xl border border-[#E5E7EB] p-6 shadow-sm">
                <h3 class="font-outfit font-semibold text-md text-[#263238] mb-4 pb-2 border-b border-[#E5E7EB]">
                    Detalles del Envío
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-[#607D8B]">Transportista:</span>
                        <span class="font-semibold text-[#263238]">{{ $order->shipment->carrier ?? 'Sin asignar' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#607D8B]">Código de rastreo:</span>
                        <span class="font-mono font-semibold text-[#263238]">{{ $order->shipment->tracking_number ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#607D8B]">Estado de envío:</span>
                        <span class="font-semibold text-[#2E7D32]">{{ ucfirst($order->shipment->status ?? 'Sin asignar') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
