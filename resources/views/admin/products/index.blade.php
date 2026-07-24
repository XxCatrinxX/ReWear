@extends('layouts.admin')
@section('title', 'Gestión de Productos')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
    <div>
        <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Productos</h1>
        <p class="text-[#607D8B]">Administra el catálogo de prendas publicadas.</p>
    </div>
    
    <div class="w-full md:w-auto">
        <form action="{{ route('admin.products.index') }}" method="GET" class="relative">
            <input type="text" name="search" placeholder="Buscar por título o marca..." value="{{ request('search') }}"
                class="w-full md:w-64 bg-white border border-[#E5E7EB] rounded-full py-2 pl-10 pr-4 text-sm focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
            <i class='bx bx-search absolute left-3.5 top-1/2 -translate-y-1/2 text-[#607D8B] text-lg'></i>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-[#E5E7EB] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-xs text-[#607D8B] uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium">Producto</th>
                    <th class="px-6 py-4 font-medium">Vendedor</th>
                    <th class="px-6 py-4 font-medium">Precio</th>
                    <th class="px-6 py-4 font-medium text-center">Estado</th>
                    <th class="px-6 py-4 font-medium text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E7EB]">
                @foreach($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-16 rounded overflow-hidden bg-gray-100 flex-shrink-0 border border-[#E5E7EB]">
                                    <img src="{{ $product->cover_url }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-medium text-[#263238] text-sm line-clamp-1 max-w-xs" title="{{ $product->title }}">{{ $product->title }}</p>
                                    <p class="text-xs text-[#607D8B]">{{ $product->category->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ $product->user->avatar_url }}" class="w-6 h-6 rounded-full border border-[#E5E7EB]">
                                <span class="text-sm text-[#263238]">{{ $product->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-[#263238]">
                            {{ $product->formatted_price }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($product->is_sold)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Vendido</span>
                            @elseif($product->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Activo</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Ver Producto -->
                                <a href="{{ route('products.show', $product) }}" target="_blank" class="p-2 text-[#607D8B] hover:text-[#2E7D32] hover:bg-[#F8FAF7] rounded-lg transition-colors" title="Ver en catálogo">
                                    <i class='bx bx-link-external text-xl'></i>
                                </a>
                                
                                <!-- Cambiar Estado -->
                                <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 rounded-lg transition-colors {{ $product->is_active ? 'text-yellow-600 hover:bg-yellow-50' : 'text-green-600 hover:bg-green-50' }}" title="{{ $product->is_active ? 'Desactivar (ocultar)' : 'Activar' }}">
                                        <i class='bx {{ $product->is_active ? 'bx-hide' : 'bx-show' }} text-xl'></i>
                                    </button>
                                </form>
                            </div>
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
@endsection
