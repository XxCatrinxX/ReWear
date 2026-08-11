@extends('layouts.rewear')
@section('title', 'Confirmar Entrega — ' . $order->order_number)

@section('content')
<div class="max-w-lg mx-auto px-4 sm:px-6 py-10">

    <!-- Header con ícono de check -->
    <div class="text-center mb-6">
        <div class="w-20 h-20 mx-auto bg-[#2E7D32]/10 text-[#2E7D32] rounded-full flex items-center justify-center text-4xl mb-4">
            <i class='bx bx-check-shield'></i>
        </div>
        <h1 class="font-outfit text-2xl sm:text-3xl font-bold text-[#263238] mb-1">¿Recibiste tu paquete?</h1>
        <p class="text-[#607D8B] text-sm">Orden <span class="font-mono font-bold text-[#263238]">{{ $order->order_number }}</span></p>
    </div>

    <!-- Card principal -->
    <div class="bg-white border border-[#E5E7EB] rounded-3xl shadow-sm overflow-hidden">

        <!-- Tabs: Escáner QR | Confirmar manual -->
        <div class="flex border-b border-[#E5E7EB]" id="tabs">
            <button onclick="switchTab('qr')" id="tab-qr"
                class="flex-1 py-3 text-sm font-semibold transition flex items-center justify-center gap-2 tab-active">
                <i class='bx bx-qr-scan text-lg'></i> Escanear QR
            </button>
            <button onclick="switchTab('manual')" id="tab-manual"
                class="flex-1 py-3 text-sm font-semibold transition flex items-center justify-center gap-2 tab-inactive">
                <i class='bx bx-check-circle text-lg'></i> Confirmar manualmente
            </button>
        </div>

        <!-- Panel: Escáner QR -->
        <div id="panel-qr" class="p-6">
            <p class="text-sm text-[#607D8B] text-center mb-5">
                Apunta la cámara al <strong class="text-[#263238]">código QR impreso en la etiqueta del paquete</strong> para confirmar la entrega automáticamente.
            </p>

            <!-- Área de la cámara -->
            <div class="relative mx-auto mb-4" style="width: 260px; height: 260px;">
                <video id="qr-video" class="w-full h-full rounded-2xl object-cover bg-black" playsinline autoplay muted></video>

                <!-- Marco de escaneo animado -->
                <div class="absolute inset-0 pointer-events-none" style="padding: 28px;">
                    <div class="w-full h-full relative">
                        <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-[#2E7D32] rounded-tl-lg"></div>
                        <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-[#2E7D32] rounded-tr-lg"></div>
                        <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-[#2E7D32] rounded-bl-lg"></div>
                        <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-[#2E7D32] rounded-br-lg"></div>
                        <!-- Línea de escaneo animada -->
                        <div id="scan-line" class="absolute left-2 right-2 h-0.5 bg-[#2E7D32] shadow-lg" style="animation: scan 2s linear infinite;"></div>
                    </div>
                </div>
            </div>

            <p id="qr-status" class="text-xs text-center text-[#607D8B] mb-4">Iniciando cámara…</p>

            <button onclick="startCamera()" id="btn-camera"
                class="w-full py-2.5 rounded-xl border border-[#2E7D32] text-[#2E7D32] text-sm font-semibold hover:bg-[#2E7D32]/5 transition flex items-center justify-center gap-2">
                <i class='bx bx-camera'></i> Activar / Cambiar cámara
            </button>
        </div>

        <!-- Panel: Confirmación manual -->
        <div id="panel-manual" class="p-6 hidden">

            <!-- Artículos del pedido -->
            <div class="bg-[#F8FAF7] border border-[#E5E7EB] rounded-2xl p-4 mb-5">
                <h4 class="font-bold text-xs uppercase tracking-wider text-[#607D8B] mb-3">Prendas en este envío</h4>
                <ul class="space-y-3">
                    @foreach($order->items as $item)
                        <li class="flex items-center gap-3">
                            <img src="{{ $item->product?->cover_url }}" class="w-10 h-12 rounded-lg object-cover bg-white border border-[#E5E7EB]" alt="">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-[#263238] truncate">{{ $item->product_title }}</p>
                                <p class="text-xs text-[#607D8B]">Talla: {{ $item->product?->size ?? 'N/A' }} | Vendedor: {{ $item->product?->user?->name }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Aviso -->
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-amber-800 text-xs mb-6 leading-relaxed">
                <p class="font-bold mb-1"><i class='bx bx-info-circle align-middle mr-1'></i>Al confirmar:</p>
                <ul class="list-disc pl-4 space-y-1">
                    <li>Liberas el pago al vendedor de forma inmediata.</li>
                    <li>El envío quedará marcado como entregado con éxito.</li>
                    <li>Esta acción es <strong>irreversible</strong>.</li>
                </ul>
            </div>

            <form action="{{ route('orders.confirm-delivery.store', $order) }}" method="POST">
                @csrf
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('orders.show', $order) }}"
                       class="flex-1 py-3 rounded-xl border border-[#E5E7EB] text-sm font-semibold text-[#607D8B] hover:bg-[#F8FAF7] transition text-center">
                        No, aún no lo tengo
                    </a>
                    <button type="submit"
                        class="flex-1 py-3 rounded-xl bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-bold transition flex items-center justify-center gap-2">
                        <i class='bx bx-check-circle text-lg'></i> Sí, confirmar recibido
                    </button>
                </div>
            </form>
        </div>

    </div>

    <!-- Nota informativa -->
    <p class="text-center text-xs text-[#B0BEC5] mt-6">
        <i class='bx bx-lock-alt align-middle'></i>
        Tu pago está retenido de forma segura hasta que confirmes la entrega.
    </p>
</div>

<style>
    @keyframes scan {
        0%   { top: 8px; }
        50%  { top: calc(100% - 8px); }
        100% { top: 8px; }
    }
    .tab-active   { color: #2E7D32; border-bottom: 2px solid #2E7D32; background: #f0faf0; }
    .tab-inactive { color: #607D8B; border-bottom: 2px solid transparent; }
    .tab-inactive:hover { background: #f8faf7; }
</style>

<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script>
    const CONFIRM_URL = "{{ $confirmationUrl }}";
    let   stream      = null;
    let   scanning    = false;

    // ── Tabs ──
    function switchTab(tab) {
        document.getElementById('panel-qr').classList.toggle('hidden', tab !== 'qr');
        document.getElementById('panel-manual').classList.toggle('hidden', tab !== 'manual');
        document.getElementById('tab-qr').className     = 'flex-1 py-3 text-sm font-semibold transition flex items-center justify-center gap-2 ' + (tab === 'qr' ? 'tab-active' : 'tab-inactive');
        document.getElementById('tab-manual').className = 'flex-1 py-3 text-sm font-semibold transition flex items-center justify-center gap-2 ' + (tab === 'manual' ? 'tab-active' : 'tab-inactive');
        if (tab === 'qr') startCamera();
        else stopCamera();
    }

    // ── Cámara ──
    async function startCamera() {
        stopCamera();
        const status = document.getElementById('qr-status');
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
            const video = document.getElementById('qr-video');
            video.srcObject = stream;
            video.play();
            status.textContent = '📷 Apunta al código QR de la etiqueta…';
            scanning = true;
            requestAnimationFrame(scanFrame);
        } catch (e) {
            status.textContent = '⚠️ No se pudo acceder a la cámara. Usa la confirmación manual.';
            console.warn(e);
        }
    }

    function stopCamera() {
        scanning = false;
        if (stream) { stream.getTracks().forEach(t => t.stop()); stream = null; }
    }

    function scanFrame() {
        if (!scanning) return;
        const video = document.getElementById('qr-video');
        if (video.readyState !== video.HAVE_ENOUGH_DATA) { requestAnimationFrame(scanFrame); return; }

        const canvas = document.createElement('canvas');
        canvas.width  = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, imageData.width, imageData.height, { inversionAttempts: 'dontInvert' });

        if (code) {
            const decoded = code.data.trim();
            if (decoded === CONFIRM_URL.trim()) {
                document.getElementById('qr-status').textContent = '✅ QR válido detectado. Confirmando entrega…';
                stopCamera();
                // Enviar formulario automáticamente
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = CONFIRM_URL;
                const csrf = document.createElement('input');
                csrf.type  = 'hidden';
                csrf.name  = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
                return;
            } else {
                document.getElementById('qr-status').textContent = '⚠️ QR no reconocido. Asegúrate de escanear la etiqueta de ESTE pedido.';
            }
        }
        requestAnimationFrame(scanFrame);
    }

    // Iniciar cámara al cargar si la pestaña QR está activa
    window.addEventListener('load', () => startCamera());
    window.addEventListener('beforeunload', () => stopCamera());
</script>
@endsection
