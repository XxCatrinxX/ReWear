@extends('layouts.rewear')
@section('title', 'Membresía Premium')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="font-outfit text-3xl font-bold text-[#263238]">Membresía Premium</h1>
        <p class="text-[#607D8B] mt-1">Publica sin límites y potencia tus ventas en ReWear.</p>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 flex items-center gap-2">
            <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 flex items-center gap-2">
            <i class='bx bx-error-circle text-xl'></i> {{ session('error') }}
        </div>
    @endif

    <!-- Estado actual -->
    @php $isPremium = $user->hasPremiumMembership(); @endphp
    <div class="mb-8 p-6 rounded-3xl border {{ $isPremium ? 'border-amber-300 bg-amber-50' : 'border-[#E5E7EB] bg-white' }} shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl {{ $isPremium ? 'bg-amber-100' : 'bg-[#F8FAF7]' }} flex items-center justify-center">
                    <i class='bx {{ $isPremium ? "bxs-crown text-amber-500" : "bx-user text-[#607D8B]" }} text-3xl'></i>
                </div>
                <div>
                    <p class="font-semibold text-[#263238] text-lg">
                        {{ $isPremium ? 'Plan Premium activo' : 'Plan Gratuito' }}
                    </p>
                    @if($isPremium && $user->membership_expires_at)
                        <p class="text-sm text-amber-700">
                            Vence el {{ $user->membership_expires_at->format('d/m/Y') }}
                            ({{ $user->membership_expires_at->diffForHumans() }})
                        </p>
                    @else
                        <p class="text-sm text-[#607D8B]">
                            {{ $user->publishedThisMonth() }} / 10 publicaciones este mes
                        </p>
                    @endif
                </div>
            </div>
            @if($isPremium)
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-200 text-amber-800 text-sm font-bold">
                    <i class='bx bxs-crown'></i> PREMIUM
                </span>
            @endif
        </div>
    </div>

    <!-- Comparación de planes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        <!-- Plan Gratuito -->
        <div class="bg-white rounded-3xl border border-[#E5E7EB] p-8 shadow-sm">
            <div class="mb-4">
                <p class="text-sm font-semibold text-[#607D8B] uppercase tracking-wider">Plan Gratuito</p>
                <p class="text-4xl font-bold text-[#263238] mt-1">$0 <span class="text-base font-normal text-[#607D8B]">/ mes</span></p>
            </div>
            <ul class="space-y-3 mb-8">
                <li class="flex items-center gap-3 text-sm text-[#607D8B]">
                    <i class='bx bx-check-circle text-green-500 text-lg'></i>
                    Hasta <strong class="text-[#263238]">10 publicaciones</strong> por mes
                </li>
                <li class="flex items-center gap-3 text-sm text-[#607D8B]">
                    <i class='bx bx-check-circle text-green-500 text-lg'></i>
                    Acceso al catálogo completo
                </li>
                <li class="flex items-center gap-3 text-sm text-[#607D8B]">
                    <i class='bx bx-check-circle text-green-500 text-lg'></i>
                    Chat con compradores
                </li>
                <li class="flex items-center gap-3 text-sm text-[#607D8B]">
                    <i class='bx bx-x-circle text-red-300 text-lg'></i>
                    Publicaciones ilimitadas
                </li>
                <li class="flex items-center gap-3 text-sm text-[#607D8B]">
                    <i class='bx bx-x-circle text-red-300 text-lg'></i>
                    Distintivo Premium
                </li>
            </ul>
            <div class="h-12 flex items-center justify-center text-sm text-[#607D8B] font-medium">
                {{ !$isPremium ? 'Plan actual' : '' }}
            </div>
        </div>

        <!-- Plan Premium -->
        <div class="relative bg-gradient-to-br from-[#2E7D32] to-[#1B5E20] rounded-3xl p-8 shadow-lg text-white overflow-hidden">
            <!-- Brillo decorativo -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-12 translate-x-12"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-10 -translate-x-8"></div>

            <div class="relative mb-4">
                <div class="flex items-center gap-2 mb-2">
                    <i class='bx bxs-crown text-amber-400 text-xl'></i>
                    <p class="text-sm font-semibold text-green-200 uppercase tracking-wider">Plan Premium</p>
                </div>
                <p class="text-4xl font-bold">$150 <span class="text-base font-normal text-green-200">MXN / mes</span></p>
            </div>
            <ul class="space-y-3 mb-8 relative">
                <li class="flex items-center gap-3 text-sm text-green-100">
                    <i class='bx bx-check-circle text-green-300 text-lg'></i>
                    <strong class="text-white">Publicaciones ilimitadas</strong>
                </li>
                <li class="flex items-center gap-3 text-sm text-green-100">
                    <i class='bx bx-check-circle text-green-300 text-lg'></i>
                    Acceso al catálogo completo
                </li>
                <li class="flex items-center gap-3 text-sm text-green-100">
                    <i class='bx bx-check-circle text-green-300 text-lg'></i>
                    Chat con compradores
                </li>
                <li class="flex items-center gap-3 text-sm text-green-100">
                    <i class='bx bx-check-circle text-green-300 text-lg'></i>
                    <strong class="text-white">Distintivo Premium <i class='bx bxs-crown text-amber-400'></i></strong>
                </li>
                <li class="flex items-center gap-3 text-sm text-green-100">
                    <i class='bx bx-check-circle text-green-300 text-lg'></i>
                    Soporte prioritario
                </li>
            </ul>

            <div class="relative">
                @if($isPremium)
                    <form method="POST" action="{{ route('seller.membership.cancel') }}">
                        @csrf
                        <button type="submit"
                            onclick="return confirm('¿Cancelar tu membresía Premium? Volverás al plan gratuito al terminar el periodo.')"
                            class="w-full py-3 px-6 rounded-2xl bg-white/20 hover:bg-white/30 text-white font-bold transition border border-white/30 cursor-pointer">
                            Cancelar membresía
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('seller.membership.activate') }}" x-data="{ useSavedCard: {{ count($paymentMethods) > 0 ? 'true' : 'false' }} }">
                        @csrf
                        
                        @if(count($paymentMethods) > 0)
                            <div class="mb-4 bg-white/10 p-3 rounded-xl">
                                <label class="block text-xs font-semibold text-green-100 mb-2">Método de pago guardado</label>
                                <select name="saved_payment_method_id" x-model="useSavedCard" class="w-full bg-white/20 border border-white/30 rounded-lg px-3 py-2 text-xs text-white">
                                    @foreach($paymentMethods as $pm)
                                        <option value="{{ $pm->id }}" class="text-[#263238]">
                                            {{ $pm->card_brand }} •••• {{ $pm->last_four }} ({{ $pm->bank_name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="flex items-center gap-2 text-xs text-green-100 cursor-pointer">
                                <input type="checkbox" name="save_card" value="1" checked class="rounded text-[#2E7D32] focus:ring-[#2E7D32]">
                                <span>Guardar método de pago para renovación automática</span>
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full py-3.5 px-6 rounded-2xl bg-amber-400 hover:bg-amber-500 text-[#1B3A1E] font-bold transition shadow-lg shadow-amber-400/30 flex items-center justify-center gap-2 cursor-pointer">
                            <i class='bx bxs-crown text-xl'></i> Activar Premium — $150 MXN/mes
                        </button>
                    </form>
                    <p class="text-xs text-green-300 text-center mt-2">Sin compromiso. Cancela en cualquier momento.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Garantía de Pago -->
    <div class="p-4 bg-white border border-[#E5E7EB] rounded-2xl text-sm text-[#607D8B] flex items-center gap-3 shadow-sm">
        <i class='bx bx-check-shield text-2xl text-[#2E7D32] flex-shrink-0'></i>
        <p>
            <strong>Pago Seguro Garantizado:</strong> Procesado mediante encriptación bancaria de 256 bits. Recibirás tu recibo fiscal inmediatamente al activar.
        </p>
    </div>
</div>
@endsection
