@extends('layouts.rewear')
@section('title', 'Mi Carrito')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-8">
        <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Mi Carrito</h1>
        <p class="text-[#607D8B]">Revisa los productos que has agregado antes de proceder al pago.</p>
    </div>

    @if($cart->items->count() > 0)
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Lista de items -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden">
                    <div class="p-6">
                        <ul class="divide-y divide-[#E5E7EB]">
                            @foreach($cart->items as $item)
                                <li class="py-6 flex flex-col sm:flex-row gap-6">
                                    <a href="{{ route('products.show', $item->product) }}" class="flex-shrink-0 w-32 aspect-[4/5] bg-gray-100 rounded-xl overflow-hidden border border-[#E5E7EB]">
                                        <img src="{{ $item->product->cover_url }}" alt="{{ $item->product->title }}" class="w-full h-full object-cover">
                                    </a>
                                    
                                    <div class="flex-1 flex flex-col">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h3 class="font-medium text-[#263238] hover:text-[#2E7D32] transition-colors line-clamp-2">
                                                    <a href="{{ route('products.show', $item->product) }}">{{ $item->product->title }}</a>
                                                </h3>
                                                <p class="text-sm text-[#607D8B] mt-1">Vendedor: {{ $item->product->user->name }}</p>
                                            </div>
                                            <p class="font-bold text-[#2E7D32] text-lg whitespace-nowrap ml-4">
                                                {{ $item->formatted_subtotal }}
                                            </p>
                                        </div>
                                        
                                        <div class="mt-auto pt-4 flex items-center justify-between">
                                            <!-- Selector de cantidad -->
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center border border-[#E5E7EB] rounded-lg bg-[#F8FAF7]">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="w-8 h-8 flex items-center justify-center text-[#607D8B] hover:text-[#263238] hover:bg-gray-100 rounded-l-lg transition-colors">
                                                    <i class='bx bx-minus'></i>
                                                </button>
                                                <span class="w-8 text-center text-sm font-medium text-[#263238]">{{ $item->quantity }}</span>
                                                <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }} class="w-8 h-8 flex items-center justify-center text-[#607D8B] hover:text-[#263238] hover:bg-gray-100 rounded-r-lg transition-colors disabled:opacity-50">
                                                    <i class='bx bx-plus'></i>
                                                </button>
                                            </form>
                                            
                                            <!-- Botón eliminar -->
                                            <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-[#E53935] hover:text-red-700 text-sm font-medium flex items-center gap-1 transition-colors px-3 py-1.5 rounded-lg hover:bg-red-50">
                                                    <i class='bx bx-trash'></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Resumen del pedido -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden sticky top-24">
                    <div class="p-6">
                        <h2 class="font-outfit font-semibold text-[#263238] text-xl mb-6">Resumen del pedido</h2>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-sm text-[#607D8B]">
                                <span>Subtotal ({{ $cart->items->sum('quantity') }} artículos)</span>
                                <span>{{ $cart->formatted_total }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-[#607D8B]">
                                <span>Envío estimado</span>
                                <span class="text-[#2E7D32] font-medium">Gratis</span>
                            </div>
                        </div>
                        
                        <div class="border-t border-[#E5E7EB] pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-[#263238]">Total</span>
                                <span class="font-bold text-2xl text-[#2E7D32]">{{ $cart->formatted_total }}</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="block w-full bg-[#2E7D32] text-white text-center font-semibold py-3.5 rounded-xl shadow-soft hover:bg-[#1B5E20] transition-colors">
                            Proceder al pago
                        </a>
                        
                        <div class="mt-4 flex items-center justify-center gap-2 text-xs text-[#607D8B]">
                            <i class='bx bx-lock-alt text-base'></i>
                            Pago 100% seguro y garantizado
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    @else
        <!-- Carrito vacío -->
        <div class="bg-white border border-[#E5E7EB] rounded-3xl p-12 text-center flex flex-col items-center">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <i class='bx bx-shopping-bag text-5xl text-[#607D8B]'></i>
            </div>
            <h2 class="font-outfit text-2xl font-bold text-[#263238] mb-2">Tu carrito está vacío</h2>
            <p class="text-[#607D8B] mb-8 max-w-md mx-auto">Parece que aún no has agregado ninguna prenda a tu carrito. ¡Explora nuestro catálogo y encuentra piezas increíbles!</p>
            <a href="{{ route('catalog') }}" class="px-8 py-3.5 bg-[#2E7D32] text-white font-semibold rounded-full shadow-soft hover:bg-[#1B5E20] transition-colors inline-flex items-center gap-2">
                Explorar catálogo
            </a>
        </div>
    @endif
</div>
@endsection
