@extends('layouts.admin')
@section('title', 'Detalle Orden ' . $order->order_number)

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <nav class="flex text-sm text-[#607D8B] mb-2">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-[#2E7D32]">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a href="{{ route('admin.orders.index') }}" class="hover:text-[#2E7D32]">Órdenes</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li class="text-[#263238] font-medium">{{ $order->order_number }}</li>
            </ol>
        </nav>
        <h1 class="font-outfit text-3xl font-bold text-[#263238]">Orden #{{ $order->order_number }}</h1>
    </div>
    
    <!-- Cambiar Estado -->
    <div class="bg-white p-2 rounded-xl shadow-sm border border-[#E5E7EB] flex items-center gap-3">
        <span class="text-sm font-medium text-[#607D8B] pl-2">Estado:</span>
        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex items-center gap-2">
            @csrf
            @method('PATCH')
            <select name="status" class="bg-[#F8FAF7] border-[#E5E7EB] rounded-lg py-1.5 pl-3 pr-8 text-sm font-medium text-[#263238] focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-[#2E7D32] text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-[#1B5E20] transition-colors">
                Actualizar
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2 space-y-8">
        <!-- Items -->
        <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden">
            <div class="px-6 py-4 border-b border-[#E5E7EB] bg-[#F8FAF7]">
                <h2 class="font-outfit font-semibold text-[#263238] text-lg">Artículos en la orden</h2>
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
                                            <a href="{{ route('products.show', $item->product) }}" target="_blank" class="hover:text-[#2E7D32]">{{ $item->product_title }}</a>
                                        @else
                                            {{ $item->product_title }}
                                        @endif
                                    </h3>
                                    <p class="text-sm text-[#607D8B] mt-1">
                                        Vendedor: <a href="{{ route('admin.users.index', ['search' => $item->seller->email]) }}" class="hover:text-[#2E7D32] underline">{{ $item->seller->name }}</a>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-[#263238]">{{ $item->formatted_unit_price }}</p>
                                    <p class="text-sm text-[#607D8B]">Cant: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <div class="mt-2 text-right text-[#2E7D32] font-semibold text-sm">
                                Subtotal: {{ $item->formatted_subtotal }}
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        
        <!-- Detalles Transacción -->
        <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden">
            <div class="px-6 py-4 border-b border-[#E5E7EB] bg-[#F8FAF7]">
                <h2 class="font-outfit font-semibold text-[#263238] text-lg">Detalles de la transacción</h2>
            </div>
            <div class="p-6">
                @if($order->payment)
                    <div class="grid grid-cols-2 gap-y-4 text-sm">
                        <div>
                            <span class="block text-[#607D8B] mb-1">ID Transacción</span>
                            <span class="font-medium text-[#263238] font-mono">{{ $order->payment->transaction_id }}</span>
                        </div>
                        <div>
                            <span class="block text-[#607D8B] mb-1">Método</span>
                            <span class="font-medium text-[#263238] capitalize">{{ $order->payment->method }}</span>
                        </div>
                        <div>
                            <span class="block text-[#607D8B] mb-1">Estado de pago</span>
                            <span class="font-medium text-[#263238] capitalize">{{ $order->payment->status }}</span>
                        </div>
                        <div>
                            <span class="block text-[#607D8B] mb-1">Fecha de pago</span>
                            <span class="font-medium text-[#263238]">{{ $order->payment->paid_at?->format('d/m/Y H:i') ?? 'N/A' }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-[#607D8B]">No hay información de pago disponible.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="space-y-8">
        
        <!-- Resumen Finanzas -->
        <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden p-6">
            <h2 class="font-outfit font-semibold text-[#263238] text-lg mb-4">Finanzas</h2>
            
            <div class="space-y-3 mb-4">
                <div class="flex justify-between text-sm text-[#607D8B]">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm text-[#607D8B]">
                    <span>Envío cobrado al cliente</span>
                    <span>${{ number_format($order->shipping_cost, 2) }}</span>
                </div>
            </div>
            
            <div class="border-t border-[#E5E7EB] pt-4">
                <div class="flex justify-between items-end">
                    <span class="font-medium text-[#263238]">Total</span>
                    <span class="font-outfit font-bold text-2xl text-[#2E7D32]">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        <!-- Cliente -->
        <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden p-6">
            <h2 class="font-outfit font-semibold text-[#263238] text-lg mb-4">Cliente</h2>
            
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ $order->buyer->avatar_url }}" class="w-12 h-12 rounded-full border border-[#E5E7EB]">
                <div>
                    <p class="font-medium text-[#263238]">{{ $order->buyer->name }}</p>
                    <p class="text-sm text-[#607D8B]"><a href="mailto:{{ $order->buyer->email }}" class="hover:underline hover:text-[#2E7D32]">{{ $order->buyer->email }}</a></p>
                </div>
            </div>
            
            <a href="{{ route('admin.users.index', ['search' => $order->buyer->email]) }}" class="text-sm text-[#2E7D32] hover:underline font-medium">Ver perfil del usuario</a>
        </div>

        <!-- Envío -->
        <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden p-6">
            <h2 class="font-outfit font-semibold text-[#263238] text-lg mb-4">Dirección de Envío</h2>
            
            @if($order->address)
                <p class="font-medium text-[#263238] mb-1">{{ $order->address->recipient_name }}</p>
                <p class="text-sm text-[#607D8B] leading-relaxed mb-4">
                    {{ $order->address->street }} {{ $order->address->exterior_number }}
                    @if($order->address->interior_number) Int {{ $order->address->interior_number }} @endif<br>
                    Col. {{ $order->address->neighborhood }}<br>
                    {{ $order->address->city }}, {{ $order->address->state }}<br>
                    CP {{ $order->address->postal_code }}, {{ $order->address->country }}
                </p>
                @if($order->address->phone)
                    <p class="text-sm text-[#607D8B]"><i class='bx bx-phone'></i> {{ $order->address->phone }}</p>
                @endif
            @else
                <p class="text-sm text-[#607D8B]">Sin dirección registrada.</p>
            @endif
            
            @if($order->notes)
                <div class="mt-4 pt-4 border-t border-[#E5E7EB]">
                    <h3 class="text-xs font-bold text-[#607D8B] uppercase tracking-wider mb-2">Notas del cliente</h3>
                    <p class="text-sm text-[#263238] bg-[#F8FAF7] p-3 rounded-xl border border-[#E5E7EB]">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
