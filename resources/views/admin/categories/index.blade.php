@extends('layouts.admin')
@section('title', 'Gestión de Categorías')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4" x-data="{ showCreateModal: false }">
    <div>
        <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Categorías</h1>
        <p class="text-[#607D8B]">Administra la estructura del catálogo.</p>
    </div>
    
    <button @click="showCreateModal = true" class="px-6 py-2.5 bg-[#2E7D32] text-white font-semibold rounded-xl shadow-soft hover:bg-[#1B5E20] transition-colors inline-flex items-center gap-2">
        <i class='bx bx-plus'></i> Nueva Categoría
    </button>

    <!-- Modal Crear -->
    <div x-show="showCreateModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showCreateModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showCreateModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showCreateModal" x-transition.scale.origin.bottom class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-semibold text-[#263238] mb-4" id="modal-title">Nueva Categoría</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-[#263238] mb-1">Nombre *</label>
                                <input type="text" name="name" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#263238] mb-1">Categoría Padre (Opcional)</label>
                                <select name="parent_id" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                    <option value="">Ninguna (Categoría Principal)</option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#263238] mb-1">Ícono (Opcional, de BoxIcons)</label>
                                <input type="text" name="icon" placeholder="Ej: bx bx-t-shirt" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20 text-sm">
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#F8FAF7] px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-[#E5E7EB]">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-[#2E7D32] text-base font-medium text-white hover:bg-[#1B5E20] sm:ml-3 sm:w-auto sm:text-sm">
                            Guardar
                        </button>
                        <button type="button" @click="showCreateModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-[#E5E7EB] shadow-sm px-4 py-2 bg-white text-base font-medium text-[#607D8B] hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-[#E5E7EB] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-xs text-[#607D8B] uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium">Nombre / Ícono</th>
                    <th class="px-6 py-4 font-medium">Tipo</th>
                    <th class="px-6 py-4 font-medium">Productos</th>
                    <th class="px-6 py-4 font-medium text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E7EB]">
                @foreach($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors" x-data="{ showEditModal: false }">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-[#2E7D32]/10 text-[#2E7D32] flex items-center justify-center">
                                    <i class='{{ $category->icon ?? 'bx bx-category' }} text-lg'></i>
                                </div>
                                <div>
                                    <p class="font-medium text-[#263238] text-sm">{{ $category->name }}</p>
                                    <p class="text-xs text-[#607D8B] font-mono">{{ $category->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($category->parent_id)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-600 uppercase tracking-wider">Subcategoría</span>
                                <p class="text-xs text-[#607D8B] mt-1">De: {{ $category->parent->name }}</p>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#D4A373]/20 text-[#b88c63] uppercase tracking-wider">Principal</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-[#263238]">
                            {{ $category->products_count }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="showEditModal = true" class="p-2 text-[#607D8B] hover:text-[#2E7D32] hover:bg-[#F8FAF7] rounded-lg transition-colors" title="Editar">
                                    <i class='bx bx-edit text-xl'></i>
                                </button>
                                
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="if(confirm('¿Eliminar esta categoría?')) this.form.submit();" class="p-2 text-[#607D8B] hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                        <!-- Modal Editar -->
                        <td class="hidden">
                            <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="showEditModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showEditModal = false"></div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div x-show="showEditModal" x-transition.scale.origin.bottom class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full text-left">
                                        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 text-left">
                                                <h3 class="text-lg leading-6 font-semibold text-[#263238] mb-4">Editar Categoría</h3>
                                                <div class="space-y-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-[#263238] mb-1">Nombre *</label>
                                                        <input type="text" name="name" value="{{ $category->name }}" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-[#263238] mb-1">Categoría Padre (Opcional)</label>
                                                        <select name="parent_id" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                                            <option value="">Ninguna (Categoría Principal)</option>
                                                            @foreach($parents as $parent)
                                                                @if($parent->id !== $category->id)
                                                                    <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-[#263238] mb-1">Ícono</label>
                                                        <input type="text" name="icon" value="{{ $category->icon }}" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20 text-sm">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-[#F8FAF7] px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-[#E5E7EB]">
                                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-[#2E7D32] text-base font-medium text-white hover:bg-[#1B5E20] sm:ml-3 sm:w-auto sm:text-sm">
                                                    Actualizar
                                                </button>
                                                <button type="button" @click="showEditModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-[#E5E7EB] shadow-sm px-4 py-2 bg-white text-base font-medium text-[#607D8B] hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $categories->links() }}
</div>
@endsection
