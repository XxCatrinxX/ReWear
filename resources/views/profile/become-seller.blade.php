@extends('layouts.rewear')
@section('title', 'Convertirse en Vendedor')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Conviértete en Vendedor</h1>
        <p class="text-[#607D8B]">Completa tus datos de domicilio y sube tu identificación oficial para empezar a vender tus prendas.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-6">
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.become-seller.store') }}" enctype="multipart/form-data" class="space-y-8 bg-white p-6 sm:p-8 rounded-3xl shadow-soft border border-[#E5E7EB]">
        @csrf

        <!-- Sección 1: Domicilio del Vendedor -->
        <div>
            <h3 class="font-outfit font-semibold text-lg text-[#263238] mb-4 pb-2 border-b border-[#E5E7EB]">
                <i class='bx bx-map-pin text-xl text-[#2E7D32] align-middle mr-1'></i> Dirección del Remitente
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1">Identificador de Dirección *</label>
                    <input type="text" name="label" value="{{ old('label', $address?->label ?? 'Mi Domicilio') }}" required class="input" placeholder="Ej: Mi Casa, Local comercial">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1">Nombre Completo *</label>
                    <input type="text" name="recipient_name" value="{{ old('recipient_name', $address?->recipient_name ?? $user->name) }}" required class="input" placeholder="Nombre completo">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1">Teléfono de Contacto *</label>
                    <input type="text" name="phone" value="{{ old('phone', $address?->phone ?? $user->profile?->phone) }}" required class="input" placeholder="10 dígitos">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1">Calle *</label>
                    <input type="text" name="street" value="{{ old('street', $address?->street) }}" required class="input" placeholder="Nombre de la calle">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1">Número Exterior *</label>
                    <input type="text" name="exterior_number" value="{{ old('exterior_number', $address?->exterior_number) }}" required class="input" placeholder="Ej: 123">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1">Número Interior</label>
                    <input type="text" name="interior_number" value="{{ old('interior_number', $address?->interior_number) }}" class="input" placeholder="Ej: Depto 2B (Opcional)">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1">Colonia / Fraccionamiento *</label>
                    <input type="text" name="neighborhood" value="{{ old('neighborhood', $address?->neighborhood) }}" required class="input" placeholder="Colonia">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1">Código Postal *</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $address?->postal_code) }}" required class="input" placeholder="C.P. de 5 dígitos">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1">Ciudad / Municipio *</label>
                    <input type="text" name="city" value="{{ old('city', $address?->city) }}" required class="input" placeholder="Ciudad">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1">Estado *</label>
                    <input type="text" name="state" value="{{ old('state', $address?->state) }}" required class="input" placeholder="Estado">
                </div>
            </div>
        </div>

        <!-- Sección 2: Identificación Oficial (INE) -->
        <div>
            <h3 class="font-outfit font-semibold text-lg text-[#263238] mb-4 pb-2 border-b border-[#E5E7EB]">
                <i class='bx bx-id-card text-xl text-[#D4A373] align-middle mr-1'></i> Verificación de Identidad
            </h3>
            <p class="text-sm text-[#607D8B] mb-4">
                Sube una fotografía clara de la parte frontal de tu identificación oficial (INE / Pasaporte) para validar tu cuenta.
            </p>

            <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-[#E5E7EB] rounded-2xl bg-[#F8FAF7]">
                <div class="space-y-1 text-center">
                    <i class='bx bx-upload text-4xl text-[#607D8B] mb-2'></i>
                    <div class="flex text-sm text-[#607D8B]">
                        <label for="ine_photo" class="relative cursor-pointer bg-white rounded-md font-medium text-[#2E7D32] hover:text-[#1B5E20] focus-within:outline-none">
                            <span>Sube un archivo</span>
                            <input id="ine_photo" name="ine_photo" type="file" class="sr-only" required accept="image/*">
                        </label>
                        <p class="pl-1">o arrastra y suelta</p>
                    </div>
                    <p class="text-xs text-[#607D8B]">PNG, JPG, JPEG hasta 5MB</p>
                </div>
            </div>
            
            <div id="file-preview-container" class="mt-4 hidden bg-gray-50 border border-[#E5E7EB] p-4 rounded-xl flex items-center gap-3">
                <i class='bx bx-image-alt text-2xl text-[#2E7D32]'></i>
                <div class="flex-grow">
                    <p id="file-name" class="text-sm font-semibold text-[#263238] truncate"></p>
                    <p id="file-size" class="text-xs text-[#607D8B]"></p>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-[#E5E7EB] flex flex-col sm:flex-row justify-end gap-3">
            <a href="{{ route('dashboard') }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">
                Finalizar Registro y Activar Tienda
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('ine_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('file-name').innerText = file.name;
            document.getElementById('file-size').innerText = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            document.getElementById('file-preview-container').classList.remove('hidden');
        }
    });
</script>
@endsection
