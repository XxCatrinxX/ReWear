@extends('layouts.rewear')
@section('title', $product->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10" 
     x-data="{ mainImage: '{{ $product->cover_url }}', showReportModal: false }">

    <!-- Breadcrumb minimalista -->
    <nav class="w-full text-xs text-gray-500 mb-6 overflow-x-auto">
        <ol class="flex items-center gap-2 whitespace-nowrap">
            <li><a href="{{ route('home') }}" class="hover:text-[#2E7D32] transition">Inicio</a></li>
            <li><i class='bx bx-chevron-right text-gray-400'></i></li>
            <li><a href="{{ route('catalog') }}" class="hover:text-[#2E7D32] transition">Catálogo</a></li>
            <li><i class='bx bx-chevron-right text-gray-400'></i></li>
            <li>
                <a href="{{ route('catalog', ['category' => $product->category->slug]) }}" class="hover:text-[#2E7D32] transition font-medium text-gray-700">
                    {{ $product->category->name }}
                </a>
            </li>
            <li><i class='bx bx-chevron-right text-gray-400'></i></li>
            <li class="text-gray-900 font-semibold truncate max-w-[200px]">{{ $product->title }}</li>
        </ol>
    </nav>

    <!-- Grid Principal de 2 Columnas principales con Sticky Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-16">
        
        <!-- COLUMNA IZQUIERDA: Galería + Descripción + Preguntas (7 columnas) -->
        <div class="lg:col-span-7 space-y-8">
            
            <!-- Galería de Fotos -->
            <div class="bg-white rounded-3xl p-4 sm:p-6 border border-gray-100 shadow-sm">
                <div class="relative aspect-[4/5] bg-gray-50 rounded-2xl overflow-hidden mb-4 border border-gray-100 group">
                    <img :src="mainImage" alt="{{ $product->title }}" class="w-full h-full object-cover transition-all duration-300">
                    
                    @if($product->is_sold)
                        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center">
                            <span class="bg-red-600 text-white px-8 py-3 rounded-full font-bold tracking-widest text-sm shadow-xl border border-white/20 uppercase">
                                VENDIDO
                            </span>
                        </div>
                    @endif

                    @auth
                        <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="absolute top-4 right-4 z-10">
                            @csrf
                            <button type="submit" 
                                    class="w-12 h-12 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center text-gray-700 hover:text-red-500 hover:bg-white shadow-md transition-all active:scale-90">
                                <i class='bx bx-heart text-2xl'></i>
                            </button>
                        </form>
                    @endauth
                </div>

                <!-- Miniaturas -->
                @if($product->images->count() > 1)
                <div class="flex gap-3 overflow-x-auto pb-2 custom-scrollbar">
                    @foreach($product->images as $image)
                        <button @click="mainImage = '{{ $image->url }}'" 
                                class="w-20 h-24 rounded-xl overflow-hidden border-2 transition-all shrink-0"
                                :class="mainImage === '{{ $image->url }}' ? 'border-[#2E7D32] ring-2 ring-[#2E7D32]/20 scale-95' : 'border-transparent opacity-70 hover:opacity-100'">
                            <img src="{{ $image->url }}" alt="" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Descripción Detallada -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
                <h2 class="font-outfit text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class='bx bx-align-left text-[#2E7D32] text-xl'></i> Descripción de la prenda
                </h2>
                <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line bg-gray-50/60 p-5 rounded-2xl border border-gray-100">
                    {{ $product->description }}
                </p>
            </div>

            <!-- Sección de Preguntas y Respuestas -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="font-outfit text-xl font-bold text-gray-900">Preguntas al vendedor</h2>
                        <p class="text-xs text-gray-500 mt-1">Aclara tus dudas sobre tallas, telas o envíos</p>
                    </div>
                    <span class="bg-emerald-50 text-[#2E7D32] text-xs font-bold px-3 py-1 rounded-full border border-emerald-100">
                        {{ $product->questions->count() }} {{ Str::plural('pregunta', $product->questions->count()) }}
                    </span>
                </div>

                @auth
                    @if(auth()->id() !== $product->user_id)
                        <form action="{{ route('products.questions.store', $product) }}" method="POST" class="mb-8 w-full max-w-full">
                            @csrf
                            <div class="flex flex-col sm:flex-row gap-2 w-full max-w-full">
                                <input type="text" name="question" placeholder="¿Tiene detalles de uso? ¿Es horma grande?" required
                                    class="flex-1 min-w-0 px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:bg-white focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition">
                                <button type="submit" class="bg-[#2E7D32] hover:bg-[#1B5E20] text-white px-5 py-3 rounded-2xl font-bold text-xs flex items-center justify-center gap-1.5 transition shrink-0">
                                    <span>Preguntar</span> <i class='bx bx-send'></i>
                                </button>
                            </div>
                        </form>
                    @endif
                @else
                    <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-4 text-center mb-8">
                        <p class="text-xs text-gray-600">
                            <a href="{{ route('login') }}" class="font-bold text-[#2E7D32] hover:underline">Inicia sesión</a> para resolver tus dudas directamente con el vendedor.
                        </p>
                    </div>
                @endauth

                <!-- Chat list -->
                <div class="space-y-4">
                    @forelse($product->questions as $q)
                        <div class="p-4 rounded-2xl bg-gray-50/50 border border-gray-100 overflow-hidden max-w-full">
                            <div class="flex items-start gap-3 max-w-full">
                                <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 font-bold flex items-center justify-center text-xs shrink-0">
                                    {{ strtoupper(substr($q->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0 max-w-full">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-bold text-xs text-gray-900 truncate max-w-[150px] sm:max-w-none">{{ $q->user->name }}</span>
                                        <span class="text-[10px] text-gray-400">• {{ $q->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1 break-words">{{ $q->question }}</p>

                                    @if($q->answer)
                                        <div class="mt-3 pl-4 border-l-2 border-[#2E7D32] bg-white p-3 rounded-r-xl border-y border-r border-gray-100 break-words">
                                            <div class="flex items-center gap-1.5 mb-1">
                                                <span class="font-bold text-[10px] text-[#2E7D32] bg-emerald-50 px-2 py-0.5 rounded-md">VENDEDOR</span>
                                                <span class="text-[10px] text-gray-400">• {{ $q->answered_at?->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-xs font-medium text-gray-800 break-words">{{ $q->answer }}</p>
                                        </div>
                                    @elseif(auth()->check() && auth()->id() === $product->user_id)
                                        <form action="{{ route('questions.answer', $q) }}" method="POST" class="mt-3 w-full max-w-full">
                                            @csrf
                                            <div class="flex flex-col sm:flex-row gap-2 w-full max-w-full">
                                                <input type="text" name="answer" placeholder="Escribe la respuesta..." required
                                                    class="flex-1 min-w-0 px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs focus:ring-1 focus:ring-[#2E7D32]">
                                                <button type="submit" class="bg-[#2E7D32] text-white px-4 py-2 rounded-xl text-xs font-semibold hover:bg-[#1B5E20] transition shrink-0">
                                                    Responder
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400 text-xs">
                            <i class='bx bx-message-rounded-dots text-3xl mb-1 block'></i>
                            No hay preguntas aún. ¡Aprovecha y sé el primero!
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- COLUMNA DERECHA: Ficha de Compra Sticky (5 columnas) -->
        <div class="lg:col-span-5 lg:sticky lg:top-8 space-y-6">
            
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
                
                <!-- Tag Categoría & Titulo -->
                <div class="mb-4">
                    <a href="{{ route('catalog', ['category' => $product->category->slug]) }}" 
                       class="inline-block text-[11px] font-bold tracking-wider text-[#D4A373] uppercase mb-1 hover:underline">
                        {{ $product->category->name }}
                    </a>
                    <h1 class="font-outfit text-2xl sm:text-3xl font-extrabold text-gray-900 leading-snug">
                        {{ $product->title }}
                    </h1>
                </div>

                <!-- Precio -->
                <div class="p-4 bg-emerald-50/50 rounded-2xl border border-emerald-100/60 mb-6 flex items-baseline justify-between">
                    <div>
                        <span class="text-xs text-emerald-800 font-medium block">Precio final</span>
                        <span class="text-3xl font-black text-[#2E7D32]">{{ $product->formatted_price }}</span>
                    </div>
                    <span class="text-[11px] bg-white text-emerald-700 font-bold px-2.5 py-1 rounded-full border border-emerald-200">
                        Envío protegido
                    </span>
                </div>

                <!-- Ficha de Atributos Clave -->
                <div class="divide-y divide-gray-100 border-y border-gray-100 mb-6 text-sm">
                    <div class="py-3 flex justify-between items-center">
                        <span class="text-gray-500 text-xs flex items-center gap-2">
                            <i class='bx bx-purchase-tag text-base text-gray-400'></i> Marca
                        </span>
                        <span class="font-semibold text-gray-900">{{ $product->brand ?? 'No especificada' }}</span>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <span class="text-gray-500 text-xs flex items-center gap-2">
                            <i class='bx bx-ruler text-base text-gray-400'></i> Talla
                        </span>
                        <span class="font-bold bg-gray-100 px-2.5 py-0.5 rounded-lg text-gray-800 text-xs">{{ $product->size ?? 'Única' }}</span>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <span class="text-gray-500 text-xs flex items-center gap-2">
                            <i class='bx bx-check-circle text-base text-gray-400'></i> Estado
                        </span>
                        <span class="font-semibold text-gray-900">{{ $product->condition_label }}</span>
                    </div>

                    <!-- COLOR CON CÍRCULO MUESTRA -->
                    <div class="py-3 flex justify-between items-center">
                        <span class="text-gray-500 text-xs flex items-center gap-2">
                            <i class='bx bx-palette text-base text-gray-400'></i> Color
                        </span>
                        <div class="flex items-center gap-2">
                            @php
                                $colorRaw = strtolower(trim($product->color ?? ''));
                                $colorMap = [
                                    'negro' => '#000000',
                                    'black' => '#000000',
                                    'blanco' => '#FFFFFF',
                                    'white' => '#FFFFFF',
                                    'rojo' => '#EF4444',
                                    'red' => '#EF4444',
                                    'azul' => '#3B82F6',
                                    'blue' => '#3B82F6',
                                    'verde' => '#10B981',
                                    'green' => '#10B981',
                                    'amarillo' => '#EAB308',
                                    'yellow' => '#EAB308',
                                    'rosa' => '#EC4899',
                                    'pink' => '#EC4899',
                                    'morado' => '#8B5CF6',
                                    'purple' => '#8B5CF6',
                                    'gris' => '#6B7280',
                                    'grey' => '#6B7280',
                                    'gray' => '#6B7280',
                                    'marrón' => '#78350F',
                                    'marron' => '#78350F',
                                    'cafe' => '#78350F',
                                    'brown' => '#78350F',
                                    'beige' => '#F5F5DC',
                                    'naranja' => '#F97316',
                                    'orange' => '#F97316'
                                ];

                                // Determinar el estilo del círculo
                                if (str_starts_with($colorRaw, '#')) {
                                    $bgStyle = "background-color: {$colorRaw};";
                                } elseif (isset($colorMap[$colorRaw])) {
                                    $bgStyle = "background-color: {$colorMap[$colorRaw]};";
                                } else {
                                    // Gradiente si es "Varios" o un color multicolor desconocido
                                    $bgStyle = "background: conic-gradient(red, yellow, green, cyan, blue, magenta, red);";
                                }

                                $isWhite = in_array($colorRaw, ['blanco', 'white', '#ffffff', '#fff']);
                            @endphp

                            <!-- Círculo de color -->
                            <span class="w-4 h-4 rounded-full inline-block shadow-sm {{ $isWhite ? 'border border-gray-300' : 'border border-black/10' }}" 
                                  style="{{ $bgStyle }}" 
                                  title="{{ $product->color }}">
                            </span>

                            <span class="font-semibold text-gray-900 capitalize">{{ $product->color ?? 'Varios' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Botones CTA Principal -->
                <div class="space-y-3 mb-6">
                    @if($product->is_sold)
                        <button disabled class="w-full bg-gray-100 text-gray-400 font-bold py-4 rounded-2xl cursor-not-allowed text-sm">
                            ESTE PRODUCTO YA FUE VENDIDO
                        </button>
                    @elseif(auth()->check() && auth()->id() === $product->user_id)
                        <a href="{{ route('seller.products.edit', $product) }}" 
                           class="w-full bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-bold py-4 rounded-2xl shadow-lg shadow-[#2E7D32]/20 transition-all flex items-center justify-center gap-2 text-sm">
                            <i class='bx bx-edit text-lg'></i> Editar mi publicación
                        </a>
                    @else
                        <form action="{{ route('cart.store', $product) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-bold py-4 rounded-2xl shadow-lg shadow-[#2E7D32]/20 transition-all flex items-center justify-center gap-2 text-base active:scale-[0.98]">
                                <i class='bx bx-shopping-bag text-xl'></i> Agregar al carrito
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Tarjeta del Vendedor -->
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ $product->user->avatar_url }}" alt="" class="w-11 h-11 rounded-full object-cover border border-gray-200">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Vendedor</span>
                            <p class="font-bold text-gray-900 text-sm leading-tight">{{ $product->user->name }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-[#2E7D32] font-semibold bg-white px-3 py-1 rounded-full border border-gray-200 shadow-2xs">
                        Verificado
                    </span>
                </div>

                <!-- Reportar publicación -->
                @auth
                    @if(auth()->id() !== $product->user_id)
                        <div class="mt-4 text-center">
                            <button @click="showReportModal = true" class="text-xs text-gray-400 hover:text-red-500 font-medium transition inline-flex items-center gap-1">
                                <i class='bx bx-flag'></i> Reportar publicación
                            </button>
                        </div>
                    @endif
                @endauth

            </div>

            <!-- Beneficios de Garantía / Trust Badges -->
            <div class="bg-white rounded-2xl p-4 border border-gray-100 text-xs space-y-3">
                <div class="flex items-center gap-3 text-gray-600">
                    <i class='bx bx-shield-quarter text-xl text-[#2E7D32] shrink-0'></i>
                    <span><strong>Compra Protegida:</strong> Tu dinero está seguro hasta que recibas la prenda.</span>
                </div>
                <div class="flex items-center gap-3 text-gray-600">
                    <i class='bx bx-package text-xl text-[#2E7D32] shrink-0'></i>
                    <span><strong>Envío Rápido:</strong> Despacho asegurado por el vendedor en 48 hrs.</span>
                </div>
            </div>

        </div>

    </div>

    <!-- Modal de Reporte -->
    @auth
        @if(auth()->id() !== $product->user_id)
        <div x-show="showReportModal" 
             x-transition.opacity
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
             style="display: none;">
            <div @click.away="showReportModal = false" class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-6 sm:p-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-outfit text-xl font-bold text-gray-900">Reportar publicación</h3>
                    <button @click="showReportModal = false" class="text-gray-400 hover:text-gray-700">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                </div>

                <form method="POST" action="{{ route('products.report', $product) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-2">Motivo del reporte *</label>
                        <select name="reason" required class="w-full bg-gray-50 border border-gray-200 rounded-xl text-sm focus:border-[#2E7D32]">
                            <option value="">Selecciona un motivo...</option>
                            <option value="Producto prohibido o ilegal">Producto prohibido o ilegal</option>
                            <option value="Foto o descripción engañosa">Foto o descripción engañosa</option>
                            <option value="Producto no es ropa de segunda mano">Producto no es ropa de segunda mano</option>
                            <option value="Precio abusivo">Precio abusivo</option>
                            <option value="Contenido inapropiado">Contenido inapropiado</option>
                            <option value="Sospecha de fraude">Sospecha de fraude</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-2">Detalles adicionales</label>
                        <textarea name="details" rows="3" placeholder="Describe brevemente el motivo..."
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl text-sm resize-none focus:border-[#2E7D32]"></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" @click="showReportModal = false" class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-600 font-medium text-sm">
                            Cancelar
                        </button>
                        <button type="submit" class="flex-1 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold text-sm transition">
                            Enviar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    @endauth

    <!-- Productos Relacionados -->
    @if($relatedProducts->count() > 0)
    <div class="border-t border-gray-200/80 pt-12">
        <h2 class="font-outfit text-xl sm:text-2xl font-bold text-gray-900 mb-6">También te podría gustar</h2>
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($relatedProducts as $related)
                <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-md transition-all group flex flex-col h-full">
                    <a href="{{ route('products.show', $related) }}" class="block aspect-[4/5] overflow-hidden bg-gray-100 relative">
                        <img src="{{ $related->cover_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-4 flex flex-col justify-between flex-grow">
                        <div>
                            <h3 class="font-bold text-sm text-gray-900 line-clamp-1 group-hover:text-[#2E7D32] transition">
                                <a href="{{ route('products.show', $related) }}">{{ $related->title }}</a>
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">{{ $related->brand ?? 'Sin marca' }} • Talla {{ $related->size }}</p>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100 flex justify-between items-center">
                            <span class="font-extrabold text-gray-900 text-base">{{ $related->formatted_price }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection