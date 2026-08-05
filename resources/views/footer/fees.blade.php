@extends('footer._layout')

@section('page-icon')<i class="bx bx-money text-3xl text-white"></i>@endsection
@section('page-subtitle', 'Transparencia total en nuestra estructura de comisiones.')

@section('page-content')
<div class="text-[#455A64] leading-relaxed">

    {{-- Main fee card --}}
    <div class="bg-gradient-to-r from-[#1B5E20] to-[#2E7D32] rounded-2xl p-8 text-white text-center mb-12">
        <p class="text-white/80 mb-2 text-sm font-medium uppercase tracking-widest">Comisión por venta</p>
        <div class="text-7xl font-outfit font-black mb-2">10%</div>
        <p class="text-white/80">Solo pagas cuando vendes. Sin costos fijos ni suscripciones.</p>
    </div>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-6">¿Cómo funciona la comisión?</h2>
        <div class="space-y-4 text-sm">
            <div class="flex gap-4 p-5 bg-[#F8FAF7] rounded-2xl">
                <i class="bx bx-check-circle text-2xl text-[#2E7D32] flex-shrink-0"></i>
                <div>
                    <strong class="text-[#263238]">Sin costo por publicar:</strong> Puedes publicar todos los artículos que quieras de forma gratuita.
                </div>
            </div>
            <div class="flex gap-4 p-5 bg-[#F8FAF7] rounded-2xl">
                <i class="bx bx-check-circle text-2xl text-[#2E7D32] flex-shrink-0"></i>
                <div>
                    <strong class="text-[#263238]">10% al completar una venta:</strong> Cuando el comprador confirme la recepción, se descuenta el 10% del total de venta antes de acreditar el saldo a tu billetera.
                </div>
            </div>
            <div class="flex gap-4 p-5 bg-[#F8FAF7] rounded-2xl">
                <i class="bx bx-check-circle text-2xl text-[#2E7D32] flex-shrink-0"></i>
                <div>
                    <strong class="text-[#263238]">El comprador paga el precio total:</strong> La comisión es absorbida por el vendedor, el comprador paga únicamente el precio publicado.
                </div>
            </div>
        </div>
    </section>

    {{-- Example --}}
    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4">Ejemplo de cálculo</h2>
        <div class="bg-[#F8FAF7] rounded-2xl p-6 text-sm">
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span>Precio de publicación</span><strong>$500.00</strong>
                </div>
                <div class="flex justify-between text-red-600">
                    <span>Comisión ReWear (10%)</span><strong>- $50.00</strong>
                </div>
                <div class="border-t border-[#E5E7EB] pt-3 flex justify-between text-[#263238] font-bold text-base">
                    <span>Lo que recibes</span><strong class="text-[#2E7D32]">$450.00</strong>
                </div>
            </div>
        </div>
    </section>

    <section>
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4">Retiros</h2>
        <div class="grid md:grid-cols-2 gap-4 text-sm">
            <div class="p-5 border border-[#E5E7EB] rounded-2xl">
                <h4 class="font-semibold text-[#263238] mb-1"><i class="bx bx-time-five text-[#2E7D32] mr-1"></i> Saldo Pendiente</h4>
                <p>Dinero retenido hasta que el comprador confirme la recepción del producto.</p>
            </div>
            <div class="p-5 border border-[#E5E7EB] rounded-2xl">
                <h4 class="font-semibold text-[#263238] mb-1"><i class="bx bx-wallet-alt text-[#2E7D32] mr-1"></i> Saldo Disponible</h4>
                <p>Dinero listo para retirar a tu cuenta bancaria mediante CLABE interbancaria.</p>
            </div>
        </div>
        <p class="mt-4 text-sm bg-[#FFF8E1] border border-[#FFE082] rounded-xl p-4">
            <i class="bx bx-info-circle text-[#F9A825] mr-1"></i>
            Los retiros se procesan en un plazo de 1 a 3 días hábiles.
        </p>
    </section>

</div>
@endsection
