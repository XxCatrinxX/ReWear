@extends('footer._layout')

@section('page-icon')<i class="bx bx-shield-quarter text-3xl text-white"></i>@endsection
@section('page-subtitle', 'Lee nuestros términos antes de usar la plataforma.')

@section('page-content')
<div class="prose max-w-none text-[#455A64] leading-relaxed">

    <div class="flex items-center gap-3 mb-8 pb-6 border-b border-[#E5E7EB]">
        <span class="text-sm text-[#607D8B]"><i class="bx bx-calendar mr-1"></i> Última actualización: enero 2025</span>
    </div>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-[#E8F5E9] rounded-lg flex items-center justify-center text-[#2E7D32] text-sm font-bold">1</span>
            Aceptación de los Términos
        </h2>
        <p>Al acceder y utilizar ReWear, aceptas estar sujeto a estos Términos y Condiciones. Si no estás de acuerdo con alguna parte de estos términos, no podrás acceder al servicio.</p>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-[#E8F5E9] rounded-lg flex items-center justify-center text-[#2E7D32] text-sm font-bold">2</span>
            Descripción del Servicio
        </h2>
        <p>ReWear es un marketplace de moda circular que permite a usuarios comprar y vender ropa de segunda mano. Actuamos como intermediario entre compradores y vendedores, facilitando las transacciones pero sin ser parte de ellas directamente.</p>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-[#E8F5E9] rounded-lg flex items-center justify-center text-[#2E7D32] text-sm font-bold">3</span>
            Cuentas de Usuario
        </h2>
        <ul class="list-disc pl-6 space-y-2">
            <li>Debes tener al menos 18 años para crear una cuenta.</li>
            <li>Eres responsable de mantener la confidencialidad de tu contraseña.</li>
            <li>No puedes transferir tu cuenta a otra persona.</li>
            <li>ReWear se reserva el derecho de suspender cuentas que violen estos términos.</li>
        </ul>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-[#E8F5E9] rounded-lg flex items-center justify-center text-[#2E7D32] text-sm font-bold">4</span>
            Publicaciones y Ventas
        </h2>
        <ul class="list-disc pl-6 space-y-2">
            <li>Las publicaciones deben ser precisas y honestas respecto al estado de la prenda.</li>
            <li>Está prohibido publicar artículos falsificados, ilegales o que infrinjan derechos de autor.</li>
            <li>Los vendedores son responsables de enviar los productos en el plazo acordado.</li>
            <li>ReWear cobra una comisión del 10% sobre cada venta completada.</li>
        </ul>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-[#E8F5E9] rounded-lg flex items-center justify-center text-[#2E7D32] text-sm font-bold">5</span>
            Pagos y Transacciones
        </h2>
        <p>Los fondos del comprador se retienen de manera segura hasta que este confirme la recepción del producto. Una vez confirmada la entrega, el monto se libera al vendedor, descontando la comisión de ReWear.</p>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-[#E8F5E9] rounded-lg flex items-center justify-center text-[#2E7D32] text-sm font-bold">6</span>
            Limitación de Responsabilidad
        </h2>
        <p>ReWear no es responsable por daños indirectos, incidentales o consecuentes que surjan del uso de la plataforma. La responsabilidad máxima de ReWear no excederá el valor de la transacción en cuestión.</p>
    </section>

    <section>
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-[#E8F5E9] rounded-lg flex items-center justify-center text-[#2E7D32] text-sm font-bold">7</span>
            Contacto
        </h2>
        <p>Para consultas sobre estos términos, escríbenos a <a href="mailto:legal@rewear.mx" class="text-[#2E7D32] font-medium hover:underline">legal@rewear.mx</a>.</p>
    </section>

</div>
@endsection
