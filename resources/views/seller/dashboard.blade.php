@extends('layouts.rewear')
@section('title', 'Panel de Vendedor')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Panel de Vendedor</h1>
            <p class="text-[#607D8B]">Bienvenido a tu centro de ventas, {{ auth()->user()->name }}.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('orders.index') }}" class="px-5 py-2.5 bg-white text-[#607D8B] font-semibold rounded-xl border border-[#E5E7EB] shadow-sm hover:border-[#2E7D32] hover:text-[#2E7D32] transition-colors inline-flex items-center gap-2">
                <i class='bx bx-package'></i> Mis Compras
            </a>
            <a href="{{ route('seller.products.create') }}" class="px-6 py-2.5 bg-[#2E7D32] text-white font-semibold rounded-xl shadow-soft hover:bg-[#1B5E20] transition-colors inline-flex items-center gap-2">
                <i class='bx bx-plus'></i> Nueva publicación
            </a>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-[#2E7D32]/10 text-[#2E7D32] rounded-xl flex items-center justify-center text-2xl">
                    <i class='bx bx-store-alt'></i>
                </div>
                <h3 class="font-semibold text-[#607D8B]">Productos Activos</h3>
            </div>
            <p class="font-outfit text-4xl font-bold text-[#263238]">{{ $activeProductsCount }}</p>
            <a href="{{ route('seller.products.index') }}" class="text-sm text-[#2E7D32] hover:underline mt-2 inline-block">Ver mis publicaciones</a>
        </div>
        
        <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl">
                    <i class='bx bx-package'></i>
                </div>
                <h3 class="font-semibold text-[#607D8B]">Prendas Vendidas</h3>
            </div>
            <p class="font-outfit text-4xl font-bold text-[#263238]">{{ $soldProductsCount }}</p>
            <a href="{{ route('seller.orders.index') }}" class="text-sm text-[#2E7D32] hover:underline mt-2 inline-block">Ver mis ventas</a>
        </div>
        
        <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-[#D4A373]/10 text-[#D4A373] rounded-xl flex items-center justify-center text-2xl">
                    <i class='bx bx-wallet'></i>
                </div>
                <h3 class="font-semibold text-[#607D8B]">Ingresos Simulados</h3>
            </div>
            <p class="font-outfit text-4xl font-bold text-[#263238]">${{ number_format($simulatedEarnings, 2) }}</p>
            <p class="text-sm text-[#607D8B] mt-2">En MXN</p>
        </div>
    </div>

    <!-- Banner de Membresía -->
    @php $user = auth()->user(); @endphp
    <div class="mb-8 p-5 rounded-2xl border {{ $user->hasPremiumMembership() ? 'border-amber-300 bg-amber-50' : 'border-[#E5E7EB] bg-white' }} flex items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl {{ $user->hasPremiumMembership() ? 'bg-amber-100' : 'bg-[#F8FAF7]' }} flex items-center justify-center flex-shrink-0">
                <i class='bx {{ $user->hasPremiumMembership() ? "bxs-crown text-amber-500" : "bx-user text-[#607D8B]" }} text-2xl'></i>
            </div>
            <div>
                @if($user->hasPremiumMembership())
                    <p class="font-semibold text-amber-800">Plan Premium activo <i class='bx bxs-crown text-amber-500'></i></p>
                    <p class="text-sm text-amber-700">Publicaciones ilimitadas · Vence {{ $user->membership_expires_at->format('d/m/Y') }}</p>
                @else
                    <p class="font-semibold text-[#263238]">Plan Gratuito</p>
                    <p class="text-sm text-[#607D8B]">{{ $user->publishedThisMonth() }} / 10 publicaciones este mes · Actualiza para publicar sin límites</p>
                @endif
            </div>
        </div>
        <a href="{{ route('seller.membership') }}"
           class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-semibold transition {{ $user->hasPremiumMembership() ? 'bg-amber-100 text-amber-800 hover:bg-amber-200' : 'bg-[#2E7D32] text-white hover:bg-[#1B5E20]' }}">
            {{ $user->hasPremiumMembership() ? 'Gestionar' : 'Activar Premium' }}
        </a>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Publicaciones Recientes -->
        <div class="w-full lg:w-1/2">
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden">
                <div class="px-6 py-4 border-b border-[#E5E7EB] flex justify-between items-center bg-[#F8FAF7]">
                    <h2 class="font-outfit font-semibold text-[#263238] text-lg">Tus publicaciones recientes</h2>
                    <a href="{{ route('seller.products.index') }}" class="text-sm text-[#2E7D32] hover:underline">Ver todas</a>
                </div>
                
                @if($recentProducts->count() > 0)
                    <ul class="divide-y divide-[#E5E7EB]">
                        @foreach($recentProducts as $product)
                            <li class="p-4 flex gap-4">
                                <div class="w-16 h-20 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0 border border-[#E5E7EB]">
                                    <img src="{{ $product->cover_url }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0 flex flex-col justify-center">
                                    <h3 class="font-medium text-[#263238] truncate">{{ $product->title }}</h3>
                                    <p class="text-sm text-[#607D8B] mb-1">{{ $product->formatted_price }} • Stock: {{ $product->stock }}</p>
                                    <div>
                                        @if($product->is_sold)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Vendido</span>
                                        @elseif($product->is_active)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Activo</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">Inactivo</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <a href="{{ route('seller.products.edit', $product) }}" class="p-2 text-[#607D8B] hover:text-[#2E7D32] hover:bg-[#F8FAF7] rounded-lg transition-colors">
                                        <i class='bx bx-edit text-xl'></i>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-8 text-center text-[#607D8B]">
                        <p>Aún no tienes publicaciones.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Ventas Recientes -->
        <div class="w-full lg:w-1/2">
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden">
                <div class="px-6 py-4 border-b border-[#E5E7EB] flex justify-between items-center bg-[#F8FAF7]">
                    <h2 class="font-outfit font-semibold text-[#263238] text-lg">Tus ventas recientes</h2>
                    <a href="{{ route('seller.orders.index') }}" class="text-sm text-[#2E7D32] hover:underline">Ver todas</a>
                </div>
                
                @if($recentSales->count() > 0)
                    <ul class="divide-y divide-[#E5E7EB]">
                        @foreach($recentSales as $sale)
                            <li>
                                <a href="{{ route('seller.orders.show', $sale->order) }}" class="p-4 flex gap-4 hover:bg-gray-50 transition-colors">
                                    <div class="w-16 h-20 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0 border border-[#E5E7EB]">
                                        <img src="{{ $sale->product_image ? asset('storage/' . $sale->product_image) : asset('images/placeholder.jpg') }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-grow min-w-0 flex flex-col justify-center text-left">
                                        <h3 class="font-medium text-[#263238] truncate">{{ $sale->product_title }}</h3>
                                        <p class="text-sm text-[#607D8B] mb-1">Orden: #{{ $sale->order->order_number }}</p>
                                        <p class="font-medium text-[#2E7D32]">${{ number_format($sale->subtotal, 2) }} <span class="text-xs text-[#607D8B] font-normal">({{ $sale->quantity }}x)</span></p>
                                    </div>
                                    <div class="flex items-center text-gray-400">
                                        <i class='bx bx-chevron-right text-2xl'></i>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-8 text-center text-[#607D8B]">
                        <p>Aún no tienes ventas registradas.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
