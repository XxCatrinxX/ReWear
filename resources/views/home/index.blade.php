@extends('layouts.rewear')

@section('content')
<!-- 1. Hero Section -->
<section class="relative bg-[#2E7D32] text-white overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-transparent"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20 md:py-28 lg:py-32 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 pr-0 md:pr-12 text-center md:text-left mb-12 md:mb-0">
            <span class="inline-block py-1 px-3 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-xs font-semibold tracking-wider uppercase mb-6">
                Moda Circular
            </span>
            <h1 class="font-outfit text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                Renueva tu clóset, <span class="text-[#D4A373]">salva el planeta.</span>
            </h1>
            <p class="text-lg text-white/90 mb-8 max-w-lg mx-auto md:mx-0">
                Compra, vende e intercambia ropa de segunda mano con estilo. Únete a la comunidad de moda sustentable más grande de México.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                <a href="{{ route('catalog') }}" class="px-8 py-3.5 bg-white text-[#2E7D32] font-semibold rounded-full hover:bg-gray-100 transition-colors shadow-soft text-center">
                    Comprar ahora
                </a>
                <a href="{{ route('seller.products.create') }}" class="px-8 py-3.5 bg-transparent border-2 border-white text-white font-semibold rounded-full hover:bg-white/10 transition-colors text-center">
                    Vender ropa
                </a>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center md:justify-end">
            <div class="relative w-full max-w-md aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-500">
                <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1470&auto=format&fit=crop" alt="Moda" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-8">
                    <div class="text-white">
                        <p class="font-outfit font-bold text-2xl mb-1">Tendencias de Verano</p>
                        <p class="text-white/80 text-sm">Explora la nueva colección</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- 2. Marcas Populares -->
<section class="py-8 bg-white border-b border-[#E5E7EB] overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-4">
        <p class="text-xs font-semibold text-[#607D8B] tracking-wider uppercase">Las marcas más buscadas en ReWear</p>
    </div>
    <div class="flex justify-around items-center opacity-60 grayscale hover:grayscale-0 transition-all duration-300 max-w-5xl mx-auto px-4 gap-8 overflow-x-auto py-2">
        <span class="font-bold text-xl tracking-tighter text-[#263238]">ZARA</span>
        <span class="font-bold text-xl tracking-widest text-[#263238] uppercase">Nike</span>
        <span class="font-extrabold text-xl tracking-tight text-[#263238]">LEVI'S</span>
        <span class="font-bold text-xl text-[#263238]">adidas</span>
        <span class="font-medium text-xl tracking-wide text-[#263238]">Bershka</span>
        <span class="font-bold text-xl text-[#263238]">H&M</span>
    </div>
</section>

<!-- Misión y Visión -->
<section class="py-20 bg-[#F8FAF7] border-t border-[#E5E7EB]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-block py-1 px-3 rounded-full bg-[#2E7D32]/10 text-[#2E7D32] text-xs font-bold tracking-wider uppercase mb-3">
                Nuestro Compromiso
            </span>
            <h2 class="font-outfit text-3xl sm:text-4xl font-extrabold text-[#263238]">
                Transformando el futuro de la moda
            </h2>
            <p class="text-[#607D8B] mt-3 text-sm sm:text-base">
                Creemos en un consumo más consciente donde el estilo y la sustentabilidad caminan de la mano.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            <div class="bg-white rounded-3xl p-8 sm:p-10 border border-[#E5E7EB] shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#2E7D32]/5 rounded-bl-full -z-0 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-[#2E7D32] text-white rounded-2xl flex items-center justify-center mb-6 shadow-md">
                        <i class='bx bx-target-lock text-3xl'></i>
                    </div>
                    <h3 class="font-outfit font-bold text-2xl text-[#263238] mb-4">Nuestra Misión</h3>
                    <p class="text-[#607D8B] leading-relaxed text-sm sm:text-base">
                        Democratizar la moda circular ofreciendo una plataforma accesible, segura e intuitiva que permita a las personas comprar, vender e intercambiar prendas de segunda mano, reduciendo el desperdicio textil.
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 sm:p-10 border border-[#E5E7EB] shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#D4A373]/10 rounded-bl-full -z-0 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-[#D4A373] text-white rounded-2xl flex items-center justify-center mb-6 shadow-md">
                        <i class='bx bx-compass text-3xl'></i>
                    </div>
                    <h3 class="font-outfit font-bold text-2xl text-[#263238] mb-4">Nuestra Visión</h3>
                    <p class="text-[#607D8B] leading-relaxed text-sm sm:text-base">
                        Consolidarnos como la comunidad y el mercado digital de ropa de segunda mano líder en México y América Latina, inspirando a millones a adoptar la moda sostenible.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. Categorías Destacadas -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Explora por Categoría</h2>
                <p class="text-[#607D8B]">Encuentra exactamente lo que buscas</p>
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('catalog', ['category' => $category->slug]) }}" class="group block text-center">
                    <div class="bg-[#F8FAF7] rounded-full aspect-square flex items-center justify-center mb-3 group-hover:bg-[#2E7D32] group-hover:shadow-soft transition-all duration-300 border border-[#E5E7EB] group-hover:border-[#2E7D32]">
                        @if($category->icon)
                            <i class='{{ $category->icon }} text-3xl text-[#607D8B] group-hover:text-white transition-colors'></i>
                        @else
                            <i class='bx bx-category text-3xl text-[#607D8B] group-hover:text-white transition-colors'></i>
                        @endif
                    </div>
                    <h3 class="font-medium text-[#263238] group-hover:text-[#2E7D32] transition-colors">{{ $category->name }}</h3>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- 4. Productos Recientes -->
<section class="py-16 bg-[#F8FAF7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Novedades</h2>
                <p class="text-[#607D8B]">Últimas prendas agregadas</p>
            </div>
            <a href="{{ route('catalog') }}" class="text-[#2E7D32] font-medium hover:underline hidden sm:block">Ver todo <i class='bx bx-right-arrow-alt align-middle'></i></a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($recentItems as $product)
                <div class="bg-white rounded-2xl overflow-hidden border border-[#E5E7EB] hover:shadow-card transition-all duration-300 group flex flex-col h-full relative">
                    @auth
                        <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="absolute top-3 right-3 z-10">
                            @csrf
                            <button type="submit" class="w-8 h-8 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-[#607D8B] hover:text-[#E53935] hover:bg-white transition-all shadow-sm">
                                <i class='bx bx-heart text-xl'></i>
                            </button>
                        </form>
                    @endauth

                    <a href="{{ route('products.show', $product) }}" class="block aspect-[4/5] overflow-hidden bg-gray-100 relative">
                        <img src="{{ $product->cover_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @if($product->is_sold)
                            <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                                <span class="bg-[#263238] text-white px-4 py-1.5 rounded-full font-bold text-sm tracking-wider">VENDIDO</span>
                            </div>
                        @elseif($product->allows_swap)
                            <div class="absolute bottom-3 left-3 bg-[#D4A373] text-white px-3 py-1 rounded-full font-semibold text-xs shadow-sm flex items-center gap-1">
                                <i class='bx bx-refresh'></i> Acepta Trueque
                            </div>
                        @endif
                    </a>
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="font-medium text-[#263238] line-clamp-1 group-hover:text-[#2E7D32] transition-colors"><a href="{{ route('products.show', $product) }}">{{ $product->title }}</a></h3>
                            <span class="font-bold text-[#263238] ml-2">{{ $product->formatted_price }}</span>
                        </div>
                        <p class="text-sm text-[#607D8B] mb-2">{{ $product->brand ?? 'Sin marca' }} • Talla {{ $product->size }}</p>
                        
                        <div class="mt-auto pt-4 border-t border-gray-50 flex items-center gap-2">
                            <img src="{{ $product->user->avatar_url }}" alt="{{ $product->user->name }}" class="w-6 h-6 rounded-full">
                            <span class="text-xs text-[#607D8B] truncate">{{ $product->user->name }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 5. ¿Cómo Funciona? -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-block py-1 px-3 rounded-full bg-[#2E7D32]/10 text-[#2E7D32] text-xs font-bold tracking-wider uppercase mb-3">
                Paso a Paso
            </span>
            <h2 class="font-outfit text-3xl sm:text-4xl font-extrabold text-[#263238]">
                ¿Cómo funciona ReWear?
            </h2>
            <p class="text-[#607D8B] mt-3">Es facilísimo renovar tu clóset sin complicaciones.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-[#F8FAF7] p-8 rounded-3xl border border-[#E5E7EB] text-center relative">
                <div class="w-12 h-12 bg-[#2E7D32] text-white rounded-full flex items-center justify-center font-bold text-xl mx-auto mb-6">1</div>
                <h3 class="font-outfit font-bold text-xl text-[#263238] mb-3">Publica o Busca</h3>
                <p class="text-[#607D8B] text-sm">Sube fotos de las prendas que ya no usas en segundos o navega miles de prendas únicas de otros usuarios.</p>
            </div>
            <div class="bg-[#F8FAF7] p-8 rounded-3xl border border-[#E5E7EB] text-center relative">
                <div class="w-12 h-12 bg-[#D4A373] text-white rounded-full flex items-center justify-center font-bold text-xl mx-auto mb-6">2</div>
                <h3 class="font-outfit font-bold text-xl text-[#263238] mb-3">Acuerda o Truequea</h3>
                <p class="text-[#607D8B] text-sm">Paga de forma 100% segura mediante nuestra plataforma o haz una oferta de intercambio directo.</p>
            </div>
            <div class="bg-[#F8FAF7] p-8 rounded-3xl border border-[#E5E7EB] text-center relative">
                <div class="w-12 h-12 bg-[#2E7D32] text-white rounded-full flex items-center justify-center font-bold text-xl mx-auto mb-6">3</div>
                <h3 class="font-outfit font-bold text-xl text-[#263238] mb-3">Recibe y Disfruta</h3>
                <p class="text-[#607D8B] text-sm">Recibe tu paquete directamente en tu domicilio y estrena estilo dándole una segunda vida a la moda.</p>
            </div>
        </div>
    </div>
</section>

<!-- 6. Estadísticas de Impacto Ambiental -->
<section class="py-16 bg-[#2E7D32] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div class="p-4">
                <p class="font-outfit text-4xl sm:text-5xl font-extrabold text-[#D4A373] mb-2">+1,000</p>
                <p class="text-white/90 text-sm font-medium">Prendas Salvadas</p>
            </div>
            <div class="p-4">
                <p class="font-outfit text-4xl sm:text-5xl font-extrabold text-[#D4A373] mb-2">2.5M L</p>
                <p class="text-white/90 text-sm font-medium">Agua Ahorrada</p>
            </div>
            <div class="p-4">
                <p class="font-outfit text-4xl sm:text-5xl font-extrabold text-[#D4A373] mb-2">45 Ton</p>
                <p class="text-white/90 text-sm font-medium">CO₂ Evitado</p>
            </div>
            <div class="p-4">
                <p class="font-outfit text-4xl sm:text-5xl font-extrabold text-[#D4A373] mb-2">+500</p>
                <p class="text-white/90 text-sm font-medium">Usuarios Activos</p>
            </div>
        </div>
    </div>
</section>

<!-- 7. Compra por Estilo / Vibe -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center sm:text-left">
            <h2 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Encuentra tu Estilo</h2>
            <p class="text-[#607D8B]">Filtra por las estéticas más buscadas del momento</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('catalog', ['style' => 'streetwear']) }}" class="relative rounded-2xl overflow-hidden aspect-[3/4] group block">
                <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f25b?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex items-end p-6">
                    <h3 class="font-outfit font-bold text-white text-xl">Streetwear</h3>
                </div>
            </a>
            <a href="{{ route('catalog', ['style' => 'vintage']) }}" class="relative rounded-2xl overflow-hidden aspect-[3/4] group block">
                <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex items-end p-6">
                    <h3 class="font-outfit font-bold text-white text-xl">Vintage & 90s</h3>
                </div>
            </a>
            <a href="{{ route('catalog', ['style' => 'minimal']) }}" class="relative rounded-2xl overflow-hidden aspect-[3/4] group block">
                <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex items-end p-6">
                    <h3 class="font-outfit font-bold text-white text-xl">Minimalista</h3>
                </div>
            </a>
            <a href="{{ route('catalog', ['style' => 'y2k']) }}" class="relative rounded-2xl overflow-hidden aspect-[3/4] group block">
                <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex items-end p-6">
                    <h3 class="font-outfit font-bold text-white text-xl">Y2K / Trendy</h3>
                </div>
            </a>
        </div>
    </div>
</section>


<!-- 9. Beneficios -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="text-center px-4">
                <div class="w-16 h-16 bg-[#2E7D32]/10 text-[#2E7D32] rounded-2xl flex items-center justify-center mx-auto mb-6 transform -rotate-3">
                    <i class='bx bx-leaf text-3xl'></i>
                </div>
                <h3 class="font-outfit font-bold text-xl text-[#263238] mb-3">Moda Sustentable</h3>
                <p class="text-[#607D8B]">Dale una segunda vida a las prendas y reduce tu huella de carbono.</p>
            </div>
            <div class="text-center px-4">
                <div class="w-16 h-16 bg-[#D4A373]/10 text-[#D4A373] rounded-2xl flex items-center justify-center mx-auto mb-6 transform rotate-3">
                    <i class='bx bx-wallet text-3xl'></i>
                </div>
                <h3 class="font-outfit font-bold text-xl text-[#263238] mb-3">Gana Dinero</h3>
                <p class="text-[#607D8B]">Vende la ropa que ya no usas y genera ingresos extra de forma sencilla.</p>
            </div>
            <div class="text-center px-4">
                <div class="w-16 h-16 bg-[#2E7D32]/10 text-[#2E7D32] rounded-2xl flex items-center justify-center mx-auto mb-6 transform -rotate-3">
                    <i class='bx bx-shield-check text-3xl'></i>
                </div>
                <h3 class="font-outfit font-bold text-xl text-[#263238] mb-3">Compra Segura</h3>
                <p class="text-[#607D8B]">Protección en todas tus compras y pagos 100% seguros.</p>
            </div>
        </div>
    </div>
</section>



<!-- 11. Testimonios de la Comunidad -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Comunidad ReWear</h2>
            <p class="text-[#607D8B]">Lo que dicen nuestros compradores y vendedores</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-6 rounded-2xl border border-[#E5E7EB] bg-[#F8FAF7]">
                <div class="flex text-[#D4A373] mb-4">
                    <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i>
                </div>
                <p class="text-[#263238] text-sm mb-6 font-medium">"Vendí 5 chaquetas que ya no usaba en menos de una semana. La app es súper intuitiva y el pago fue muy seguro."</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#2E7D32] text-white font-bold flex items-center justify-center">S</div>
                    <div>
                        <p class="font-bold text-[#263238] text-sm">Sofía M.</p>
                        <p class="text-xs text-[#607D8B]">Vendedora Verificada</p>
                    </div>
                </div>
            </div>
            <div class="p-6 rounded-2xl border border-[#E5E7EB] bg-[#F8FAF7]">
                <div class="flex text-[#D4A373] mb-4">
                    <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i>
                </div>
                <p class="text-[#263238] text-sm mb-6 font-medium">"Hice mi primer trueque por unos tenis vintage. Todo el proceso fue claro y las prendas llegaron tal cual las fotos."</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#D4A373] text-white font-bold flex items-center justify-center">C</div>
                    <div>
                        <p class="font-bold text-[#263238] text-sm">Carlos R.</p>
                        <p class="text-xs text-[#607D8B]">Comprador Frecuente</p>
                    </div>
                </div>
            </div>
            <div class="p-6 rounded-2xl border border-[#E5E7EB] bg-[#F8FAF7]">
                <div class="flex text-[#D4A373] mb-4">
                    <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i>
                </div>
                <p class="text-[#263238] text-sm mb-6 font-medium">"Me encanta saber que estoy ayudando al medio ambiente mientras encuentro ropa única a una fracción de su precio original."</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#263238] text-white font-bold flex items-center justify-center">A</div>
                    <div>
                        <p class="font-bold text-[#263238] text-sm">Andrea L.</p>
                        <p class="text-xs text-[#607D8B]">Compradora</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 12. Banner Instalación PWA -->
<section class="py-16 bg-[#263238] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="text-center md:text-left">
            <span class="inline-block py-1 px-3 rounded-full bg-white/10 text-[#D4A373] text-xs font-bold tracking-wider uppercase mb-3">
                Experiencia App
            </span>
            <h2 class="font-outfit text-3xl font-bold mb-3">Lleva ReWear en tu teléfono</h2>
            <p class="text-gray-300 text-sm max-w-xl">Instala nuestra Progressive Web App (PWA) directamente en tu pantalla de inicio para recibir notificaciones de ofertas, ventas e intercambios en tiempo real.</p>
        </div>
        <div>
            <button id="pwa-install-btn" class="px-8 py-3.5 bg-[#2E7D32] hover:bg-[#236026] text-white font-semibold rounded-full shadow-lg transition-colors flex items-center gap-2 mx-auto">
                <i class='bx bx-mobile-alt text-xl'></i> Instalar Aplicación
            </button>
        </div>
    </div>
</section>
@endsection