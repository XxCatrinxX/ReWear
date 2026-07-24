@extends('footer._layout')

@section('page-icon')<i class="bx bx-book-open text-3xl text-white"></i>@endsection
@section('page-subtitle', 'Todo lo que necesitas saber para ser un vendedor exitoso en ReWear.')

@section('page-content')
<div class="text-[#455A64] leading-relaxed">

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-6">Panel de Vendedor</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <div class="p-5 border border-[#E5E7EB] rounded-2xl hover:border-[#2E7D32] transition-colors">
                <i class="bx bx-bar-chart-alt-2 text-2xl text-[#2E7D32] mb-2 block"></i>
                <h4 class="font-outfit font-semibold text-[#263238] mb-1">Dashboard</h4>
                <p class="text-sm">Ve un resumen de tus ventas, saldo pendiente y disponible, y tus publicaciones recientes.</p>
            </div>
            <div class="p-5 border border-[#E5E7EB] rounded-2xl hover:border-[#2E7D32] transition-colors">
                <i class="bx bx-list-ul text-2xl text-[#2E7D32] mb-2 block"></i>
                <h4 class="font-outfit font-semibold text-[#263238] mb-1">Mis Publicaciones</h4>
                <p class="text-sm">Gestiona tus artículos: edita precios, agrega stock, activa o desactiva publicaciones.</p>
            </div>
            <div class="p-5 border border-[#E5E7EB] rounded-2xl hover:border-[#2E7D32] transition-colors">
                <i class="bx bx-package text-2xl text-[#2E7D32] mb-2 block"></i>
                <h4 class="font-outfit font-semibold text-[#263238] mb-1">Mis Ventas</h4>
                <p class="text-sm">Consulta el estado de cada pedido, imprime etiquetas y comunícate con el comprador.</p>
            </div>
            <div class="p-5 border border-[#E5E7EB] rounded-2xl hover:border-[#2E7D32] transition-colors">
                <i class="bx bx-wallet-alt text-2xl text-[#2E7D32] mb-2 block"></i>
                <h4 class="font-outfit font-semibold text-[#263238] mb-1">Mi Billetera</h4>
                <p class="text-sm">Visualiza tu saldo disponible y realiza retiros a tu cuenta bancaria mediante CLABE.</p>
            </div>
        </div>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4">Proceso de Envío</h2>
        <ol class="space-y-4">
            <li class="flex gap-3">
                <span class="w-6 h-6 bg-[#2E7D32] text-white text-xs font-bold rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                <p class="text-sm"><strong>Confirma el pedido:</strong> Al recibir la notificación, revisa los detalles del pedido en tu panel.</p>
            </li>
            <li class="flex gap-3">
                <span class="w-6 h-6 bg-[#2E7D32] text-white text-xs font-bold rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                <p class="text-sm"><strong>Imprime la etiqueta:</strong> Descarga e imprime la etiqueta de envío con código QR desde el detalle del pedido.</p>
            </li>
            <li class="flex gap-3">
                <span class="w-6 h-6 bg-[#2E7D32] text-white text-xs font-bold rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                <p class="text-sm"><strong>Empaca con cuidado:</strong> Usa papel de burbujas o bolsas herméticas para proteger la prenda durante el traslado.</p>
            </li>
            <li class="flex gap-3">
                <span class="w-6 h-6 bg-[#2E7D32] text-white text-xs font-bold rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">4</span>
                <p class="text-sm"><strong>Envía el paquete:</strong> Llévalo con el servicio de mensajería y marca el pedido como enviado en tu panel.</p>
            </li>
        </ol>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4">Consejos para Mejores Fotos</h2>
        <div class="bg-[#F8FAF7] rounded-2xl p-6">
            <ul class="grid md:grid-cols-2 gap-3 text-sm">
                <li class="flex items-start gap-2"><i class="bx bx-sun text-[#2E7D32] mt-0.5"></i> Usa luz natural, cerca de una ventana.</li>
                <li class="flex items-start gap-2"><i class="bx bx-hanger text-[#2E7D32] mt-0.5"></i> Fotografía en un fondo blanco o neutro.</li>
                <li class="flex items-start gap-2"><i class="bx bx-zoom-in text-[#2E7D32] mt-0.5"></i> Incluye fotos de detalle (costuras, etiquetas).</li>
                <li class="flex items-start gap-2"><i class="bx bx-rotate-right text-[#2E7D32] mt-0.5"></i> Muestra frente y reverso de la prenda.</li>
                <li class="flex items-start gap-2"><i class="bx bx-error-circle text-[#2E7D32] mt-0.5"></i> Fotografía cualquier defecto visiblemente.</li>
                <li class="flex items-start gap-2"><i class="bx bx-image-add text-[#2E7D32] mt-0.5"></i> Agrega al menos 3 fotos por publicación.</li>
            </ul>
        </div>
    </section>

    <section>
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4">Política de Métricas de Vendedor</h2>
        <p class="text-sm mb-4">Mantenemos un sistema de calidad para garantizar la confianza en la plataforma:</p>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-4 bg-[#F8FAF7] rounded-xl text-sm">
                <span>Tiempo máximo de envío</span><strong class="text-[#2E7D32]">5 días hábiles</strong>
            </div>
            <div class="flex items-center justify-between p-4 bg-[#F8FAF7] rounded-xl text-sm">
                <span>Tiempo de respuesta recomendado</span><strong class="text-[#2E7D32]">24 horas</strong>
            </div>
            <div class="flex items-center justify-between p-4 bg-[#F8FAF7] rounded-xl text-sm">
                <span>Comisión de la plataforma</span><strong class="text-[#2E7D32]">10% por venta</strong>
            </div>
        </div>
    </section>

</div>
@endsection
