@extends('layouts.rewear')
@section('title', 'Catálogo')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Breadcrumbs -->
    <nav class="flex text-sm text-[#607D8B] mb-8">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('home') }}" class="hover:text-[#2E7D32]">Inicio</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li class="text-[#263238] font-medium">Catálogo</li>
        </ol>
    </nav>

    <div class="flex flex-col md:flex-row gap-8">
        
        <!-- Sidebar Filtros -->
        <aside class="w-full md:w-64 flex-shrink-0" x-data="{ mobileFiltersOpen: false }">
            <div class="flex justify-between items-center md:hidden mb-4">
                <h2 class="font-outfit font-semibold text-lg">Filtros</h2>
                <button @click="mobileFiltersOpen = !mobileFiltersOpen" class="text-[#2E7D32] flex items-center gap-1 text-sm font-medium">
                    <i class='bx bx-filter-alt'></i> Mostrar filtros
                </button>
            </div>
            
            <form action="{{ route('catalog') }}" method="GET" class="space-y-8" :class="mobileFiltersOpen ? 'block' : 'hidden md:block'">
                <!-- Preservar búsqueda -->
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                
                <!-- Categorías -->
                <div>
                    <h3 class="font-semibold text-[#263238] mb-4">Categorías</h3>
                    <div class="space-y-2 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="category" value="" onchange="this.form.submit()" class="text-[#2E7D32] focus:ring-[#2E7D32]" {{ !request('category') ? 'checked' : '' }}>
                            <span class="text-sm text-[#607D8B]">Todas</span>
                        </label>
                        @foreach($categories as $category)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="category" value="{{ $category->slug }}" onchange="this.form.submit()" class="text-[#2E7D32] focus:ring-[#2E7D32]" {{ request('category') == $category->slug ? 'checked' : '' }}>
                                <span class="text-sm text-[#607D8B]">{{ $category->name }}</span>
                            </label>
                            <!-- Subcategorías si hay -->
                            @if($category->children->count() > 0)
                                <div class="ml-6 space-y-2 mt-2">
                                    @foreach($category->children as $child)
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="category" value="{{ $child->slug }}" onchange="this.form.submit()" class="text-[#2E7D32] focus:ring-[#2E7D32]" {{ request('category') == $child->slug ? 'checked' : '' }}>
                                            <span class="text-sm text-[#607D8B]">{{ $child->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Estado -->
                <div>
                    <h3 class="font-semibold text-[#263238] mb-4">Estado</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="condition" value="" onchange="this.form.submit()" class="text-[#2E7D32] focus:ring-[#2E7D32]" {{ !request('condition') ? 'checked' : '' }}>
                            <span class="text-sm text-[#607D8B]">Todos</span>
                        </label>
                        @foreach(\App\Models\Product::$conditions as $key => $label)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="condition" value="{{ $key }}" onchange="this.form.submit()" class="text-[#2E7D32] focus:ring-[#2E7D32]" {{ request('condition') == $key ? 'checked' : '' }}>
                                <span class="text-sm text-[#607D8B]">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Precio -->
                <div>
                    <h3 class="font-semibold text-[#263238] mb-4">Precio</h3>
                    <div class="flex items-center gap-2">
                        <input type="number" name="min_price" placeholder="Mín" value="{{ request('min_price') }}" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-lg text-sm focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                        <span class="text-[#607D8B]">-</span>
                        <input type="number" name="max_price" placeholder="Máx" value="{{ request('max_price') }}" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-lg text-sm focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                    </div>
                    <button type="submit" class="w-full mt-3 bg-white border border-[#2E7D32] text-[#2E7D32] py-2 rounded-lg text-sm font-medium hover:bg-[#2E7D32]/5 transition-colors">
                        Aplicar Precio
                    </button>
                </div>
                
                @if(request()->anyFilled(['category', 'condition', 'min_price', 'max_price', 'search']))
                    <a href="{{ route('catalog') }}" class="block text-center text-sm text-[#E53935] font-medium hover:underline">
                        Limpiar todos los filtros
                    </a>
                @endif
            </form>
        </aside>

        <!-- Product Grid -->
        <div class="flex-1">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <h1 class="font-outfit text-3xl font-bold text-[#263238]">
                    @if(request('search'))
                        Resultados para "{{ request('search') }}"
                    @elseif(request('category'))
                        Prendas en esta categoría
                    @else
                        Todo el catálogo
                    @endif
                    <span class="text-lg font-normal text-[#607D8B] ml-2">({{ $products->total() }} artículos)</span>
                </h1>
                
                <div class="flex items-center gap-2">
                    <label class="text-sm text-[#607D8B]">Ordenar por:</label>
                    <form action="{{ route('catalog') }}" method="GET" id="sortForm">
                        @foreach(request()->except(['sort', 'page']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="sort" onchange="document.getElementById('sortForm').submit()" class="border-transparent bg-[#F8FAF7] text-sm font-medium rounded-lg focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20 py-2 pl-3 pr-8 cursor-pointer">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Más recientes</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                        </select>
                    </form>
                </div>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
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
                
                <!-- Paginación -->
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white border border-[#E5E7EB] rounded-2xl p-12 text-center flex flex-col items-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <i class='bx bx-search-alt-2 text-4xl text-[#607D8B]'></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#263238] mb-2">No encontramos resultados</h3>
                    <p class="text-[#607D8B] mb-6">Intenta ajustando los filtros o buscando con otros términos.</p>
                    <a href="{{ route('catalog') }}" class="px-6 py-2.5 bg-[#2E7D32] text-white font-medium rounded-full shadow-soft hover:bg-[#1B5E20] transition-colors">
                        Ver todo el catálogo
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
