@extends('footer._layout')

@section('page-icon')<i class="bx bx-lock-alt text-3xl text-white"></i>@endsection
@section('page-subtitle', 'Tu privacidad es importante para nosotros. Aquí te explicamos cómo usamos tu información.')

@section('page-content')
<div class="prose max-w-none text-[#455A64] leading-relaxed">

    <div class="flex items-center gap-3 mb-8 pb-6 border-b border-[#E5E7EB]">
        <span class="text-sm text-[#607D8B]"><i class="bx bx-calendar mr-1"></i> Última actualización: enero 2025</span>
    </div>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-[#E8F5E9] rounded-lg flex items-center justify-center text-[#2E7D32] text-sm font-bold">1</span>
            Información que Recopilamos
        </h2>
        <p>Recopilamos información que nos proporcionas directamente al registrarte, publicar artículos o realizar transacciones:</p>
        <ul class="list-disc pl-6 space-y-2 mt-3">
            <li>Nombre, correo electrónico y contraseña.</li>
            <li>Dirección de envío y datos de pago.</li>
            <li>Fotografías de prendas publicadas.</li>
            <li>Mensajes e interacciones en la plataforma.</li>
        </ul>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-[#E8F5E9] rounded-lg flex items-center justify-center text-[#2E7D32] text-sm font-bold">2</span>
            Cómo Usamos tu Información
        </h2>
        <ul class="list-disc pl-6 space-y-2">
            <li>Procesar tus compras y ventas.</li>
            <li>Enviarte notificaciones sobre tus pedidos.</li>
            <li>Mejorar la experiencia de la plataforma.</li>
            <li>Prevenir fraudes y garantizar la seguridad.</li>
            <li>Cumplir con obligaciones legales.</li>
        </ul>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-[#E8F5E9] rounded-lg flex items-center justify-center text-[#2E7D32] text-sm font-bold">3</span>
            Compartir Información
        </h2>
        <p>No vendemos tu información personal a terceros. Compartimos datos únicamente cuando es necesario para operar el servicio (por ejemplo, con servicios de mensajería para procesar envíos) o cuando lo exige la ley.</p>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-[#E8F5E9] rounded-lg flex items-center justify-center text-[#2E7D32] text-sm font-bold">4</span>
            Seguridad de los Datos
        </h2>
        <p>Implementamos medidas de seguridad técnicas y organizativas para proteger tu información. Sin embargo, ningún sistema es completamente invulnerable y no podemos garantizar una seguridad absoluta.</p>
    </section>

    <section class="mb-10">
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-[#E8F5E9] rounded-lg flex items-center justify-center text-[#2E7D32] text-sm font-bold">5</span>
            Tus Derechos
        </h2>
        <ul class="list-disc pl-6 space-y-2">
            <li><strong>Acceso:</strong> Puedes solicitar una copia de tus datos personales.</li>
            <li><strong>Corrección:</strong> Puedes actualizar tu información desde tu perfil.</li>
            <li><strong>Eliminación:</strong> Puedes solicitar la eliminación de tu cuenta y datos.</li>
            <li><strong>Portabilidad:</strong> Puedes exportar tus datos en formato legible.</li>
        </ul>
    </section>

    <section>
        <h2 class="text-xl font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <span class="w-8 h-8 bg-[#E8F5E9] rounded-lg flex items-center justify-center text-[#2E7D32] text-sm font-bold">6</span>
            Contacto
        </h2>
        <p>Para ejercer tus derechos o resolver dudas sobre privacidad, escríbenos a <a href="mailto:privacidad@rewear.mx" class="text-[#2E7D32] font-medium hover:underline">privacidad@rewear.mx</a>.</p>
    </section>

</div>
@endsection
