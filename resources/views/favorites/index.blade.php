@extends('layouts.rewear')
@section('title', 'Mis Favoritos')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-8">
        <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Mis Favoritos</h1>
        <p class="text-[#607D8B]">Las prendas que te encantaron y guardaste para después.</p>
    </div>

    @if($favorites->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
            @foreach($favorites as $product)
                <!-- Reutilizamos el diseño de la tarjeta de producto -->
                <a href="{{ route('products.show', $product) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-[#E5E7EB] flex flex-col h-full relative block">
                    <!-- Imagen -->
                    <div class="relative aspect-[4/5] overflow-hidden bg-gray-100">
                        <img src="{{ $product->cover_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        <!-- Botón Favorito (Lleno) -->
                        <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="absolute top-3 right-3 z-10" onclick="event.preventDefault(); this.submit();">
                            @csrf
                            <button type="submit" class="w-8 h-8 bg-white/90 backdrop-blur text-red-500 rounded-full flex items-center justify-center shadow-sm hover:scale-110 transition-transform">
                                <i class='bx bxs-heart text-lg'></i>
                            </button>
                        </form>

                        @if(!$product->is_active || $product->is_sold)
                            <div class="absolute inset-0 bg-white/60 backdrop-blur-sm flex items-center justify-center z-0">
                                <span class="bg-[#263238] text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">No disponible</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Info -->
                    <div class="p-4 flex flex-col flex-1">
                        <div class="flex justify-between items-start gap-2 mb-1">
                            <h3 class="font-medium text-[#263238] text-sm leading-tight line-clamp-2 group-hover:text-[#2E7D32] transition-colors">{{ $product->title }}</h3>
                        </div>
                        <p class="text-xs text-[#607D8B] mb-2">{{ $product->brand ?? $product->category->name }} • Talla {{ $product->size ?? 'N/A' }}</p>
                        
                        <div class="mt-auto flex items-end justify-between pt-2">
                            <span class="font-bold text-[#263238]">{{ $product->formatted_price }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $favorites->links() }}
        </div>
    @else
        <div class="bg-white border border-[#E5E7EB] rounded-3xl p-12 text-center flex flex-col items-center">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <i class='bx bx-heart text-5xl text-[#607D8B]'></i>
            </div>
            <h2 class="font-outfit text-2xl font-bold text-[#263238] mb-2">Aún no tienes favoritos</h2>
            <p class="text-[#607D8B] mb-8 max-w-md mx-auto">Explora el catálogo y guarda las prendas que más te gusten dándoles al corazón.</p>
            <a href="{{ route('catalog') }}" class="px-8 py-3.5 bg-[#2E7D32] text-white font-semibold rounded-full shadow-soft hover:bg-[#1B5E20] transition-colors inline-flex items-center gap-2">
                Explorar catálogo
            </a>
        </div>
    @endif

</div>
@endsection
