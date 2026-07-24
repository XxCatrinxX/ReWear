@extends('footer._layout')

@section('page-icon')<i class="bx bx-store-alt text-3xl text-white"></i>@endsection
@section('page-subtitle', 'Convierte tu ropa en dinero en pocos pasos.')

@section('page-content')
<div class="text-[#455A64] leading-relaxed">

    {{-- Steps --}}
    <div class="space-y-8 mb-16">
        @php
        $steps = [
            ['icon'=>'bx-user-plus',  'title'=>'Crea tu cuenta de vendedor', 'desc'=>'Regístrate gratuitamente y activa tu perfil de vendedor desde la sección "Conviértete en vendedor" en tu perfil. Solo necesitas verificar tu correo electrónico.'],
            ['icon'=>'bx-camera',     'title'=>'Fotografía tus prendas',     'desc'=>'Toma fotos de buena calidad en un lugar bien iluminado. Muestra la prenda de frente, de atrás y cualquier detalle relevante como costuras, etiquetas o marcas.'],
            ['icon'=>'bx-edit',       'title'=>'Publica tu artículo',         'desc'=>'Completa el formulario con el título, descripción, talla, condición y precio. Sé honesto sobre el estado real de la prenda para evitar disputas.'],
            ['icon'=>'bx-bell',       'title'=>'Recibe y gestiona pedidos',   'desc'=>'Cuando alguien compre tu artículo recibirás una notificación. Desde tu panel de ventas podrás ver todos los detalles del pedido.'],
            ['icon'=>'bx-package',    'title'=>'Prepara y envía el paquete',  'desc'=>'Empaca bien la prenda, imprime la etiqueta de envío desde tu panel y deposita el paquete con el servicio de mensajería. Marca el pedido como enviado.'],
            ['icon'=>'bx-dollar',     'title'=>'Recibe tu dinero',            'desc'=>'Una vez que el comprador confirme la recepción, los fondos se liberan a tu saldo disponible. Puedes retirarlos cuando quieras a tu cuenta bancaria.'],
        ];
        @endphp

        @foreach($steps as $i => $step)
        <div class="flex gap-5 p-6 bg-[#F8FAF7] rounded-2xl hover:bg-[#F1F8E9] transition-colors">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-gradient-to-br from-[#2E7D32] to-[#43A047] rounded-xl flex items-center justify-center shadow-md">
                    <i class="bx {{ $step['icon'] }} text-2xl text-white"></i>
                </div>
            </div>
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-bold text-[#2E7D32] bg-[#E8F5E9] px-2 py-0.5 rounded-full">Paso {{ $i + 1 }}</span>
                </div>
                <h3 class="font-outfit font-bold text-[#263238] text-lg mb-1">{{ $step['title'] }}</h3>
                <p class="text-sm">{{ $step['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tips --}}
    <div class="bg-gradient-to-r from-[#1B5E20] to-[#2E7D32] rounded-2xl p-8 text-white">
        <h3 class="font-outfit font-bold text-xl mb-4 flex items-center gap-2">
            <i class="bx bx-bulb text-2xl"></i> Consejos para vender más rápido
        </h3>
        <ul class="space-y-3 text-sm text-white/90">
            <li class="flex items-start gap-2"><i class="bx bx-check-circle text-lg mt-0.5 flex-shrink-0"></i> Usa fotos con buena iluminación natural y fondo neutro.</li>
            <li class="flex items-start gap-2"><i class="bx bx-check-circle text-lg mt-0.5 flex-shrink-0"></i> Describe el estado real de la prenda con honestidad.</li>
            <li class="flex items-start gap-2"><i class="bx bx-check-circle text-lg mt-0.5 flex-shrink-0"></i> Investiga precios similares en el catálogo para ser competitivo.</li>
            <li class="flex items-start gap-2"><i class="bx bx-check-circle text-lg mt-0.5 flex-shrink-0"></i> Responde rápido las preguntas de los compradores.</li>
            <li class="flex items-start gap-2"><i class="bx bx-check-circle text-lg mt-0.5 flex-shrink-0"></i> Envía en los primeros 2 días después de recibir el pedido.</li>
        </ul>
    </div>

    <div class="mt-10 text-center">
        <a href="{{ route('seller.products.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2E7D32] to-[#43A047] text-white font-outfit font-semibold px-8 py-3.5 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all">
            <i class="bx bx-plus"></i>
            Publicar mi primera prenda
        </a>
    </div>
</div>
@endsection
