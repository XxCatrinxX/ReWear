@extends('layouts.rewear')
@section('title', 'Mi Billetera - ReWear')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="walletManager({{ json_encode($user->clabe ?? '') }}, {{ json_encode($user->bank_name ?? '') }})">
    
    <!-- Encabezado -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="font-outfit text-3xl font-bold text-[#263238]">Mi Billetera</h1>
            <p class="text-[#607D8B] text-sm mt-1">Gestiona tus ingresos por ventas, saldos pendientes y transferencias bancarias.</p>
        </div>
    </div>

    <!-- Cards de Saldo -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        
        <!-- Saldo Pendiente -->
        <div class="bg-white rounded-3xl p-6 border border-[#E5E7EB] shadow-sm relative overflow-hidden flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-xs font-bold text-[#D4A373] uppercase tracking-wider bg-[#D4A373]/10 px-3 py-1 rounded-full">
                        <i class='bx bx-time-five align-middle mr-1'></i> En Custodia
                    </span>
                    <h3 class="text-[#607D8B] text-sm font-medium mt-4">Saldo Pendiente de Liberación</h3>
                    <p class="font-outfit text-4xl font-extrabold text-[#263238] mt-2">${{ number_format($user->pending_balance, 2) }} <span class="text-xs text-[#607D8B] font-normal">MXN</span></p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-[#D4A373]/10 flex items-center justify-center text-[#D4A373]">
                    <i class='bx bx-hourglass text-3xl'></i>
                </div>
            </div>
            <p class="text-xs text-[#607D8B] mt-6 flex items-center gap-1">
                <i class='bx bx-info-circle text-base text-[#D4A373]'></i> 
                Se libera automáticamente cuando el comprador confirma la recepción de su pedido.
            </p>
        </div>

        <!-- Saldo Disponible -->
        <div class="bg-white rounded-3xl p-6 border-2 border-[#2E7D32] shadow-sm flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-xs font-bold text-[#2E7D32] uppercase tracking-wider bg-[#2E7D32]/10 px-3 py-1 rounded-full">
                        <i class='bx bx-check-circle align-middle mr-1'></i> Disponible
                    </span>
                    <h3 class="text-[#263238] text-sm font-semibold mt-4">Saldo Disponible para Retiro</h3>
                    <p class="font-outfit text-4xl font-extrabold text-[#2E7D32] mt-2">${{ number_format($user->available_balance, 2) }} <span class="text-xs text-[#607D8B] font-normal">MXN</span></p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-[#2E7D32]/10 flex items-center justify-center text-[#2E7D32]">
                    <i class='bx bx-wallet-alt text-3xl'></i>
                </div>
            </div>
            <div class="mt-6 flex justify-between items-center border-t border-[#E5E7EB] pt-4">
                <span class="text-xs text-[#607D8B]">Fondos libres de comisión</span>
                <button type="button" @click="document.getElementById('clabe_input').focus(); document.getElementById('clabe_input').scrollIntoView({behavior: 'smooth'})" class="inline-flex items-center gap-2 bg-[#2E7D32] text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-[#1b4d1f] transition-colors shadow-sm cursor-pointer">
                    <i class='bx bx-export text-base'></i> Transferir a mi banco
                </button>
            </div>
        </div>

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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" id="retirar">
        
        <!-- Formulario de Retiro -->
        <div class="lg:col-span-1 bg-white rounded-3xl p-6 border border-[#E5E7EB] shadow-sm">
            <h2 class="font-outfit text-xl font-bold text-[#263238] mb-1">Transferir a Cuenta Bancaria</h2>
            <p class="text-xs text-[#607D8B] mb-6">Ingresa tu CLABE interbancaria (18 dígitos) para recibir tus fondos inmediatamente.</p>

            <form action="{{ route('seller.wallet.withdraw') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Monto a Retirar -->
                <div>
                    <label class="block text-xs font-bold text-[#263238] uppercase tracking-wider mb-2">Monto a retirar ($ MXN)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold">$</span>
                        <input type="number" step="0.01" min="1" max="{{ $user->available_balance }}" name="amount" value="{{ old('amount', number_format($user->available_balance, 2, '.', '')) }}" required
                            class="w-full pl-8 pr-4 py-3 border border-[#E5E7EB] rounded-2xl focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent text-[#263238] font-bold">
                    </div>
                    <p class="text-[11px] text-[#607D8B] mt-1">Máximo disponible: ${{ number_format($user->available_balance, 2) }}</p>
                </div>

                <!-- CLABE Interbancaria -->
                <div>
                    <label class="block text-xs font-bold text-[#263238] uppercase tracking-wider mb-2">CLABE Interbancaria (18 dígitos)</label>
                    <input type="text" id="clabe_input" name="clabe" x-model="clabe" @input="detectBank()" maxlength="18" placeholder="Ej: 012180015487965412" required
                        class="w-full px-4 py-3 border border-[#E5E7EB] rounded-2xl focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent text-[#263238] font-mono text-sm tracking-widest">
                </div>

                <!-- Nombre del Banco (Auto-detectado) -->
                <div>
                    <label class="block text-xs font-bold text-[#263238] uppercase tracking-wider mb-2">Banco Destino</label>
                    <div class="relative">
                        <input type="text" name="bank_name" x-model="bankName" required
                            class="w-full px-4 py-3 bg-gray-50 border border-[#E5E7EB] rounded-2xl text-[#263238] font-bold text-sm">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-[#2E7D32]" x-text="bankName ? 'Detectado' : ''"></span>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        @if($user->available_balance <= 0) disabled @endif
                        class="w-full btn-primary bg-[#2E7D32] hover:bg-[#1b4d1f] py-3.5 rounded-2xl text-sm font-bold text-white shadow-md flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                        <i class='bx bx-check-shield text-xl'></i> Solicitar Transferencia
                    </button>
                </div>

                <p class="text-[11px] text-[#607D8B] text-center mt-3">
                    <i class='bx bx-lock-alt align-middle'></i> Transacción cifrada vía Sistema de Pagos Electrónicos SPEI.
                </p>

            </form>
        </div>

        <!-- Historial de Retiros -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-[#E5E7EB] shadow-sm flex flex-col justify-between">
            <div>
                <h2 class="font-outfit text-xl font-bold text-[#263238] mb-4 pb-3 border-b border-[#E5E7EB]">Historial de Retiros</h2>

                @if($withdrawals->isEmpty())
                    <div class="py-12 text-center">
                        <i class='bx bx-receipt text-5xl text-gray-300 mb-2'></i>
                        <p class="text-[#607D8B] text-sm">Aún no has realizado retiros a tu cuenta bancaria.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-[#263238]">
                            <thead>
                                <tr class="text-xs uppercase tracking-wider text-[#607D8B] border-b border-[#E5E7EB]">
                                    <th class="pb-3 font-bold">Fecha</th>
                                    <th class="pb-3 font-bold">Banco</th>
                                    <th class="pb-3 font-bold">CLABE</th>
                                    <th class="pb-3 font-bold text-right">Monto</th>
                                    <th class="pb-3 font-bold text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#E5E7EB]">
                                @foreach($withdrawals as $withdrawal)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="py-3.5 font-medium text-xs">{{ $withdrawal->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="py-3.5 font-semibold text-xs text-[#263238]">{{ $withdrawal->bank_name }}</td>
                                        <td class="py-3.5 font-mono text-xs text-[#607D8B]">•••• {{ substr($withdrawal->clabe, -4) }}</td>
                                        <td class="py-3.5 font-bold text-sm text-right text-[#2E7D32]">${{ number_format($withdrawal->amount, 2) }}</td>
                                        <td class="py-3.5 text-center">
                                            <span class="bg-emerald-50 text-[#2E7D32] text-[11px] font-bold px-2.5 py-1 rounded-full uppercase">
                                                {{ ucfirst($withdrawal->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $withdrawals->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>

<script>
function walletManager(initialClabe, initialBank) {
    return {
        clabe: initialClabe || '',
        bankName: initialBank || 'Banco SPEI',
        init() {
            this.detectBank();
        },
        detectBank() {
            const clean = (this.clabe || '').trim();
            const prefix = clean.substring(0, 3);
            const banks = {
                '012': 'BBVA México',
                '014': 'Santander',
                '072': 'Banorte / Ixe',
                '002': 'Citibanamex',
                '021': 'HSBC',
                '044': 'Scotiabank',
                '127': 'Banco Azteca',
                '058': 'Banregio',
                '062': 'Afirme',
                '137': 'BanCoppel'
            };
            if (banks[prefix]) {
                this.bankName = banks[prefix];
            } else if (clean.length > 0) {
                this.bankName = 'Banco Nacional (SPEI)';
            } else {
                this.bankName = 'Banco SPEI';
            }
        }
    }
}
</script>
@endsection
