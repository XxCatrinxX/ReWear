@extends('layouts.rewear')
@section('title', 'Configuración del Perfil')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-8">
        <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Configuración</h1>
        <p class="text-[#607D8B]">Gestiona tu información personal, dirección y seguridad.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8" x-data="{ tab: 'profile' }" @hashchange.window="tab = window.location.hash.replace('#', '') || 'profile'">
        
        <!-- Sidebar Navigation -->
        <div class="w-full lg:w-1/4">
            <nav class="space-y-1">
                <button @click="tab = 'profile'" :class="{ 'bg-[#F8FAF7] text-[#2E7D32] border-[#2E7D32]': tab === 'profile', 'text-[#607D8B] hover:bg-gray-50 border-transparent': tab !== 'profile' }" class="w-full text-left px-4 py-3 border-l-2 font-medium transition-colors flex items-center gap-2">
                    <i class='bx bx-user text-xl'></i> Información Personal
                </button>
                <button @click="tab = 'address'" :class="{ 'bg-[#F8FAF7] text-[#2E7D32] border-[#2E7D32]': tab === 'address', 'text-[#607D8B] hover:bg-gray-50 border-transparent': tab !== 'address' }" class="w-full text-left px-4 py-3 border-l-2 font-medium transition-colors flex items-center gap-2">
                    <i class='bx bx-map text-xl'></i> Dirección de Envío
                </button>
                <button @click="tab = 'security'" :class="{ 'bg-[#F8FAF7] text-[#2E7D32] border-[#2E7D32]': tab === 'security', 'text-[#607D8B] hover:bg-gray-50 border-transparent': tab !== 'security' }" class="w-full text-left px-4 py-3 border-l-2 font-medium transition-colors flex items-center gap-2">
                    <i class='bx bx-lock-alt text-xl'></i> Seguridad
                </button>
            </nav>

            @if(!auth()->user()->isSeller())
                <div class="mt-8 bg-[#F8FAF7] rounded-2xl p-6 border border-[#E5E7EB]">
                    <div class="w-12 h-12 bg-[#2E7D32]/10 text-[#2E7D32] rounded-full flex items-center justify-center text-2xl mb-4">
                        <i class='bx bx-store-alt'></i>
                    </div>
                    <h3 class="font-bold text-[#263238] mb-2">Vende tu ropa</h3>
                    <p class="text-sm text-[#607D8B] mb-4">Gana dinero dándole una segunda vida a las prendas que ya no usas.</p>
                    <a href="{{ route('profile.become-seller') }}" class="block w-full text-center bg-[#2E7D32] text-white font-medium py-2 rounded-xl hover:bg-[#1B5E20] transition-colors">
                        Convertirme en vendedor
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Content Area -->
        <div class="w-full lg:w-3/4">
            
            <!-- Tab: Profile -->
            <div x-show="tab === 'profile'">
                <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden">
                    <div class="px-6 py-4 border-b border-[#E5E7EB] bg-[#F8FAF7]">
                        <h2 class="font-outfit font-semibold text-[#263238] text-lg">Información Personal</h2>
                    </div>
                    <div class="p-6 lg:p-8">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <!-- Avatar -->
                            <div class="flex items-center gap-6 mb-8">
                                <div class="relative">
                                    <img src="{{ auth()->user()->avatar_url }}" class="w-24 h-24 rounded-full object-cover border-4 border-[#F8FAF7] shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-2">Foto de perfil</label>
                                    <input type="file" name="avatar" accept="image/*" class="text-sm text-[#607D8B]
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-[#2E7D32]/10 file:text-[#2E7D32]
                                        hover:file:bg-[#2E7D32]/20
                                        cursor-pointer">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Nombre (Público) *</label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Nombre (Legal)</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', auth()->user()->profile?->first_name) }}" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Apellidos (Legal)</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', auth()->user()->profile?->last_name) }}" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Correo electrónico *</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Teléfono</label>
                                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->profile?->phone) }}" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Fecha de nacimiento</label>
                                    <input type="date" name="birth_date" value="{{ old('birth_date', auth()->user()->profile?->birth_date?->format('Y-m-d')) }}" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                            </div>

                            <div class="pt-4 mt-6 border-t border-[#E5E7EB] flex justify-end">
                                <button type="submit" class="bg-[#2E7D32] text-white px-6 py-2.5 rounded-xl font-medium hover:bg-[#1B5E20] transition-colors">
                                    Guardar cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab: Address -->
            <div x-show="tab === 'address'" style="display: none;">
                <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden">
                    <div class="px-6 py-4 border-b border-[#E5E7EB] bg-[#F8FAF7]">
                        <h2 class="font-outfit font-semibold text-[#263238] text-lg">Dirección de Envío</h2>
                    </div>
                    <div class="p-6 lg:p-8">
                        
                        @php
                            $address = auth()->user()->addresses()->first();
                        @endphp
                        
                        <form method="POST" action="{{ route('addresses.store') }}" class="space-y-6">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Identificador *</label>
                                    <input type="text" name="label" value="{{ old('label', $address?->label ?? 'Casa') }}" placeholder="Ej: Casa, Trabajo" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Nombre de quien recibe *</label>
                                    <input type="text" name="recipient_name" value="{{ old('recipient_name', $address?->recipient_name) }}" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Calle *</label>
                                    <input type="text" name="street" value="{{ old('street', $address?->street) }}" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Número Exterior</label>
                                    <input type="text" name="exterior_number" value="{{ old('exterior_number', $address?->exterior_number) }}" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Número Interior</label>
                                    <input type="text" name="interior_number" value="{{ old('interior_number', $address?->interior_number) }}" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Colonia / Barrio</label>
                                    <input type="text" name="neighborhood" value="{{ old('neighborhood', $address?->neighborhood) }}" class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Código Postal *</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code', $address?->postal_code) }}" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Ciudad / Municipio *</label>
                                    <input type="text" name="city" value="{{ old('city', $address?->city) }}" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Estado *</label>
                                    <input type="text" name="state" value="{{ old('state', $address?->state) }}" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                                
                                <input type="hidden" name="country" value="México">
                                <input type="hidden" name="is_default" value="1">
                            </div>

                            <div class="pt-4 mt-6 border-t border-[#E5E7EB] flex justify-end">
                                <button type="submit" class="bg-[#2E7D32] text-white px-6 py-2.5 rounded-xl font-medium hover:bg-[#1B5E20] transition-colors">
                                    Guardar dirección
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab: Security -->
            <div x-show="tab === 'security'" style="display: none;">
                <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-[#E5E7EB] bg-[#F8FAF7]">
                        <h2 class="font-outfit font-semibold text-[#263238] text-lg">Actualizar Contraseña</h2>
                    </div>
                    <div class="p-6 lg:p-8">
                        @if (session('status') === 'password-updated')
                            <div class="bg-[#43A047]/10 border border-[#43A047]/20 text-[#2E7D32] px-4 py-3 rounded-xl mb-4 text-sm font-medium">
                                Contraseña actualizada exitosamente.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            @method('put')

                            <div class="max-w-xl space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Contraseña actual</label>
                                    <input type="password" name="current_password" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                    @error('current_password', 'updatePassword')
                                        <p class="text-[#E53935] text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Nueva contraseña</label>
                                    <input type="password" name="password" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                    @error('password', 'updatePassword')
                                        <p class="text-[#E53935] text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#263238] mb-1">Confirmar nueva contraseña</label>
                                    <input type="password" name="password_confirmation" required class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="bg-[#2E7D32] text-white px-6 py-2.5 rounded-xl font-medium hover:bg-[#1B5E20] transition-colors">
                                    Guardar contraseña
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="bg-red-50 rounded-3xl border border-red-100 overflow-hidden">
                    <div class="p-6 lg:p-8">
                        <h2 class="font-outfit font-semibold text-red-800 text-lg mb-2">Eliminar Cuenta</h2>
                        <p class="text-sm text-red-600 mb-6 max-w-2xl">
                            Una vez que se elimine tu cuenta, todos sus recursos y datos se borrarán permanentemente. Antes de eliminar tu cuenta, descarga cualquier dato o información que desees conservar.
                        </p>
                        
                        <form method="POST" action="{{ route('profile.destroy') }}" x-data="{ confirmingDelete: false }">
                            @csrf
                            @method('delete')

                            <div x-show="!confirmingDelete">
                                <button type="button" @click="confirmingDelete = true" class="bg-red-600 text-white px-6 py-2.5 rounded-xl font-medium hover:bg-red-700 transition-colors">
                                    Eliminar cuenta
                                </button>
                            </div>
                            
                            <div x-show="confirmingDelete" style="display: none;" class="mt-4">
                                <label class="block text-sm font-medium text-red-800 mb-1">Confirma tu contraseña para continuar:</label>
                                <div class="flex gap-4 items-start">
                                    <input type="password" name="password" placeholder="Contraseña" class="max-w-xs w-full bg-white border-red-300 rounded-xl focus:border-red-500 focus:ring focus:ring-red-500/20">
                                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-xl font-medium hover:bg-red-700 transition-colors">
                                        Confirmar eliminación
                                    </button>
                                    <button type="button" @click="confirmingDelete = false" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                                        Cancelar
                                    </button>
                                </div>
                                @error('password', 'userDeletion')
                                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
