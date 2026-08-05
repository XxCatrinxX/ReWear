@extends('footer._layout')

@section('page-icon')<i class="bx bx-question-mark text-3xl text-white"></i>@endsection
@section('page-subtitle', 'Respuestas a las dudas más comunes de nuestra comunidad.')

@section('page-content')
<div class="text-[#455A64] leading-relaxed" x-data="{ open: null }">

    @php
    $faqs = [
        'general' => [
            'title' => 'General',
            'icon'  => 'bx-info-circle',
            'items' => [
                ['q' => '¿Qué es ReWear?',
                 'a' => 'ReWear es un marketplace de moda circular donde puedes comprar y vender ropa de segunda mano de manera segura. Nuestra misión es extender la vida útil de las prendas y reducir el impacto ambiental de la industria textil.'],
                ['q' => '¿Es gratuito registrarse?',
                 'a' => 'Sí, crear una cuenta en ReWear es completamente gratuito. Solo cobramos una comisión del 10% cuando completas una venta exitosa.'],
                ['q' => '¿En qué países opera ReWear?',
                 'a' => 'Actualmente operamos en México. Estamos trabajando para expandirnos a más países próximamente.'],
            ],
        ],
        'buying' => [
            'title' => 'Compras',
            'icon'  => 'bx-shopping-bag',
            'items' => [
                ['q' => '¿Es seguro comprar en ReWear?',
                 'a' => 'Sí. Tu pago queda retenido de forma segura hasta que confirmes haber recibido el producto en buen estado. Los fondos solo se liberan al vendedor cuando tú das tu aprobación.'],
                ['q' => '¿Cómo confirmo la recepción de mi pedido?',
                 'a' => 'Al recibir tu paquete, escanea el código QR de la etiqueta de envío con tu celular. Esto confirma la entrega y libera el pago al vendedor automáticamente.'],
                ['q' => '¿Puedo devolver un artículo?',
                 'a' => 'Sí, en casos donde el artículo no corresponda a la descripción o llegue dañado. Consulta nuestra política de devoluciones para más detalles.'],
            ],
        ],
        'selling' => [
            'title' => 'Ventas',
            'icon'  => 'bx-store-alt',
            'items' => [
                ['q' => '¿Cómo me convierto en vendedor?',
                 'a' => 'Ve a tu perfil, haz clic en "Conviértete en vendedor" y completa el proceso de verificación. Es rápido y sencillo.'],
                ['q' => '¿Cuándo recibo mi dinero?',
                 'a' => 'El dinero se acredita a tu saldo disponible una vez que el comprador confirma la recepción del producto. Luego puedes retirarlo a tu cuenta bancaria mediante CLABE interbancaria.'],
                ['q' => '¿Qué pasa si el stock se agota?',
                 'a' => 'Puedes editar tu publicación y agregar más stock en cualquier momento desde tu panel de vendedor. El producto volverá a aparecer en el catálogo automáticamente.'],
            ],
        ],
    ];
    @endphp

    @foreach($faqs as $key => $section)
    <div class="mb-10">
        <h2 class="text-lg font-outfit font-bold text-[#263238] mb-4 flex items-center gap-2">
            <i class="bx {{ $section['icon'] }} text-[#2E7D32]"></i> {{ $section['title'] }}
        </h2>
        <div class="space-y-3">
            @foreach($section['items'] as $i => $faq)
            <div class="border border-[#E5E7EB] rounded-2xl overflow-hidden" x-data="{ isOpen: false }">
                <button @click="isOpen = !isOpen" class="w-full flex items-center justify-between p-5 text-left hover:bg-[#F8FAF7] transition-colors">
                    <span class="font-medium text-[#263238] text-sm">{{ $faq['q'] }}</span>
                    <i class="bx text-[#607D8B] text-xl flex-shrink-0 ml-2 transition-transform" :class="isOpen ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                </button>
                <div x-show="isOpen" x-collapse style="display:none;" class="px-5 pb-5 text-sm text-[#455A64]">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <div class="mt-10 bg-[#F8FAF7] rounded-2xl p-6 text-center">
        <p class="text-sm text-[#607D8B] mb-4">¿No encontraste tu respuesta? Escríbenos directamente.</p>
        <a href="{{ route('footer.show', ['page' => 'contact']) }}" class="inline-flex items-center gap-2 bg-[#2E7D32] text-white font-semibold px-6 py-3 rounded-full hover:bg-[#1B5E20] transition-colors text-sm">
            <i class="bx bx-envelope"></i> Contactar soporte
        </a>
    </div>

</div>
@endsection
