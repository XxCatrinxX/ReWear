@extends('footer._layout')

@section('page-icon')<i class="bx bx-truck text-3xl text-white"></i>@endsection
@section('page-subtitle', 'Todo lo que necesitas saber sobre envíos y tiempos de entrega.')

@section('page-content')
<div class="text-[#455A64] leading-relaxed">

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-6">¿Cómo funciona el envío?</h2>
        <div class="grid md:grid-cols-3 gap-4 text-sm text-center">
            <div class="p-5 bg-[#F8FAF7] rounded-2xl">
                <i class="bx bx-package text-3xl text-[#2E7D32] mb-3 block"></i>
                <h4 class="font-semibold text-[#263238] mb-1">El vendedor empaca</h4>
                <p>Prepara y empaca la prenda en un plazo de 1–2 días hábiles tras la compra.</p>
            </div>
            <div class="p-5 bg-[#F8FAF7] rounded-2xl">
                <i class="bx bx-truck text-3xl text-[#2E7D32] mb-3 block"></i>
                <h4 class="font-semibold text-[#263238] mb-1">En tránsito</h4>
                <p>La paquetería recoge el envío. Recibirás tu número de seguimiento por correo.</p>
            </div>
            <div class="p-5 bg-[#F8FAF7] rounded-2xl">
                <i class="bx bx-home-heart text-3xl text-[#2E7D32] mb-3 block"></i>
                <h4 class="font-semibold text-[#263238] mb-1">Recepción</h4>
                <p>Al recibir, escanea el QR de la etiqueta para confirmar la entrega y liberar el pago.</p>
            </div>
        </div>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4">Tiempos de Entrega</h2>
        <div class="space-y-3 text-sm">
            <div class="flex items-center justify-between p-4 bg-[#F8FAF7] rounded-xl">
                <span class="font-medium text-[#263238]">Envío estándar nacional</span>
                <span class="text-[#2E7D32] font-semibold">3–7 días hábiles</span>
            </div>
            <div class="flex items-center justify-between p-4 bg-[#F8FAF7] rounded-xl">
                <span class="font-medium text-[#263238]">Zonas metropolitanas</span>
                <span class="text-[#2E7D32] font-semibold">2–4 días hábiles</span>
            </div>
            <div class="flex items-center justify-between p-4 bg-[#F8FAF7] rounded-xl">
                <span class="font-medium text-[#263238]">Zonas rurales o de difícil acceso</span>
                <span class="text-[#2E7D32] font-semibold">5–10 días hábiles</span>
            </div>
        </div>
        <p class="mt-3 text-xs text-[#90A4AE]">* Los tiempos son estimados y pueden variar según la paquetería y condiciones externas.</p>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4">Costo de Envío</h2>
        <p class="text-sm mb-4">El costo de envío es determinado y pagado por el comprador al momento del checkout. El vendedor no cubre gastos de envío.</p>
        <div class="bg-[#E8F5E9] border border-[#A5D6A7] rounded-2xl p-5 text-sm">
            <p><strong class="text-[#2E7D32]">¡Envío gratis disponible!</strong> Algunos vendedores ofrecen envío gratuito en sus publicaciones. Búscalo en el catálogo con el filtro de envío gratis.</p>
        </div>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4">Seguimiento de tu Pedido</h2>
        <p class="text-sm mb-4">Una vez que el vendedor marca el pedido como enviado:</p>
        <ul class="space-y-2 text-sm">
            <li class="flex items-start gap-2"><i class="bx bx-envelope text-[#2E7D32] mt-0.5"></i> Recibirás un correo con el número de seguimiento.</li>
            <li class="flex items-start gap-2"><i class="bx bx-list-check text-[#2E7D32] mt-0.5"></i> Podrás ver el estado en "Mis Compras" dentro de tu cuenta.</li>
            <li class="flex items-start gap-2"><i class="bx bx-chat text-[#2E7D32] mt-0.5"></i> Puedes contactar al vendedor desde el chat del pedido.</li>
        </ul>
    </section>

    <section>
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4">¿Qué hago si no llega mi pedido?</h2>
        <p class="text-sm">Si tu pedido excede el tiempo estimado de entrega, primero verifica el número de rastreo con la paquetería. Si no hay solución, contáctanos en <a href="mailto:soporte@rewear.mx" class="text-[#2E7D32] font-medium hover:underline">soporte@rewear.mx</a> antes de confirmar la entrega, ya que los fondos se mantendrán retenidos hasta resolverlo.</p>
    </section>

</div>
@endsection
