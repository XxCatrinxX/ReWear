@extends('layouts.rewear')
@section('title', $product->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ mainImage: '{{ $product->cover_url }}' }">
    
    <!-- Breadcrumbs -->
    <nav class="w-full max-w-full overflow-hidden text-xs sm:text-sm text-[#607D8B] mb-6">
        <ol class="flex flex-wrap items-center gap-1 sm:gap-2 leading-relaxed">
            <li><a href="{{ route('home') }}" class="hover:text-[#2E7D32] whitespace-nowrap">Inicio</a></li>
            <li><i class='bx bx-chevron-right text-xs'></i></li>
            <li><a href="{{ route('catalog') }}" class="hover:text-[#2E7D32] whitespace-nowrap">Catálogo</a></li>
            <li><i class='bx bx-chevron-right text-xs'></i></li>
            <li><a href="{{ route('catalog', ['category' => $product->category->slug]) }}" class="hover:text-[#2E7D32] whitespace-nowrap truncate max-w-[120px] sm:max-w-none inline-block align-middle">{{ $product->category->name }}</a></li>
            <li><i class='bx bx-chevron-right text-xs'></i></li>
            <li class="text-[#263238] font-medium truncate max-w-[130px] sm:max-w-[250px] inline-block align-middle">{{ $product->title }}</li>
        </ol>
    </nav>

    <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden mb-12">
        <div class="flex flex-col lg:flex-row">
            
            <!-- Galería de imágenes -->
            <div class="w-full lg:w-1/2 p-6 flex flex-col-reverse md:flex-row gap-4 border-b lg:border-b-0 lg:border-r border-[#E5E7EB]">
                
                <!-- Thumbnails -->
                @if($product->images->count() > 1)
                <div class="flex md:flex-col gap-3 overflow-x-auto md:overflow-y-auto custom-scrollbar md:w-20 md:flex-shrink-0 snap-x">
                    @foreach($product->images as $image)
                        <button @click="mainImage = '{{ $image->url }}'" 
                                class="w-16 md:w-full aspect-[4/5] rounded-xl overflow-hidden border-2 focus:outline-none snap-start flex-shrink-0 transition-colors"
                                :class="mainImage === '{{ $image->url }}' ? 'border-[#2E7D32]' : 'border-transparent hover:border-[#E5E7EB]'">
                            <img src="{{ $image->url }}" alt="" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
                @endif
                
                <!-- Main Image -->
                <div class="w-full relative aspect-[4/5] bg-[#F8FAF7] rounded-2xl overflow-hidden">
                    <img :src="mainImage" alt="{{ $product->title }}" class="absolute inset-0 w-full h-full object-cover">
                    @if($product->is_sold)
                        <div class="absolute inset-0 bg-white/60 flex items-center justify-center backdrop-blur-[2px]">
                            <span class="bg-[#263238] text-white px-6 py-2 rounded-full font-bold text-lg tracking-widest shadow-lg">AGOTADO</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detalles del producto -->
            <div class="w-full lg:w-1/2 p-8 lg:p-12 flex flex-col">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <a href="{{ route('catalog', ['category' => $product->category->slug]) }}" class="text-sm font-medium text-[#D4A373] hover:underline mb-1 inline-block">
                            {{ $product->category->name }}
                        </a>
                        <h1 class="font-outfit text-3xl sm:text-4xl font-bold text-[#263238] leading-tight">{{ $product->title }}</h1>
                    </div>
                    @auth
                        <form action="{{ route('favorites.toggle', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-12 h-12 bg-[#F8FAF7] rounded-full flex items-center justify-center text-[#607D8B] hover:text-[#E53935] hover:bg-red-50 transition-colors border border-[#E5E7EB]">
                                <i class='bx bx-heart text-2xl'></i>
                            </button>
                        </form>
                    @endauth
                </div>

                <div class="text-3xl font-bold text-[#2E7D32] mb-6">
                    {{ $product->formatted_price }}
                </div>

                <!-- Atributos -->
                <div class="grid grid-cols-2 gap-y-4 gap-x-6 py-6 border-y border-[#E5E7EB] mb-8">
                    <div>
                        <span class="block text-xs text-[#607D8B] uppercase tracking-wider mb-1">Marca</span>
                        <span class="font-medium text-[#263238]">{{ $product->brand ?? 'No especificada' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-[#607D8B] uppercase tracking-wider mb-1">Talla</span>
                        <span class="font-medium text-[#263238]">{{ $product->size ?? 'Única' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-[#607D8B] uppercase tracking-wider mb-1">Estado</span>
                        <span class="font-medium text-[#263238]">{{ $product->condition_label }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-[#607D8B] uppercase tracking-wider mb-1">Color</span>
                        <span class="font-medium text-[#263238]">{{ $product->color ?? 'Varios' }}</span>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mb-10">
                    <h3 class="font-semibold text-[#263238] mb-3">Descripción</h3>
                    <div class="text-[#607D8B] leading-relaxed whitespace-pre-line">
                        {{ $product->description }}
                    </div>
                </div>

                <!-- Seller Info -->
                <div class="flex items-center gap-4 bg-[#F8FAF7] p-4 rounded-2xl mb-8 border border-[#E5E7EB]">
                    <img src="{{ $product->user->avatar_url }}" alt="{{ $product->user->name }}" class="w-14 h-14 rounded-full object-cover border border-[#E5E7EB]">
                    <div>
                        <p class="text-xs text-[#607D8B] uppercase tracking-wider font-medium">Vendedor</p>
                        <p class="font-medium text-[#263238]">{{ $product->user->name }}</p>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="mt-auto">
                    @if($product->is_sold)
                        <button disabled class="w-full bg-gray-200 text-gray-500 font-bold py-4 rounded-xl cursor-not-allowed">
                            PRODUCTO VENDIDO
                        </button>
                    @elseif(auth()->check() && auth()->id() === $product->user_id)
                        <div class="flex gap-4">
                            <a href="{{ route('seller.products.edit', $product) }}" class="flex-1 bg-[#2E7D32] text-white font-semibold py-4 rounded-xl shadow-soft hover:bg-[#1B5E20] transition-colors text-center">
                                Editar publicación
                            </a>
                        </div>
                    @else
                        <form action="{{ route('cart.store', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-[#2E7D32] text-white font-semibold py-4 rounded-xl shadow-soft hover:bg-[#1B5E20] transition-colors flex items-center justify-center gap-2 text-lg">
                                <i class='bx bx-shopping-bag'></i> Agregar al carrito
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Botón de reporte (solo para usuarios autenticados que no son el vendedor) -->
    @auth
        @if(auth()->id() !== $product->user_id)
        <div class="flex justify-end mb-4 -mt-6 px-2">
            <button onclick="document.getElementById('report-modal').classList.remove('hidden')"
                class="flex items-center gap-1.5 text-xs text-[#607D8B] hover:text-red-500 transition">
                <i class='bx bx-flag'></i> Reportar esta publicación
            </button>
        </div>

        <!-- Modal de reporte -->
        <div id="report-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-outfit text-xl font-bold text-[#263238]">Reportar publicación</h3>
                    <button onclick="document.getElementById('report-modal').classList.add('hidden')"
                        class="text-[#607D8B] hover:text-[#263238] transition p-1">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('products.report', $product) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-[#263238] mb-2">Motivo del reporte *</label>
                        <select name="reason" required
                            class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20 text-sm">
                            <option value="">Selecciona un motivo...</option>
                            <option value="Producto prohibido o ilegal">Producto prohibido o ilegal</option>
                            <option value="Foto o descripción engañosa">Foto o descripción engañosa</option>
                            <option value="Producto no es ropa de segunda mano">Producto no es ropa de segunda mano</option>
                            <option value="Precio abusivo">Precio abusivo</option>
                            <option value="Contenido inapropiado">Contenido inapropiado</option>
                            <option value="Sospecha de fraude">Sospecha de fraude</option>
                            <option value="Otro">Otro</option>
                        </select>
                        @error('reason') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-[#263238] mb-2">Detalles adicionales <span class="text-[#607D8B] font-normal">(opcional)</span></label>
                        <textarea name="details" rows="3" placeholder="Describe brevemente el incumplimiento..."
                            class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20 text-sm resize-none"></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="button"
                            onclick="document.getElementById('report-modal').classList.add('hidden')"
                            class="flex-1 py-3 rounded-xl border border-[#E5E7EB] text-[#607D8B] hover:bg-[#F8FAF7] transition text-sm font-medium">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="flex-1 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white transition text-sm font-semibold">
                            <i class='bx bx-flag mr-1'></i> Enviar reporte
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    @endauth

    <!-- Sección de Preguntas al Vendedor -->
    <div class="bg-white rounded-3xl p-8 border border-[#E5E7EB] shadow-sm mb-12">
        <h2 class="font-outfit text-2xl font-bold text-[#263238] mb-2">Preguntas al vendedor</h2>
        <p class="text-sm text-[#607D8B] mb-6">¿Tienes dudas sobre las medidas, el estado o el envío? Pregúntale directamente al vendedor antes de comprar.</p>

        <!-- Formulario para realizar preguntas -->
        @auth
            @if(auth()->id() !== $product->user_id)
                <form action="{{ route('products.questions.store', $product) }}" method="POST" class="mb-8">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="text" name="question" placeholder="Escribe tu pregunta sobre la prenda..." required
                            class="w-full sm:flex-1 px-4 py-3 border border-[#E5E7EB] rounded-2xl focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent text-sm text-[#263238]">
                        <button type="submit" class="btn-primary bg-[#2E7D32] hover:bg-[#1B5E20] px-6 py-3 rounded-2xl font-bold text-sm text-white flex items-center justify-center gap-2 whitespace-nowrap">
                            <i class='bx bx-paper-plane'></i> Preguntar
                        </button>
                    </div>
                </form>
            @endif
        @else
            <div class="bg-[#F8FAF7] border border-[#E5E7EB] rounded-2xl p-4 text-center mb-8">
                <p class="text-sm text-[#607D8B]">Inicia sesión para hacerle preguntas al vendedor de esta prenda.</p>
            </div>
        @endauth

        <!-- Lista de Preguntas y Respuestas -->
        <div class="space-y-6 divide-y divide-[#E5E7EB]">
            @forelse($product->questions as $q)
                <div class="pt-6 first:pt-0">
                    <!-- Pregunta del comprador -->
                    <div class="flex items-start gap-3">
                        <i class='bx bx-conversation text-2xl text-[#D4A373] mt-0.5'></i>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-sm text-[#263238]">{{ $q->user->name }}</span>
                                <span class="text-xs text-[#607D8B]">• {{ $q->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-[#607D8B] mt-1">{{ $q->question }}</p>
                        </div>
                    </div>

                    <!-- Respuesta del vendedor -->
                    @if($q->answer)
                        <div class="ml-8 mt-4 bg-[#F8FAF7] border-l-4 border-[#2E7D32] p-4 rounded-r-2xl">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-xs text-[#2E7D32] uppercase tracking-wider">Respuesta del vendedor</span>
                                <span class="text-[11px] text-[#607D8B]">• {{ $q->answered_at?->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-[#263238] font-medium">{{ $q->answer }}</p>
                        </div>
                    @elseif(auth()->check() && auth()->id() === $product->user_id)
                        <!-- Formulario para que el vendedor responda -->
                        <form action="{{ route('questions.answer', $q) }}" method="POST" class="ml-8 mt-3">
                            @csrf
                            <div class="flex gap-2">
                                <input type="text" name="answer" placeholder="Escribe tu respuesta como vendedor..." required
                                    class="flex-1 px-3 py-2 border border-[#E5E7EB] rounded-xl text-xs text-[#263238]">
                                <button type="submit" class="bg-[#2E7D32] text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-[#1B5E20]">
                                    Responder
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @empty
                <div class="text-center py-6 text-[#607D8B] text-sm">
                    Aún no hay preguntas sobre esta prenda. ¡Sé el primero en preguntar!
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- Productos Relacionados -->
    @if($relatedProducts->count() > 0)
    <div>
        <h2 class="font-outfit text-2xl font-bold text-[#263238] mb-6">También te podría gustar</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
                <div class="bg-white rounded-2xl overflow-hidden border border-[#E5E7EB] hover:shadow-card transition-all duration-300 group flex flex-col h-full relative">
                    <a href="{{ route('products.show', $related) }}" class="block aspect-[4/5] overflow-hidden bg-gray-100">
                        <img src="{{ $related->cover_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="font-medium text-[#263238] line-clamp-1 group-hover:text-[#2E7D32] transition-colors"><a href="{{ route('products.show', $related) }}">{{ $related->title }}</a></h3>
                            <span class="font-bold text-[#263238] ml-2">{{ $related->formatted_price }}</span>
                        </div>
                        <p class="text-sm text-[#607D8B]">{{ $related->brand ?? 'Sin marca' }} • Talla {{ $related->size }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
