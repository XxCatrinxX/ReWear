@extends('layouts.rewear')

@section('content')
<!-- Hero Section -->
<section class="relative bg-[#2E7D32] text-white overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <!-- Patrón o imagen de fondo (placeholder) -->
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
                Compra y vende ropa de segunda mano con estilo. Únete a la comunidad de moda sustentable más grande de México.
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
            <!-- Imagen hero placeholder -->
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

<!-- Categorías Destacadas -->
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

<!-- Productos Recientes -->
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
                <!-- Product Card Component -->
                <div class="bg-white rounded-2xl overflow-hidden border border-[#E5E7EB] hover:shadow-card transition-all duration-300 group flex flex-col h-full relative">
                    
                    <!-- Wishlist Button -->
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
        
        <div class="mt-8 text-center sm:hidden">
            <a href="{{ route('catalog') }}" class="inline-block px-6 py-2.5 bg-white border border-[#E5E7EB] text-[#263238] font-medium rounded-full shadow-sm">Ver todo el catálogo</a>
        </div>
    </div>
</section>

<!-- Beneficios -->
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
@endsection
