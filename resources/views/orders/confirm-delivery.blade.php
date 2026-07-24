@extends('layouts.rewear')
@section('title', 'Confirmar Entrega ' . $order->order_number)

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="bg-white border border-[#E5E7EB] rounded-3xl p-6 sm:p-8 shadow-soft text-center flex flex-col items-center">
        
        <div class="w-20 h-20 bg-green-50 text-[#2E7D32] rounded-full flex items-center justify-center text-4xl mb-6 shadow-sm">
            <i class='bx bx-check-shield'></i>
        </div>

        <h1 class="font-outfit text-2xl sm:text-3xl font-bold text-[#263238] mb-2">¿Recibiste tu paquete?</h1>
        <p class="text-[#607D8B] mb-6 text-sm">
            Estás confirmando que has recibido las prendas físicas del pedido <strong class="font-mono text-[#263238]">{{ $order->order_number }}</strong>.
        </p>

        <!-- Resumen de prendas -->
        <div class="w-full bg-[#F8FAF7] border border-[#E5E7EB] rounded-2xl p-4 mb-6 text-left">
            <h4 class="font-bold text-xs uppercase tracking-wider text-[#607D8B] mb-3">Prendas en este envío:</h4>
            <ul class="space-y-3">
                @foreach($order->items as $item)
                    <li class="flex items-center gap-3">
                        <img src="{{ $item->product->cover_url }}" class="w-10 h-12 rounded-lg object-cover bg-white border">
                        <div class="flex-grow min-w-0">
                            <p class="text-sm font-semibold text-[#263238] truncate">{{ $item->product_title }}</p>
                            <p class="text-xs text-[#607D8B]">Talla: {{ $item->product->size ?? 'N/A' }} | Vendedor: {{ $item->product->user->name }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 text-blue-800 text-xs mb-8 text-left leading-relaxed">
            <p class="font-bold mb-1"><i class='bx bx-info-circle align-middle mr-1'></i> Al hacer clic en confirmar:</p>
            <ul class="list-disc pl-4 space-y-1">
                <li>Liberas el pago directamente a la billetera del vendedor.</li>
                <li>Marcarás el envío como entregado con éxito.</li>
                <li>Esta operación es irreversible y finaliza el proceso de compra segura.</li>
            </ul>
        </div>

        <form action="{{ route('orders.confirm-delivery.store', $order) }}" method="POST" class="w-full">
            @csrf
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('orders.show', $order) }}" class="btn-secondary flex-1">
                    No, aún no lo tengo
                </a>
                <button type="submit" class="btn-primary flex-1">
                    Sí, confirmar recibido
                </button>
            </div>
        </form>

    </div>

</div>
@endsection
