@extends('footer._layout')

@section('page-icon')<i class="bx bx-help-circle text-3xl text-white"></i>@endsection
@section('page-subtitle', 'Compra y vende ropa de segunda mano de manera simple, segura y sustentable.')

@section('page-content')
<div class="text-[#455A64] leading-relaxed">

    {{-- Steps --}}
    <div class="grid md:grid-cols-3 gap-8 mb-16">
        <div class="text-center group">
            <div class="w-16 h-16 bg-gradient-to-br from-[#2E7D32] to-[#43A047] rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-105 transition-transform">
                <i class="bx bx-search text-3xl text-white"></i>
            </div>
            <h3 class="font-outfit font-bold text-lg text-[#263238] mb-2">1. Explora el Catálogo</h3>
            <p class="text-sm">Navega miles de prendas de segunda mano. Filtra por talla, categoría, precio o condición hasta encontrar lo que buscas.</p>
        </div>
        <div class="text-center group">
            <div class="w-16 h-16 bg-gradient-to-br from-[#2E7D32] to-[#43A047] rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-105 transition-transform">
                <i class="bx bx-credit-card text-3xl text-white"></i>
            </div>
            <h3 class="font-outfit font-bold text-lg text-[#263238] mb-2">2. Compra de Forma Segura</h3>
            <p class="text-sm">Tu pago queda retenido de manera segura. El vendedor no recibe el dinero hasta que tú confirmes haber recibido el producto.</p>
        </div>
        <div class="text-center group">
            <div class="w-16 h-16 bg-gradient-to-br from-[#2E7D32] to-[#43A047] rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-105 transition-transform">
                <i class="bx bx-package text-3xl text-white"></i>
            </div>
            <h3 class="font-outfit font-bold text-lg text-[#263238] mb-2">3. Recibe tu Pedido</h3>
            <p class="text-sm">El vendedor prepara y envía tu pedido con etiqueta de rastreo. Al recibirlo, confirmas la entrega y los fondos se liberan.</p>
        </div>
    </div>

    <div class="border-t border-[#E5E7EB] pt-12">
        <h2 class="text-2xl font-outfit font-bold text-[#263238] mb-8 text-center">¿Por qué elegir ReWear?</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="flex gap-4 p-5 bg-[#F8FAF7] rounded-2xl">
                <div class="w-10 h-10 bg-[#E8F5E9] rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="bx bx-shield-quarter text-[#2E7D32] text-xl"></i>
                </div>
                <div>
                    <h4 class="font-outfit font-semibold text-[#263238] mb-1">Pago Seguro</h4>
                    <p class="text-sm">Tu dinero está protegido en todo momento. Solo se libera al vendedor cuando confirmas la recepción.</p>
                </div>
            </div>
            <div class="flex gap-4 p-5 bg-[#F8FAF7] rounded-2xl">
                <div class="w-10 h-10 bg-[#E8F5E9] rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="bx bx-leaf text-[#2E7D32] text-xl"></i>
                </div>
                <div>
                    <h4 class="font-outfit font-semibold text-[#263238] mb-1">Moda Sustentable</h4>
                    <p class="text-sm">Cada compra extiende la vida útil de una prenda y reduce el impacto ambiental de la industria textil.</p>
                </div>
            </div>
            <div class="flex gap-4 p-5 bg-[#F8FAF7] rounded-2xl">
                <div class="w-10 h-10 bg-[#E8F5E9] rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="bx bx-chat text-[#2E7D32] text-xl"></i>
                </div>
                <div>
                    <h4 class="font-outfit font-semibold text-[#263238] mb-1">Chat con el Vendedor</h4>
                    <p class="text-sm">Resuelve tus dudas directamente con el vendedor antes y durante el proceso de compra.</p>
                </div>
            </div>
            <div class="flex gap-4 p-5 bg-[#F8FAF7] rounded-2xl">
                <div class="w-10 h-10 bg-[#E8F5E9] rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="bx bx-star text-[#2E7D32] text-xl"></i>
                </div>
                <div>
                    <h4 class="font-outfit font-semibold text-[#263238] mb-1">Comunidad de Confianza</h4>
                    <p class="text-sm">Perfiles verificados y sistema de calificaciones para que siempre sepas con quién estás tratando.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-12 text-center">
        <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2E7D32] to-[#43A047] text-white font-outfit font-semibold px-8 py-3.5 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all">
            <i class="bx bx-store"></i>
            Explorar el Catálogo
        </a>
    </div>
</div>
@endsection
