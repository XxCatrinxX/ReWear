@extends('layouts.rewear')
@section('title', 'Publicar producto')

@section('content')
@if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
        <h4 class="text-red-800 font-bold mb-1">Error de validación:</h4>
        <ul class="list-disc list-inside text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-8">
        <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Vender ropa</h1>
        <p class="text-[#607D8B]">Completa los datos para publicar tu prenda en el marketplace.</p>
    </div>

    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden">
        @csrf
        
        <div class="p-8 space-y-8">
            
            <!-- Información Básica -->
            <div>
                <h3 class="text-lg font-semibold text-[#263238] border-b border-[#E5E7EB] pb-2 mb-4">Información básica</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Título de la publicación *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Ej: Chamarra de mezclilla Levi's vintage" 
                            class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                        @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Descripción *</label>
                        <textarea name="description" rows="4" required placeholder="Describe el estado de la prenda, medidas, si tiene algún detalle..."
                            class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">{{ old('description') }}</textarea>
                        <p class="text-xs text-[#607D8B] mt-1">Mínimo 20 caracteres.</p>
                        @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Detalles y Categorización -->
            <div>
                <h3 class="text-lg font-semibold text-[#263238] border-b border-[#E5E7EB] pb-2 mb-4">Detalles de la prenda</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Categoría *</label>
                        <select name="category_id" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>General - {{ $category->name }}</option>
                                    @foreach($category->children as $child)
                                        <option value="{{ $child->id }}" {{ old('category_id') == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Estado de la prenda *</label>
                        <select name="condition" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                            <option value="">Selecciona el estado</option>
                            @foreach($conditions as $key => $label)
                                <option value="{{ $key }}" {{ old('condition') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('condition') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
    <label class="block text-sm font-medium text-[#263238] mb-1">Marca</label>
    <select name="brand" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
        <option value="">Selecciona una marca</option>
        @foreach($brands as $key => $brandName)
            @php $value = is_string($key) ? $key : $brandName; @endphp
            <option value="{{ $value }}" {{ old('brand', $product->brand ?? '') == $value ? 'selected' : '' }}>
                {{ $brandName }}
            </option>
        @endforeach
    </select>
    @error('brand') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
</div>

                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Talla</label>
                        <select name="size" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                            <option value="">Selecciona o escribe una talla</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size }}" {{ old('size') == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- SELECTOR DE COLOR CON CÍRCULO Y ALPINE.JS -->
                    <div x-data="{ 
                        open: false, 
                        selected: '{{ old('color', '') }}',
                        selectedHex: '',
                        colors: {{ Js::from(collect($colors)->map(fn($hex, $name) => ['name' => $name, 'hex' => $hex])->values()) }},
                        init() {
                            if (this.selected) {
                                let match = this.colors.find(c => c.name === this.selected);
                                if (match) { this.selectedHex = match.hex; }
                            }
                        }
                    }" class="relative">

                        <label class="block text-sm font-medium text-[#263238] mb-1">Color principal *</label>

                        <!-- Input oculto para enviar POST al backend -->
                        <input type="hidden" name="color" :value="selected" required>

                        <!-- Botón del dropdown -->
                        <button type="button" @click="open = !open" @click.away="open = false" 
                            class="w-full bg-[#F8FAF7] border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-left flex items-center justify-between focus:outline-none focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                            
                            <div class="flex items-center gap-2.5 truncate">
                                <template x-if="selectedHex">
                                    <span class="w-4 h-4 rounded-full border border-gray-300 shadow-sm flex-shrink-0" :style="'background: ' + selectedHex"></span>
                                </template>
                                <span class="text-sm" :class="selected ? 'text-[#263238] font-medium' : 'text-gray-400'" x-text="selected ? selected : 'Selecciona un color'"></span>
                            </div>

                            <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Menú con lista de colores -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-cloak
                             class="absolute z-50 mt-2 w-full bg-white border border-[#E5E7EB] rounded-2xl shadow-lg max-h-60 overflow-y-auto py-1">
                            
                            <template x-for="c in colors" :key="c.name">
                                <button type="button" 
                                    @click="selected = c.name; selectedHex = c.hex; open = false;"
                                    class="w-full px-4 py-2.5 text-sm flex items-center gap-3 hover:bg-[#F8FAF7] transition-colors text-left"
                                    :class="{ 'bg-[#2E7D32]/10 font-semibold text-[#2E7D32]': selected === c.name }">
                                    
                                    <span class="w-4 h-4 rounded-full border border-gray-300 shadow-sm flex-shrink-0" :style="'background: ' + c.hex"></span>
                                    <span x-text="c.name" class="text-[#263238]"></span>
                                </button>
                            </template>
                        </div>

                        @error('color') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                </div>
            </div>

            <!-- Precio y stock -->
            <div>
                <h3 class="text-lg font-semibold text-[#263238] border-b border-[#E5E7EB] pb-2 mb-4">Precio y disponibilidad</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Precio (MXN) *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-[#607D8B]">$</span>
                            </div>
                            <input type="number" step="0.01" min="1" name="price" value="{{ old('price') }}" required 
                                class="w-full pl-8 bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                        </div>
                        @error('price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#263238] mb-1">Stock *</label>
                        <input type="number" min="1" name="stock" value="{{ old('stock', 1) }}" required 
                            class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                        <p class="text-xs text-[#607D8B] mt-1">Cantidad disponible de esta prenda idéntica.</p>
                        @error('stock') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Fotos -->
            <div>
                <h3 class="text-lg font-semibold text-[#263238] border-b border-[#E5E7EB] pb-2 mb-4">Fotos de la prenda</h3>
                
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-2">Sube hasta 8 fotos</label>
                    <div class="border-2 border-dashed border-[#E5E7EB] rounded-2xl p-8 text-center bg-[#F8FAF7]">
                        <input type="file" name="images[]" multiple accept="image/*" class="w-full max-w-xs mx-auto text-sm text-[#607D8B]
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-[#2E7D32]/10 file:text-[#2E7D32]
                            hover:file:bg-[#2E7D32]/20
                            cursor-pointer
                        ">
                        <p class="text-xs text-[#607D8B] mt-4">JPG, PNG o WEBP. Máximo 5MB por foto. La primera foto será la portada.</p>
                    </div>
                    @error('images') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    @error('images.*') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

        </div>

        <!-- Submit -->
        <div class="bg-[#F8FAF7] px-8 py-5 border-t border-[#E5E7EB] flex items-center justify-end gap-4">
            <a href="{{ route('seller.dashboard') }}" class="text-[#607D8B] font-medium hover:text-[#263238]">Cancelar</a>
            <button type="submit" class="bg-[#2E7D32] text-white font-semibold py-2.5 px-6 rounded-xl shadow-soft hover:bg-[#1B5E20] transition-colors">
                Publicar prenda
            </button>
        </div>
    </form>
</div>
@endsection