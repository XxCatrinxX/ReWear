@extends('layouts.rewear')
@section('title', 'Editar: ' . $product->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ 
    imagesToDelete: [],
    toggleDelete(id) {
        if (this.imagesToDelete.includes(id)) {
            this.imagesToDelete = this.imagesToDelete.filter(i => i !== id);
        } else {
            this.imagesToDelete.push(id);
        }
    }
}">
    
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Editar publicación</h1>
            <p class="text-[#607D8B]">Actualiza los datos o fotos de tu prenda.</p>
        </div>
        <a href="{{ route('products.show', $product) }}" class="text-[#2E7D32] hover:underline text-sm font-medium">
            Ver publicación <i class='bx bx-link-external align-middle'></i>
        </a>
    </div>

    <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden">
        @csrf
        @method('PATCH')
        
        <div class="p-8 space-y-8">
            
            @if($product->is_sold || $product->stock <= 0)
                <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl p-4 flex items-center gap-3">
                    <i class='bx bx-info-circle text-2xl text-amber-600 flex-shrink-0'></i>
                    <p class="text-xs font-medium">
                        <strong>Producto actualmente AGOTADO:</strong> Al incrementar la cantidad en el campo <strong>Stock</strong> a 1 o más y guardar los cambios, la publicación se reactivará automáticamente y volverá a mostrarse en el catálogo.
                    </p>
                </div>
            @endif

            <!-- Estado de publicación -->
            <div class="bg-[#F8FAF7] border border-[#E5E7EB] rounded-2xl p-6 flex justify-between items-center">
                <div>
                    <h3 class="font-semibold text-[#263238] mb-1">Visibilidad</h3>
                    <p class="text-sm text-[#607D8B]">Controla si tu producto es visible en el catálogo.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <!-- Para que se envíe 0 si se desmarca -->
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#2E7D32]"></div>
                </label>
            </div>

            <!-- Información Básica -->
            <div>
                <h3 class="text-lg font-semibold text-[#263238] border-b border-[#E5E7EB] pb-2 mb-4">Información básica</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Título de la publicación *</label>
                        <input type="text" name="title" value="{{ old('title', $product->title) }}" required 
                            class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                        @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Descripción *</label>
                        <textarea name="description" rows="5" required
                            class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">{{ old('description', $product->description) }}</textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Detalles -->
            <div>
                <h3 class="text-lg font-semibold text-[#263238] border-b border-[#E5E7EB] pb-2 mb-4">Detalles de la prenda</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Categoría *</label>
                        <select name="category_id" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                            @foreach($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>General - {{ $category->name }}</option>
                                    @foreach($category->children as $child)
                                        <option value="{{ $child->id }}" {{ old('category_id', $product->category_id) == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Estado *</label>
                        <select name="condition" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                            @foreach($conditions as $key => $label)
                                <option value="{{ $key }}" {{ old('condition', $product->condition) == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Marca</label>
                        <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" 
                            class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Talla</label>
                        <select name="size" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                            <option value="">Ninguna</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size }}" {{ old('size', $product->size) == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Color</label>
                        <input type="text" name="color" value="{{ old('color', $product->color) }}" 
                            class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                    </div>
                </div>
            </div>

            <!-- Precio y Stock -->
            <div>
                <h3 class="text-lg font-semibold text-[#263238] border-b border-[#E5E7EB] pb-2 mb-4">Precio y stock</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Precio (MXN) *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-[#607D8B]">$</span>
                            </div>
                            <input type="number" step="0.01" min="1" name="price" value="{{ old('price', $product->price) }}" required 
                                class="w-full pl-8 bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Stock *</label>
                        <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock) }}" required 
                            class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                    </div>
                </div>
            </div>

            <!-- Fotos Actuales y Nuevas -->
            <div>
                <h3 class="text-lg font-semibold text-[#263238] border-b border-[#E5E7EB] pb-2 mb-4">Fotos de la prenda</h3>
                
                @if($product->images->count() > 0)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-[#263238] mb-2">Fotos actuales (selecciona para eliminar)</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach($product->images as $image)
                                <div class="relative w-24 h-24 rounded-lg overflow-hidden border-2 cursor-pointer transition-all"
                                     :class="imagesToDelete.includes({{ $image->id }}) ? 'border-red-500 opacity-50' : 'border-transparent'"
                                     @click="toggleDelete({{ $image->id }})">
                                    <img src="{{ $image->url }}" class="w-full h-full object-cover">
                                    <div x-show="imagesToDelete.includes({{ $image->id }})" class="absolute inset-0 bg-red-500/20 flex items-center justify-center text-white" style="display: none;">
                                        <i class='bx bx-trash text-2xl drop-shadow-md'></i>
                                    </div>
                                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" x-model="imagesToDelete" class="hidden">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-2">Añadir más fotos</label>
                    <div class="border-2 border-dashed border-[#E5E7EB] rounded-2xl p-6 text-center bg-[#F8FAF7]">
                        <input type="file" name="images[]" multiple accept="image/*" class="w-full max-w-xs mx-auto text-sm text-[#607D8B]
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-[#2E7D32]/10 file:text-[#2E7D32]
                            hover:file:bg-[#2E7D32]/20
                            cursor-pointer
                        ">
                    </div>
                    @error('images') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

        </div>

        <!-- Submit -->
        <div class="bg-[#F8FAF7] px-8 py-5 border-t border-[#E5E7EB] flex justify-between items-center">
            
            <button type="button" onclick="if(confirm('¿Estás seguro de que quieres eliminar esta publicación?')) document.getElementById('delete-form').submit();" 
                    class="text-red-500 font-medium hover:text-red-700 text-sm flex items-center gap-1">
                <i class='bx bx-trash'></i> Eliminar
            </button>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('seller.dashboard') }}" class="text-[#607D8B] font-medium hover:text-[#263238] text-sm">Cancelar</a>
                <button type="submit" class="bg-[#2E7D32] text-white font-semibold py-2.5 px-6 rounded-xl shadow-soft hover:bg-[#1B5E20] transition-colors">
                    Guardar cambios
                </button>
            </div>
        </div>
    </form>
    
    <!-- Formulario para eliminar -->
    <form id="delete-form" action="{{ route('seller.products.destroy', $product) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection
