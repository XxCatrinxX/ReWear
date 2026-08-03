@extends('layouts.rewear')
@section('title', 'Detalle de Pedido ' . $order->order_number)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Breadcrumbs -->
    <nav class="flex text-sm text-[#607D8B] mb-8">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('home') }}" class="hover:text-[#2E7D32]">Inicio</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a href="{{ route('orders.index') }}" class="hover:text-[#2E7D32]">Mis Compras</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li class="text-[#263238] font-medium">Pedido {{ $order->order_number }}</li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Detalles Principales -->
        <div class="w-full lg:w-2/3 space-y-8">
            
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-1">Pedido #{{ $order->order_number }}</h1>
                    <p class="text-[#607D8B]">Realizado el {{ $order->created_at->isoFormat('D [de] MMMM YYYY [a las] H:mm') }}</p>
                </div>
                
                @php
                    $statusColor = match($order->status) {
                        'pendiente' => 'bg-yellow-100 text-yellow-800',
                        'pagado' => 'bg-blue-100 text-blue-800',
                        'enviado' => 'bg-indigo-100 text-indigo-800',
                        'entregado' => 'bg-green-100 text-green-800',
                        'cancelado' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-100 text-gray-800',
                    };
                @endphp
                <div class="px-4 py-2 rounded-full font-bold uppercase tracking-wider text-sm {{ $statusColor }}">
                    {{ $order->status_label }}
                </div>
            </div>

            <!-- Items -->
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden">
                <div class="p-6 border-b border-[#E5E7EB] bg-[#F8FAF7]">
                    <h2 class="font-outfit font-semibold text-[#263238] text-lg">Artículos</h2>
                </div>
                <ul class="divide-y divide-[#E5E7EB]">
                    @foreach($order->items as $item)
                        <li class="p-6 flex flex-col sm:flex-row gap-6">
                            <div class="flex-shrink-0 w-24 aspect-[4/5] bg-gray-100 rounded-xl overflow-hidden border border-[#E5E7EB]">
                                <img src="{{ $item->product ? $item->product->cover_url : asset('images/placeholder.jpg') }}" class="w-full h-full object-cover">
                            </div>
                            
                            <div class="flex-1 flex flex-col justify-center">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-medium text-[#263238]">
                                            @if($item->product)
                                                <a href="{{ route('products.show', $item->product) }}" class="hover:text-[#2E7D32]">{{ $item->product_title }}</a>
                                            @else
                                                {{ $item->product_title }}
                                            @endif
                                        </h3>
                                        <p class="text-sm text-[#607D8B] mt-1">Vendedor: {{ $item->seller->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-[#263238]">{{ $item->formatted_unit_price }}</p>
                                        <p class="text-sm text-[#607D8B]">Cant: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Envío -->
            @if($order->shipment)
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden p-6">
                <h2 class="font-outfit font-semibold text-[#263238] text-lg mb-4">Estado del Envío</h2>
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center text-2xl">
                            <i class='bx bx-truck'></i>
                        </div>
                        <div>
                            <p class="font-medium text-[#263238]">{{ \App\Models\Shipment::$statuses[$order->shipment->status] ?? $order->shipment->status }}</p>
                            @if($order->shipment->tracking_number)
                                <p class="text-sm text-[#607D8B] mt-1">Guía: <span class="font-medium text-[#263238]">{{ $order->shipment->tracking_number }}</span></p>
                            @endif
                        </div>
                    </div>
                    @if($order->status === 'enviado')
                        <div class="w-full sm:w-auto pt-4 sm:pt-0">
                            <a href="{{ route('orders.confirm-delivery', $order) }}" class="btn-primary py-2.5 px-5 text-sm w-full text-center">
                                <i class='bx bx-check-double'></i> Confirmar Recepción
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- ───────────────── CHAT ───────────────── -->
            @if($order->status !== 'pendiente' && $order->status !== 'cancelado')
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden" id="chat-card">
                <!-- Header del chat -->
                <div class="p-5 border-b border-[#E5E7EB] bg-gradient-to-r from-[#F8FAF7] to-white flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#2E7D32]/10 flex items-center justify-center text-[#2E7D32] text-xl">
                        <i class='bx bx-message-rounded-dots'></i>
                    </div>
                    <div>
                        <h2 class="font-outfit font-semibold text-[#263238] text-lg leading-tight">Chat con el vendedor</h2>
                        <p class="text-xs text-[#607D8B]">Consulta sobre tu pedido #{{ $order->order_number }}</p>
                    </div>
                    <span id="chat-unread-badge" class="ml-auto hidden bg-[#2E7D32] text-white text-xs font-bold px-2 py-0.5 rounded-full"></span>
                </div>

                <!-- Mensajes -->
                <div id="chat-messages" class="h-80 overflow-y-auto p-5 space-y-3 bg-[#FAFAFA]">
                    <div id="chat-empty" class="flex flex-col items-center justify-center h-full text-center text-[#B0BEC5]">
                        <i class='bx bx-chat text-5xl mb-3'></i>
                        <p class="text-sm font-medium">Aún no hay mensajes</p>
                        <p class="text-xs mt-1">Escribe al vendedor si tienes alguna duda sobre tu compra.</p>
                    </div>
                </div>

                <!-- Input -->
                <div class="p-4 border-t border-[#E5E7EB] bg-white">
                    <form id="chat-form" class="flex items-center gap-3">
                        @csrf
                        <input
                            id="chat-input"
                            type="text"
                            placeholder="Escribe un mensaje..."
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
            @endif
            <!-- ───────────────── FIN CHAT ───────────────── -->

        </div>
        
        <!-- Sidebar Detalles -->
        <div class="w-full lg:w-1/3 space-y-6">
            
            <!-- Resumen -->
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden p-6">
                <h2 class="font-outfit font-semibold text-[#263238] text-lg mb-4">Resumen de pago</h2>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-sm text-[#607D8B]">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-[#607D8B]">
                        <span>Envío</span>
                        <span>${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                </div>
                
                <div class="border-t border-[#E5E7EB] pt-4">
                    <div class="flex justify-between items-end">
                        <span class="font-medium text-[#263238]">Total</span>
                        <span class="font-outfit font-bold text-2xl text-[#2E7D32]">{{ $order->formatted_total }}</span>
                    </div>
                </div>

                @if($order->payment)
                <div class="mt-4 pt-4 border-t border-[#E5E7EB]">
                    <p class="text-sm text-[#607D8B] flex items-center gap-2">
                        <i class='bx bx-check-shield text-[#2E7D32]'></i> Pagado con {{ ucfirst($order->payment->method) }}
                    </p>
                </div>
                @endif
            </div>

            <!-- Dirección -->
            @if($order->address)
            <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] overflow-hidden p-6">
                <h2 class="font-outfit font-semibold text-[#263238] text-lg mb-4">Dirección de entrega</h2>
                
                <p class="font-medium text-[#263238] mb-1">{{ $order->address->recipient_name }}</p>
                <p class="text-sm text-[#607D8B] leading-relaxed">
                    {{ $order->address->street }} {{ $order->address->exterior_number }}
                    @if($order->address->interior_number) Int {{ $order->address->interior_number }} @endif<br>
                    Col. {{ $order->address->neighborhood }}<br>
                    {{ $order->address->city }}, {{ $order->address->state }}<br>
                    CP {{ $order->address->postal_code }}, {{ $order->address->country }}
                </p>
            </div>
            @endif

        </div>

    </div>
</div>

@if($order->status !== 'pendiente' && $order->status !== 'cancelado')
@push('scripts')
<script>
(function() {
    const MESSAGES_URL = '{{ route('orders.messages.index', $order) }}';
    const STORE_URL    = '{{ route('orders.messages.store', $order) }}';
    const CSRF_TOKEN   = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';

    const container  = document.getElementById('chat-messages');
    const emptyState = document.getElementById('chat-empty');
    const form       = document.getElementById('chat-form');
    const input      = document.getElementById('chat-input');
    const sendBtn    = document.getElementById('chat-send-btn');
    const badge      = document.getElementById('chat-unread-badge');

    let lastMessageId = 0;
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

            // Solo agregar mensajes nuevos
            const existingIds = new Set([...container.querySelectorAll('[data-msg-id]')].map(el => Number(el.dataset.msgId)));
            const newMessages = data.messages.filter(m => !existingIds.has(m.id));

            if (newMessages.length > 0) {
                if (emptyState) emptyState.remove();
                const atBottom = container.scrollHeight - container.scrollTop <= container.clientHeight + 60;
                newMessages.forEach(msg => {
                    container.appendChild(createBubble(msg));
                    lastMessageId = Math.max(lastMessageId, msg.id);
                });
                if (atBottom) scrollToBottom(true);
            }

            // Badge de no leídos
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

    // Enviar mensaje
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

    // Polling cada 4 segundos
    fetchMessages();
    setInterval(fetchMessages, 4000);
})();
</script>
@endpush
@endif
@endsection

