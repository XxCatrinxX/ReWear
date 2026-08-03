@extends('layouts.rewear')
@section('title', 'Detalle de Venta ' . $order->order_number)

@section('content')

{{-- Cálculo de comisión: 5% sobre el precio de venta --}}
@php
    $grossSale   = $order->items->sum('subtotal');
    $commission  = round($grossSale * 0.05, 2);
    $shipping    = 50.00;
    $netEarnings = round($grossSale - $commission + $shipping, 2);
    $trackingNumber = $order->shipment->tracking_number ?? '—';
    $labelRouteUrl  = route('seller.orders.label', $order);
@endphp

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
     x-data="{
         labelPrinted: localStorage.getItem('label_printed_{{ $order->id }}') === 'true',
         markLabelPrinted() {
             localStorage.setItem('label_printed_{{ $order->id }}', 'true');
             this.labelPrinted = true;
             window.open('{{ $labelRouteUrl }}', '_blank');
         }
     }">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="font-outfit text-3xl font-bold text-[#263238]">Venta #{{ $order->order_number }}</h1>
                @if($order->status === 'pagado')
                    <span class="bg-[#2E7D32]/10 text-[#2E7D32] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Listo para enviar</span>
                @elseif($order->status === 'enviado')
                    <span class="bg-[#D4A373]/10 text-[#D4A373] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">En camino</span>
                @elseif($order->status === 'entregado')
                    <span class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Entregado</span>
                @endif
            </div>
            <p class="text-sm text-[#607D8B] mt-1">Realizado el {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="flex gap-2 flex-wrap items-center">
            <a href="{{ route('seller.orders.index') }}" class="btn-secondary">Volver</a>

            @if($order->status === 'pagado')
                {{-- Botón imprimir (siempre habilitado, pero registra el click) --}}
                <button
                    type="button"
                    @click="markLabelPrinted()"
                    class="btn-secondary bg-[#D4A373]/10 text-[#D4A373] border-[#D4A373]/20 hover:bg-[#D4A373]/20 font-bold flex items-center gap-2"
                >
                    <i class='bx bx-printer'></i> 1. Imprimir Etiqueta QR
                </button>

                {{-- Botón enviar: deshabilitado hasta imprimir etiqueta --}}
                <form action="{{ route('seller.orders.ship', $order) }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        :disabled="!labelPrinted"
                        :class="labelPrinted
                            ? 'btn-primary font-bold cursor-pointer'
                            : 'btn-primary font-bold opacity-40 cursor-not-allowed pointer-events-none'"
                        :title="labelPrinted ? '' : 'Debes imprimir la etiqueta QR primero'"
                    >
                        <i class='bx bx-send'></i> 2. Marcar como Enviado
                    </button>
                </form>

            @elseif($order->status === 'enviado' || $order->status === 'entregado')
                <a href="{{ $labelRouteUrl }}" target="_blank" class="btn-secondary bg-[#D4A373]/10 text-[#D4A373] border-[#D4A373]/20 hover:bg-[#D4A373]/20">
                    <i class='bx bx-printer'></i> Reimprimir Etiqueta QR
                </a>
            @endif
        </div>
    </div>

    {{-- Aviso: etiqueta pendiente --}}
    @if($order->status === 'pagado')
    <div x-show="!labelPrinted" x-cloak
         class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 flex items-center gap-3 text-amber-800 text-sm">
        <i class='bx bx-info-circle text-2xl text-amber-500 flex-shrink-0'></i>
        <span>Para poder marcar el pedido como enviado, primero debes <strong>imprimir la etiqueta QR</strong> y pegarla en el paquete.</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- ══ Columna principal ══ -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Prendas vendidas -->
            <div class="bg-white rounded-3xl border border-[#E5E7EB] p-6 shadow-sm">
                <h3 class="font-outfit font-semibold text-lg text-[#263238] mb-4 pb-2 border-b border-[#E5E7EB]">
                    Prendas de tu propiedad vendidas
                </h3>
                <ul class="divide-y divide-[#E5E7EB]">
                    @foreach($order->items as $item)
                        <li class="py-4 flex gap-4">
                            <img src="{{ $item->product->cover_url }}" class="w-16 h-20 rounded-xl object-cover bg-gray-50 flex-shrink-0 border border-[#E5E7EB]">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-sm text-[#263238] truncate">{{ $item->product_title }}</h4>
                                <p class="text-xs text-[#607D8B] mt-1">Talla: {{ $item->product->size ?? 'N/A' }} | Color: {{ $item->product->color ?? 'N/A' }}</p>
                                <p class="text-xs text-[#607D8B]">Cant: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="font-semibold text-[#263238]">${{ number_format($item->subtotal, 2) }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <!-- Desglose de ganancias -->
                <div class="border-t border-[#E5E7EB] pt-4 mt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-[#607D8B]">Venta bruta</span>
                        <span class="font-medium text-[#263238]">${{ number_format($grossSale, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-[#607D8B] flex items-center gap-1">
                            <i class='bx bx-minus-circle text-red-400'></i>
                            Comisión ReWear (5%)
                        </span>
                        <span class="text-red-500 font-medium">-${{ number_format($commission, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-[#607D8B] flex items-center gap-1">
                            <i class='bx bx-plus-circle text-[#2E7D32]'></i>
                            Cobro de envío
                        </span>
                        <span class="text-[#2E7D32] font-medium">+${{ number_format($shipping, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-dashed border-[#E5E7EB]">
                        <span class="font-semibold text-sm text-[#263238]">Total a recibir</span>
                        <span class="font-outfit font-bold text-2xl text-[#2E7D32]">${{ number_format($netEarnings, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Estado del envío -->
            @if($order->status === 'enviado')
                <div class="bg-yellow-50 border border-yellow-100 rounded-3xl p-6 text-yellow-800 flex gap-4">
                    <i class='bx bx-time-five text-3xl text-yellow-600 flex-shrink-0'></i>
                    <div>
                        <p class="font-bold mb-1">Esperando confirmación del comprador</p>
                        <p class="text-sm">
                            Ya marcaste este pedido como enviado. Cuando el comprador reciba su paquete, debe escanear el código QR para liberar tu dinero.
                        </p>
                    </div>
                </div>
            @endif

            <!-- ───────────────── CHAT ───────────────── -->
            <div class="bg-white rounded-3xl border border-[#E5E7EB] shadow-sm overflow-hidden" id="chat-card">
                <div class="p-5 border-b border-[#E5E7EB] bg-gradient-to-r from-[#F8FAF7] to-white flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#2E7D32]/10 flex items-center justify-center text-[#2E7D32] text-xl">
                        <i class='bx bx-message-rounded-dots'></i>
                    </div>
                    <div>
                        <h2 class="font-outfit font-semibold text-[#263238] text-lg leading-tight">Chat con el comprador</h2>
                        <p class="text-xs text-[#607D8B]">{{ $order->buyer->name }} · Pedido #{{ $order->order_number }}</p>
                    </div>
                    <span id="chat-unread-badge" class="ml-auto hidden bg-[#2E7D32] text-white text-xs font-bold px-2 py-0.5 rounded-full"></span>
                </div>

                <div id="chat-messages" class="h-80 overflow-y-auto p-5 space-y-3 bg-[#FAFAFA]">
                    <div id="chat-empty" class="flex flex-col items-center justify-center h-full text-center text-[#B0BEC5]">
                        <i class='bx bx-chat text-5xl mb-3'></i>
                        <p class="text-sm font-medium">Aún no hay mensajes</p>
                        <p class="text-xs mt-1">El comprador puede enviarte dudas sobre el pedido aquí.</p>
                    </div>
                </div>

                <div class="p-4 border-t border-[#E5E7EB] bg-white">
                    <form id="chat-form" class="flex items-center gap-3">
                        @csrf
                        <input
                            id="chat-input"
                            type="text"
                            placeholder="Responde al comprador..."
                            maxlength="1000"
                            autocomplete="off"
                            class="flex-1 rounded-2xl border border-[#E5E7EB] bg-[#F8FAF7] px-4 py-2.5 text-sm text-[#263238] placeholder-[#B0BEC5] focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/30 focus:border-[#2E7D32] transition"
                        />
                        <button
                            type="submit"
                            id="chat-send-btn"
                            class="flex-shrink-0 w-10 h-10 bg-[#2E7D32] hover:bg-[#1B5E20] text-white rounded-full flex items-center justify-center text-xl transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <i class='bx bx-send'></i>
                        </button>
                    </form>
                </div>
            </div>
            <!-- ───────────────── FIN CHAT ───────────────── -->
        </div>

        <!-- ══ Sidebar ══ -->
        <div class="space-y-6">

            <!-- Datos del Comprador -->
            <div class="bg-white rounded-3xl border border-[#E5E7EB] p-6 shadow-sm">
                <h3 class="font-outfit font-semibold text-md text-[#263238] mb-4 pb-2 border-b border-[#E5E7EB]">
                    Datos del Comprador
                </h3>
                <div class="space-y-2 text-sm text-[#607D8B]">
                    <p class="font-semibold text-[#263238]">{{ $order->buyer->name }}</p>
                    <p><i class='bx bx-envelope align-middle mr-1'></i> {{ $order->buyer->email }}</p>
                    <p><i class='bx bx-phone align-middle mr-1'></i> {{ $order->address->phone ?? 'Sin teléfono' }}</p>
                </div>
            </div>

            <!-- Dirección de Envío -->
            <div class="bg-white rounded-3xl border border-[#E5E7EB] p-6 shadow-sm">
                <h3 class="font-outfit font-semibold text-md text-[#263238] mb-4 pb-2 border-b border-[#E5E7EB]">
                    Dirección de Envío
                </h3>
                <div class="text-xs text-[#607D8B] leading-relaxed">
                    <p class="font-semibold text-sm text-[#263238] mb-2">{{ $order->address->recipient_name }}</p>
                    <p>{{ $order->address->street }} {{ $order->address->exterior_number }}
                       @if($order->address->interior_number) Int {{ $order->address->interior_number }} @endif</p>
                    <p>Col. {{ $order->address->neighborhood }}</p>
                    <p>{{ $order->address->city }}, {{ $order->address->state }}</p>
                    <p class="font-bold mt-1">C.P. {{ $order->address->postal_code }}</p>
                </div>
            </div>

            <!-- Detalles del Envío -->
            <div class="bg-white rounded-3xl border border-[#E5E7EB] p-6 shadow-sm">
                <h3 class="font-outfit font-semibold text-md text-[#263238] mb-4 pb-2 border-b border-[#E5E7EB]">
                    Detalles del Envío
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-[#607D8B]">Transportista:</span>
                        <span class="font-semibold text-[#263238]">{{ $order->shipment->carrier ?? 'ReWear Delivery' }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-[#607D8B]">Código de rastreo:</span>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="font-mono font-bold text-sm text-[#263238] bg-[#F8FAF7] border border-[#E5E7EB] px-3 py-1.5 rounded-lg tracking-widest select-all">
                                {{ $trackingNumber }}
                            </span>
                            <button type="button"
                                onclick="navigator.clipboard.writeText('{{ $trackingNumber }}').then(() => { this.innerHTML = '<i class=\'bx bx-check\'></i>'; setTimeout(() => this.innerHTML = '<i class=\'bx bx-copy\'></i>', 1500) })"
                                class="text-[#607D8B] hover:text-[#2E7D32] transition-colors"
                                title="Copiar código">
                                <i class='bx bx-copy'></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#607D8B]">Estado:</span>
                        <span class="font-semibold text-[#2E7D32]">
                            @php
                                $shipStatuses = [
                                    'preparando'   => 'Preparando',
                                    'en_transito'  => 'En tránsito',
                                    'entregado'    => 'Entregado',
                                ];
                            @endphp
                            {{ $shipStatuses[$order->shipment->status ?? 'preparando'] ?? ucfirst($order->shipment->status ?? 'Preparando') }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@push('scripts')
<script>
(function() {
    const MESSAGES_URL = '{{ route('seller.orders.messages.index', $order) }}';
    const STORE_URL    = '{{ route('seller.orders.messages.store', $order) }}';
    const CSRF_TOKEN   = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';

    const container  = document.getElementById('chat-messages');
    const emptyState = document.getElementById('chat-empty');
    const form       = document.getElementById('chat-form');
    const input      = document.getElementById('chat-input');
    const sendBtn    = document.getElementById('chat-send-btn');
    const badge      = document.getElementById('chat-unread-badge');

    let isPolling = false;

    function createBubble(msg) {
        const wrapper = document.createElement('div');
        wrapper.className = `flex ${msg.is_mine ? 'justify-end' : 'justify-start'} gap-2`;
        wrapper.dataset.msgId = msg.id;

        const bubble = document.createElement('div');
        bubble.className = msg.is_mine
            ? 'max-w-[75%] bg-[#2E7D32] text-white rounded-2xl rounded-br-sm px-4 py-2.5 shadow-sm'
            : 'max-w-[75%] bg-white text-[#263238] rounded-2xl rounded-bl-sm px-4 py-2.5 shadow-sm border border-[#E5E7EB]';

        if (!msg.is_mine) {
            const name = document.createElement('p');
            name.className = 'text-[10px] font-bold text-[#2E7D32] mb-0.5 uppercase tracking-wide';
            name.textContent = msg.sender_name;
            bubble.appendChild(name);
        }

        const text = document.createElement('p');
        text.className = 'text-sm leading-relaxed break-words';
        text.textContent = msg.message;
        bubble.appendChild(text);

        const time = document.createElement('p');
        time.className = msg.is_mine
            ? 'text-[10px] text-white/60 mt-1 text-right'
            : 'text-[10px] text-[#B0BEC5] mt-1 text-right';
        time.textContent = `${msg.date} · ${msg.time}`;
        bubble.appendChild(time);

        wrapper.appendChild(bubble);
        return wrapper;
    }

    function scrollToBottom(smooth = false) {
        container.scrollTo({ top: container.scrollHeight, behavior: smooth ? 'smooth' : 'auto' });
    }

    async function fetchMessages() {
        if (isPolling) return;
        isPolling = true;
        try {
            const res = await fetch(MESSAGES_URL, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            });
            if (!res.ok) return;
            const data = await res.json();

            const existingIds = new Set([...container.querySelectorAll('[data-msg-id]')].map(el => Number(el.dataset.msgId)));
            const newMessages = data.messages.filter(m => !existingIds.has(m.id));

            if (newMessages.length > 0) {
                if (emptyState && emptyState.parentNode === container) emptyState.remove();
                const atBottom = container.scrollHeight - container.scrollTop <= container.clientHeight + 60;
                newMessages.forEach(msg => container.appendChild(createBubble(msg)));
                if (atBottom) scrollToBottom(true);
            }

            if (data.unread_count > 0) {
                badge.textContent = data.unread_count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        } catch (e) {
            console.error('Chat polling error:', e);
        } finally {
            isPolling = false;
        }
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const text = input.value.trim();
        if (!text) return;

        sendBtn.disabled = true;
        input.disabled = true;

        try {
            const res = await fetch(STORE_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ message: text })
            });

            if (res.status === 201) {
                const msg = await res.json();
                if (emptyState && emptyState.parentNode === container) emptyState.remove();
                container.appendChild(createBubble(msg));
                scrollToBottom(true);
                input.value = '';
            }
        } catch (e) {
            console.error('Error sending message:', e);
        } finally {
            sendBtn.disabled = false;
            input.disabled = false;
            input.focus();
        }
    });

    fetchMessages();
    setInterval(fetchMessages, 4000);
})();
</script>
@endpush
@endsection
