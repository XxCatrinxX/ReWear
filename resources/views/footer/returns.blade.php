@extends('footer._layout')

@section('page-icon')<i class="bx bx-undo text-3xl text-white"></i>@endsection
@section('page-subtitle', 'Conoce cuándo y cómo aplica una devolución en ReWear.')

@section('page-content')
<div class="text-[#455A64] leading-relaxed">

    <div class="bg-[#FFF3E0] border border-[#FFB74D] rounded-2xl p-5 mb-10 flex gap-3">
        <i class="bx bx-info-circle text-2xl text-[#E65100] flex-shrink-0 mt-0.5"></i>
        <p class="text-sm"><strong class="text-[#E65100]">Importante:</strong> Dado que ReWear es un marketplace de segunda mano, las devoluciones aplican en casos específicos. Te recomendamos leer bien la descripción y ver todas las fotos antes de comprar.</p>
    </div>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4">¿Cuándo procede una devolución?</h2>
        <div class="space-y-4">
            <div class="flex gap-4 p-5 bg-[#E8F5E9] rounded-2xl border border-[#A5D6A7]">
                <i class="bx bx-check-circle text-2xl text-[#2E7D32] flex-shrink-0"></i>
                <div class="text-sm">
                    <strong class="text-[#263238] block mb-1">El artículo no corresponde a la descripción</strong>
                    Si el producto recibido tiene diferencias significativas respecto a lo publicado (talla, condición, color, etc.).
                </div>
            </div>
            <div class="flex gap-4 p-5 bg-[#E8F5E9] rounded-2xl border border-[#A5D6A7]">
                <i class="bx bx-check-circle text-2xl text-[#2E7D32] flex-shrink-0"></i>
                <div class="text-sm">
                    <strong class="text-[#263238] block mb-1">El artículo llegó dañado</strong>
                    Si la prenda presenta daños ocurridos durante el envío que no estaban descritos.
                </div>
            </div>
            <div class="flex gap-4 p-5 bg-[#E8F5E9] rounded-2xl border border-[#A5D6A7]">
                <i class="bx bx-check-circle text-2xl text-[#2E7D32] flex-shrink-0"></i>
                <div class="text-sm">
                    <strong class="text-[#263238] block mb-1">No llegó el producto</strong>
                    Si el pedido marca como entregado pero nunca lo recibiste.
                </div>
            </div>
        </div>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4">¿Cuándo NO procede una devolución?</h2>
        <div class="space-y-3">
            <div class="flex gap-3 p-4 bg-[#FFEBEE] rounded-xl text-sm border border-[#FFCDD2]">
                <i class="bx bx-x-circle text-[#C62828] mt-0.5 flex-shrink-0"></i>
                <span>Cambio de opinión o arrepentimiento de compra.</span>
            </div>
            <div class="flex gap-3 p-4 bg-[#FFEBEE] rounded-xl text-sm border border-[#FFCDD2]">
                <i class="bx bx-x-circle text-[#C62828] mt-0.5 flex-shrink-0"></i>
                <span>Defectos mencionados explícitamente en la descripción o fotografías.</span>
            </div>
            <div class="flex gap-3 p-4 bg-[#FFEBEE] rounded-xl text-sm border border-[#FFCDD2]">
                <i class="bx bx-x-circle text-[#C62828] mt-0.5 flex-shrink-0"></i>
                <span>Diferencias menores de tono o talla dentro del rango descrito.</span>
            </div>
        </div>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4">Proceso de Devolución</h2>
        <ol class="space-y-4">
            <li class="flex gap-3">
                <span class="w-6 h-6 bg-[#2E7D32] text-white text-xs font-bold rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                <p class="text-sm"><strong>No confirmes la entrega</strong> si hay un problema con el producto. El dinero permanece retenido.</p>
            </li>
            <li class="flex gap-3">
                <span class="w-6 h-6 bg-[#2E7D32] text-white text-xs font-bold rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                <p class="text-sm"><strong>Contacta al vendedor</strong> mediante el chat del pedido para intentar resolver el problema directamente.</p>
            </li>
            <li class="flex gap-3">
                <span class="w-6 h-6 bg-[#2E7D32] text-white text-xs font-bold rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                <p class="text-sm"><strong>Abre una disputa</strong> escribiendo a <a href="mailto:soporte@rewear.mx" class="text-[#2E7D32] hover:underline">soporte@rewear.mx</a> con evidencia fotográfica.</p>
            </li>
            <li class="flex gap-3">
                <span class="w-6 h-6 bg-[#2E7D32] text-white text-xs font-bold rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">4</span>
                <p class="text-sm"><strong>Resolución:</strong> Nuestro equipo evaluará el caso en máximo 5 días hábiles y emitirá un reembolso si procede.</p>
            </li>
        </ol>
    </section>

</div>
@endsection
