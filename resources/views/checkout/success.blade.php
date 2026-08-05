@extends('layouts.rewear')
@section('title', '¡Compra Exitosa!')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    
    <div class="w-24 h-24 bg-[#2E7D32]/10 text-[#2E7D32] rounded-full flex items-center justify-center mx-auto mb-8 border-4 border-[#2E7D32]/20">
        <i class='bx bx-check text-6xl'></i>
    </div>
    
    <h1 class="font-outfit text-4xl font-bold text-[#263238] mb-4">¡Gracias por tu compra!</h1>
    <p class="text-lg text-[#607D8B] mb-8">Tu pedido ha sido procesado exitosamente. Le hemos notificado a los vendedores para que preparen tu paquete.</p>
    
    <div class="bg-white border border-[#E5E7EB] rounded-3xl p-6 md:p-8 max-w-xl mx-auto text-left shadow-sm mb-10">
        <div class="flex justify-between items-center border-b border-[#E5E7EB] pb-4 mb-4">
            <span class="text-[#607D8B]">Número de orden</span>
            <span class="font-bold text-[#263238]">{{ $order->order_number }}</span>
        </div>
        
        <div class="flex justify-between items-center border-b border-[#E5E7EB] pb-4 mb-4">
            <span class="text-[#607D8B]">Total pagado</span>
            <span class="font-bold text-[#2E7D32]">{{ $order->formatted_total }}</span>
        </div>
        
        <div class="flex justify-between items-center pb-2">
            <span class="text-[#607D8B]">Método de pago</span>
            <span class="font-medium text-[#263238] capitalize">{{ $order->payment->method }}</span>
        </div>
    </div>
    
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('orders.show', $order) }}" class="px-8 py-3.5 bg-[#2E7D32] text-white font-semibold rounded-full shadow-soft hover:bg-[#1B5E20] transition-colors">
            Ver detalle del pedido
        </a>
        <a href="{{ route('catalog') }}" class="px-8 py-3.5 bg-white border-2 border-[#E5E7EB] text-[#263238] font-semibold rounded-full hover:bg-gray-50 transition-colors">
            Seguir comprando
        </a>
    </div>

</div>
@endsection
