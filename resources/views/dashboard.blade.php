@extends('layouts.rewear')
@section('title', 'Mi Panel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-8">
        <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Hola, {{ auth()->user()->first_name ?? auth()->user()->name }}</h1>
        <p class="text-[#607D8B]">Bienvenido a tu panel de control.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Tarjeta: Compras -->
        <a href="{{ route('orders.index') }}" class="group bg-white rounded-3xl p-6 shadow-sm border border-[#E5E7EB] hover:border-[#2E7D32] transition-colors relative overflow-hidden block">
            <div class="relative z-10">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                    <i class='bx bx-shopping-bag'></i>
                </div>
                <h3 class="font-bold text-[#263238] text-lg mb-1">Mis Compras</h3>
                <p class="text-sm text-[#607D8B]">Rastrea tus pedidos y mira tu historial</p>
            </div>
        </a>
        
        <!-- Tarjeta: Favoritos -->
        <a href="{{ route('favorites.index') }}" class="group bg-white rounded-3xl p-6 shadow-sm border border-[#E5E7EB] hover:border-red-500 transition-colors relative overflow-hidden block">
            <div class="relative z-10">
                <div class="w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                    <i class='bx bx-heart'></i>
                </div>
                <h3 class="font-bold text-[#263238] text-lg mb-1">Favoritos</h3>
                <p class="text-sm text-[#607D8B]">Prendas que te gustaron ({{ auth()->user()->favorites()->count() }})</p>
            </div>
        </a>
        
        <!-- Tarjeta: Configuración -->
        <a href="{{ route('profile.edit') }}" class="group bg-white rounded-3xl p-6 shadow-sm border border-[#E5E7EB] hover:border-[#263238] transition-colors relative overflow-hidden block">
            <div class="relative z-10">
                <div class="w-12 h-12 bg-gray-100 text-[#263238] rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                    <i class='bx bx-cog'></i>
                </div>
                <h3 class="font-bold text-[#263238] text-lg mb-1">Configuración</h3>
                <p class="text-sm text-[#607D8B]">Dirección, contraseña e info personal</p>
            </div>
        </a>

    </div>
    
    @if(auth()->user()->isSeller())
        <div class="bg-[#F8FAF7] border border-[#2E7D32]/20 rounded-3xl p-6 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#2E7D32]/10 text-[#2E7D32] rounded-full flex items-center justify-center text-2xl flex-shrink-0">
                    <i class='bx bx-store-alt'></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#263238]">Panel de Vendedor</h3>
                    <p class="text-sm text-[#607D8B]">Gestiona tus publicaciones, ventas y ganancias.</p>
                </div>
            </div>
            <a href="{{ route('seller.dashboard') }}" class="w-full sm:w-auto px-6 py-2.5 bg-[#2E7D32] text-white font-semibold rounded-xl shadow-soft hover:bg-[#1B5E20] transition-colors text-center whitespace-nowrap">
                Ir a mi tienda
            </a>
        </div>
    @else
        <div class="bg-gradient-to-r from-[#2E7D32]/10 to-[#D4A373]/10 border border-[#2E7D32]/20 rounded-3xl p-8 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex-1">
                <span class="inline-block px-3 py-1 bg-white rounded-full text-xs font-bold text-[#2E7D32] uppercase tracking-wider mb-3 shadow-sm">Gana dinero</span>
                <h3 class="font-outfit font-bold text-[#263238] text-2xl mb-2">Vende la ropa que ya no usas</h3>
                <p class="text-[#607D8B] max-w-lg">Dale una segunda vida a tus prendas, ayuda al medio ambiente y obtén ingresos extra fácilmente. ¡Conviértete en vendedor hoy mismo!</p>
            </div>
            <a href="{{ route('profile.become-seller') }}" class="w-full md:w-auto px-8 py-3.5 bg-[#2E7D32] text-white font-semibold rounded-full shadow-soft hover:bg-[#1B5E20] transition-colors flex items-center justify-center gap-2">
                <i class='bx bx-store-alt text-lg'></i> Convertirme en vendedor
            </a>
        </div>
    @endif

</div>
@endsection
