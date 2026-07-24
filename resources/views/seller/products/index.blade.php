@extends('layouts.rewear')
@section('title', 'Mis Publicaciones')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <nav class="flex text-sm text-[#607D8B] mb-2">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('seller.dashboard') }}" class="hover:text-[#2E7D32]">Panel</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li class="text-[#263238] font-medium">Mis Publicaciones</li>
                </ol>
            </nav>
            <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Tus prendas a la venta</h1>
            <p class="text-[#607D8B]">Gestiona tu inventario, edita precios o agrega nuevas prendas.</p>
        </div>
        <a href="{{ route('seller.products.create') }}" class="px-6 py-2.5 bg-[#2E7D32] text-white font-semibold rounded-xl shadow-soft hover:bg-[#1B5E20] transition-colors inline-flex items-center gap-2">
            <i class='bx bx-plus'></i> Nueva publicación
        </a>
    </div>

    @if($products->count() > 0)
        <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-sm text-[#607D8B] uppercase tracking-wider">
                            <th class="px-6 py-4 font-medium">Producto</th>
                            <th class="px-6 py-4 font-medium">Precio</th>
                            <th class="px-6 py-4 font-medium">Stock</th>
                            <th class="px-6 py-4 font-medium">Estado</th>
                            <th class="px-6 py-4 font-medium text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        @foreach($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-20 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0 border border-[#E5E7EB]">
                                            <img src="{{ $product->cover_url }}" alt="" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <a href="{{ route('products.show', $product) }}" target="_blank" class="font-medium text-[#263238] hover:text-[#2E7D32]">{{ $product->title }}</a>
                                            <p class="text-sm text-[#607D8B] mt-1">{{ $product->category->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-[#263238]">
                                    {{ $product->formatted_price }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-[#263238]">{{ $product->stock }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->is_sold)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Vendido</span>
                                    @elseif($product->is_active)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Activo</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Pausado</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('seller.products.edit', $product) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-[#607D8B] hover:text-[#2E7D32] hover:bg-[#F8FAF7] transition-colors" title="Editar">
                                        <i class='bx bx-edit text-xl'></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="bg-white border border-[#E5E7EB] rounded-3xl p-12 text-center flex flex-col items-center">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <i class='bx bxs-t-shirt text-5xl text-[#607D8B]'></i>
            </div>
            <h2 class="font-outfit text-2xl font-bold text-[#263238] mb-2">No tienes publicaciones</h2>
            <p class="text-[#607D8B] mb-8">Comienza a ganar dinero vendiendo la ropa que ya no usas.</p>
            <a href="{{ route('seller.products.create') }}" class="px-8 py-3.5 bg-[#2E7D32] text-white font-semibold rounded-full shadow-soft hover:bg-[#1B5E20] transition-colors inline-flex items-center gap-2">
                <i class='bx bx-plus'></i> Crear primera publicación
            </a>
        </div>
    @endif

</div>
@endsection
