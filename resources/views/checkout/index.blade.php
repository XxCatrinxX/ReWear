@extends('layouts.rewear')
@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{
    showNewAddressForm: {{ $addresses->count() == 0 ? 'true' : 'false' }},
    selectedAddress: '{{ $addresses->where('is_default', true)->first()?->id ?? ($addresses->first()?->id ?? '') }}',
    cardType: 'credito',
    cardNumber: '',
    detectedBank: 'Desconocido',
    detectedBrand: 'Desconocido',
    cardholderName: '',
    expiryDate: '',
    cvv: '',
    
    // JS bank detector
    detectCardInfo() {
        const cleaned = this.cardNumber.replace(/\s+/g, '');
        if (cleaned.startsWith('4152')) {
            this.detectedBank = 'BBVA';
            this.detectedBrand = 'Visa';
        } else if (cleaned.startsWith('4556')) {
            this.detectedBank = 'Citibanamex';
            this.detectedBrand = 'Visa';
        } else if (cleaned.startsWith('4913')) {
            this.detectedBank = 'Banorte';
            this.detectedBrand = 'Visa';
        } else if (cleaned.startsWith('5204')) {
            this.detectedBank = 'Santander';
            this.detectedBrand = 'Mastercard';
        } else if (cleaned.startsWith('5256')) {
            this.detectedBank = 'HSBC';
            this.detectedBrand = 'Mastercard';
        } else if (cleaned.startsWith('4')) {
            this.detectedBank = 'Banco de México (Genérico)';
            this.detectedBrand = 'Visa';
        } else if (cleaned.startsWith('5')) {
            this.detectedBank = 'Banco de México (Genérico)';
            this.detectedBrand = 'Mastercard';
        } else if (cleaned.startsWith('34') || cleaned.startsWith('37')) {
            this.detectedBank = 'American Express Bank';
            this.detectedBrand = 'Amex';
        } else {
            this.detectedBank = 'Desconocido';
            this.detectedBrand = 'Desconocido';
        }
    }
}">
    
    <div class="mb-8">
        <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Finalizar compra</h1>
        <p class="text-[#607D8B]">Completa tus datos de envío y pago seguro para terminar tu pedido.</p>
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

    <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST" class="flex flex-col lg:flex-row gap-8">
        @csrf
        
        <!-- Enviar información del banco y tarjeta detectados -->
        <input type="hidden" name="card_type" x-model="cardType">
        <input type="hidden" name="bank_name" x-model="detectedBank">
        <input type="hidden" name="card_brand" x-model="detectedBrand">

        <!-- Datos de envío y pago -->
        <div class="w-full lg:w-2/3 space-y-6">
            
            <!-- 1. Dirección de Envío -->
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-full bg-[#2E7D32] text-white flex items-center justify-center font-bold">1</div>
                    <h2 class="font-outfit font-semibold text-[#263238] text-xl">Dirección de envío</h2>
                </div>

                <!-- Selección de Dirección Existente -->
                                @if($addresses->count() > 0)
                    <div x-show="!showNewAddressForm" class="space-y-4">

                        @error('address_id')
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                                <i class='bx bx-error-circle text-lg'></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($addresses as $address)
                                <label class="relative flex cursor-pointer rounded-2xl border bg-white p-4 focus:outline-none transition-colors"
                                       :class="selectedAddress == '{{ $address->id }}' ? 'border-[#2E7D32] bg-[#F8FAF7]' : 'border-[#E5E7EB] hover:bg-gray-50'">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" class="sr-only" x-model="selectedAddress" @click="showNewAddressForm = false">
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span class="block text-sm font-semibold text-[#263238] mb-1">
                                                {{ $address->label }} 
                                                @if($address->is_default)
                                                    <span class="ml-2 text-[10px] bg-[#2E7D32]/10 text-[#2E7D32] px-2 py-0.5 rounded-full uppercase font-bold">Predeterminada</span>
                                                @endif
                                            </span>
                                            <span class="text-xs text-[#607D8B] mb-2">Recibe: {{ $address->recipient_name }}</span>
                                            <span class="text-xs text-[#607D8B] leading-relaxed">
                                                {{ $address->street }} {{ $address->exterior_number }} 
                                                @if($address->interior_number) Int {{ $address->interior_number }} @endif<br>
                                                Col. {{ $address->neighborhood }}<br>
                                                {{ $address->city }}, {{ $address->state }} C.P. {{ $address->postal_code }}
                                            </span>
                                        </span>
                                    </span>
                                    <i class='bx bxs-check-circle text-2xl text-[#2E7D32] absolute top-4 right-4' x-show="selectedAddress == '{{ $address->id }}'"></i>
                                </label>
                            @endforeach
                        </div>
                        <button type="button" @click="showNewAddressForm = true; selectedAddress = ''" class="text-sm font-medium text-[#2E7D32] hover:underline flex items-center gap-1">
                            <i class='bx bx-plus-circle'></i> Registrar otra dirección
                        </button>
                    </div>
                @endif

                <!-- Formulario de Nueva Dirección (Obligatorio si count == 0 o si se selecciona agregar) -->
                <div x-show="showNewAddressForm" class="space-y-4 border border-dashed border-[#E5E7EB] p-5 rounded-2xl bg-[#F8FAF7]">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-semibold text-sm text-[#263238] uppercase tracking-wider">Nueva dirección de entrega</h3>
                        @if($addresses->count() > 0)
                            <button type="button" @click="showNewAddressForm = false; selectedAddress = {{ $addresses->first()->id }}" class="text-xs text-red-500 hover:underline">
                                Usar dirección guardada
                            </button>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-[#263238] mb-1">Identificador de Dirección *</label>
                            <input type="text" name="label" :required="showNewAddressForm" class="input bg-white" placeholder="Ej: Mi Casa, Oficina" value="{{ old('label', 'Casa') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#263238] mb-1">Nombre de quien recibe *</label>
                            <input type="text" name="recipient_name" :required="showNewAddressForm" class="input bg-white" placeholder="Nombre completo" value="{{ old('recipient_name', auth()->user()->name) }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#263238] mb-1">Teléfono *</label>
                            <input type="text" name="phone" :required="showNewAddressForm" class="input bg-white" placeholder="10 dígitos" value="{{ old('phone') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#263238] mb-1">Calle *</label>
                            <input type="text" name="street" :required="showNewAddressForm" class="input bg-white" placeholder="Calle principal" value="{{ old('street') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#263238] mb-1">Número Exterior *</label>
                            <input type="text" name="exterior_number" :required="showNewAddressForm" class="input bg-white" placeholder="Número Ext." value="{{ old('exterior_number') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#263238] mb-1">Número Interior</label>
                            <input type="text" name="interior_number" class="input bg-white" placeholder="Ej: Depto 401 (Opcional)" value="{{ old('interior_number') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#263238] mb-1">Colonia / Vecindario *</label>
                            <input type="text" name="neighborhood" :required="showNewAddressForm" class="input bg-white" placeholder="Colonia" value="{{ old('neighborhood') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#263238] mb-1">Código Postal *</label>
                            <input type="text" name="postal_code" :required="showNewAddressForm" class="input bg-white" placeholder="5 dígitos" value="{{ old('postal_code') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#263238] mb-1">Ciudad / Delegación *</label>
                            <input type="text" name="city" :required="showNewAddressForm" class="input bg-white" placeholder="Ciudad" value="{{ old('city') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#263238] mb-1">Estado *</label>
                            <input type="text" name="state" :required="showNewAddressForm" class="input bg-white" placeholder="Estado" value="{{ old('state') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Método de Pago (Con detección automática de banco) -->
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-full bg-[#2E7D32] text-white flex items-center justify-center font-bold">2</div>
                    <h2 class="font-outfit font-semibold text-[#263238] text-xl">Método de pago seguro</h2>
                </div>

                @if(isset($paymentMethods) && $paymentMethods->count() > 0)
                    <div class="mb-6 p-4 bg-[#F8FAF7] rounded-2xl border border-[#E5E7EB]">
                        <h3 class="text-xs font-bold text-[#263238] uppercase tracking-wider mb-3">Tus Tarjetas Guardadas</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($paymentMethods as $pm)
                                <button type="button" 
                                    @click="cardNumber = '•••• •••• •••• {{ $pm->last_four }}'; cardholderName = '{{ $pm->cardholder_name }}'; expiryDate = '{{ $pm->expiration }}'; cardType = '{{ $pm->card_type }}'; detectedBank = '{{ $pm->bank_name }}'; detectedBrand = '{{ $pm->card_brand }}';"
                                    class="p-3 bg-white border border-[#E5E7EB] rounded-xl hover:border-[#2E7D32] text-left transition flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-[#2E7D32]/10 text-[#2E7D32] flex items-center justify-center font-bold text-lg">
                                        <i class='bx bx-credit-card'></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-[#263238]">{{ $pm->card_brand }} •••• {{ $pm->last_four }}</p>
                                        <p class="text-[11px] text-[#607D8B]">{{ $pm->bank_name }} · {{ $pm->cardholder_name }}</p>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Tarjeta de Crédito/Débito Form -->
                <div class="space-y-6">
                    <!-- Selección de Tipo de Tarjeta -->
                    <div class="flex gap-4">
                        <label class="flex-1 border p-4 rounded-2xl flex items-center gap-3 cursor-pointer transition-colors"
                            :class="cardType === 'credito' ? 'border-[#2E7D32] bg-[#F8FAF7]' : 'border-[#E5E7EB]'">
                            <input type="radio" name="card_type_select" value="credito" x-model="cardType" class="text-[#2E7D32] focus:ring-[#2E7D32]">
                            <div>
                                <span class="block font-semibold text-sm text-[#263238]">Tarjeta de Crédito</span>
                                <span class="text-xs text-[#607D8B]">Crédito directo o meses</span>
                            </div>
                        </label>
                        
                        <label class="flex-1 border p-4 rounded-2xl flex items-center gap-3 cursor-pointer transition-colors"
                            :class="cardType === 'debito' ? 'border-[#2E7D32] bg-[#F8FAF7]' : 'border-[#E5E7EB]'">
                            <input type="radio" name="card_type_select" value="debito" x-model="cardType" class="text-[#2E7D32] focus:ring-[#2E7D32]">
                            <div>
                                <span class="block font-semibold text-sm text-[#263238]">Tarjeta de Débito</span>
                                <span class="text-xs text-[#607D8B]">Fondos directos de cuenta</span>
                            </div>
                        </label>
                    </div>

                    <!-- Datos Numéricos de Tarjeta -->
                    <div class="bg-gradient-to-br from-[#263238] to-[#37474F] p-6 rounded-3xl text-white shadow-soft space-y-6 relative overflow-hidden">
                        <!-- Chip -->
                        <div class="flex justify-between items-start">
                            <div class="w-12 h-9 bg-yellow-400/80 rounded-lg"></div>
                            
                            <!-- Badges de detección -->
                            <div class="text-right flex flex-col gap-1 items-end">
                                <span class="bg-white/10 text-white text-[10px] uppercase font-bold px-2 py-0.5 rounded-full tracking-wider">
                                    Pago Encriptado SSL
                                </span>
                                <div class="flex gap-2 items-center mt-1">
                                    <!-- Marca Detectada -->
                                    <span class="text-xs font-bold px-2 py-1 rounded bg-[#2E7D32]/20 border border-[#2E7D32] text-green-200" x-show="detectedBrand !== 'Desconocido'" x-text="detectedBrand"></span>
                                    <!-- Banco Detectado -->
                                    <span class="text-xs font-bold px-2 py-1 rounded bg-[#D4A373]/20 border border-[#D4A373] text-[#ffe8d6]" x-show="detectedBank !== 'Desconocido'" x-text="detectedBank"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Number Input -->
                        <div>
                            <label class="block text-[10px] uppercase tracking-wider text-gray-400 mb-1">Número de Tarjeta</label>
                            <input type="text" name="card_number" required x-model="cardNumber" @input="detectCardInfo()"
                                   maxlength="19" class="w-full bg-white/10 border-white/20 rounded-xl px-4 py-2.5 text-lg font-mono text-white placeholder-white/30 focus:border-white focus:ring-0" 
                                   placeholder="4152 0000 0000 0000">
                            <p class="text-[10px] text-gray-400 mt-1">Detección automática de banco e institución emisora</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] uppercase tracking-wider text-gray-400 mb-1">Nombre en Tarjeta</label>
                                <input type="text" name="card_holder" required x-model="cardholderName"
                                       class="w-full bg-white/10 border-white/20 rounded-xl px-4 py-2.5 text-sm text-white placeholder-white/30 focus:border-white focus:ring-0" 
                                       placeholder="JUAN PEREZ">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] uppercase tracking-wider text-gray-400 mb-1">Expiración</label>
                                    <input type="text" name="card_expiry" required x-model="expiryDate" placeholder="MM/AA" maxlength="5"
                                           class="w-full bg-white/10 border-white/20 rounded-xl px-2 py-2.5 text-sm text-center text-white placeholder-white/30 focus:border-white focus:ring-0">
                                </div>
                                <div>
                                    <label class="block text-[10px] uppercase tracking-wider text-gray-400 mb-1">CVV</label>
                                    <input type="password" name="card_cvv" required x-model="cvv" placeholder="•••" maxlength="4"
                                           class="w-full bg-white/10 border-white/20 rounded-xl px-2 py-2.5 text-sm text-center text-white placeholder-white/30 focus:border-white focus:ring-0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Casilla opcional de Guardado -->
                    <div class="pt-2">
                        <label class="flex items-center gap-3 cursor-pointer text-sm text-[#263238]">
                            <input type="checkbox" name="save_card" value="1" class="rounded text-[#2E7D32] focus:ring-[#2E7D32] w-4 h-4">
                            <span class="font-medium">Guardar esta tarjeta para futuras compras</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Notas del pedido -->
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-4">
                    <h2 class="font-outfit font-semibold text-[#263238] text-lg">Notas para los vendedores (Opcional)</h2>
                </div>
                <textarea name="notes" rows="3" placeholder="Instrucciones especiales para la entrega, etc." 
                    class="w-full bg-[#F8FAF7] border-[#E5E7EB] rounded-xl focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20 text-sm">{{ old('notes') }}</textarea>
            </div>

        </div>
        
        <!-- Resumen del pedido -->
        <div class="w-full lg:w-1/3">
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden sticky top-24">
                <div class="p-6">
                    <h2 class="font-outfit font-semibold text-[#263238] text-xl mb-6">Resumen del pedido</h2>
                    
                    <ul class="divide-y divide-[#E5E7EB] mb-6 max-h-64 overflow-y-auto custom-scrollbar pr-2">
                        @foreach($cart->items as $item)
                            <li class="py-3 flex gap-3">
                                <img src="{{ $item->product->cover_url }}" class="w-12 h-12 rounded-lg object-cover bg-gray-100 flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-[#263238] truncate">{{ $item->product->title }}</p>
                                    <p class="text-xs text-[#607D8B]">Cant: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-sm font-medium text-[#263238]">
                                    {{ $item->formatted_subtotal }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm text-[#607D8B]">
                            <span>Subtotal</span>
                            <span>{{ $cart->formatted_total }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-[#607D8B]">
                            <span>Envío</span>
                            <span class="text-[#2E7D32] font-medium">Gratis</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-[#E5E7EB] pt-4 mb-6">
                        <div class="flex justify-between items-end">
                            <span class="font-medium text-[#263238]">Total a pagar</span>
                            <span class="font-outfit font-bold text-3xl text-[#2E7D32]">{{ $cart->formatted_total }}</span>
                        </div>
                    </div>
                    
                    <button type="submit" 
                            class="w-full text-white font-semibold py-3.5 rounded-xl shadow-soft transition-colors flex items-center justify-center gap-2 bg-[#2E7D32] hover:bg-[#1B5E20]">
                        <i class='bx bx-check-shield text-xl'></i>
                        Confirmar y pagar
                    </button>
                    
                    <p class="text-xs text-[#607D8B] text-center mt-4">
                        Al confirmar, aceptas nuestros términos y condiciones de compra segura.
                    </p>
                </div>
            </div>
        </div>
        
    </form>
</div>
@endsection
