<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guía FedEx — {{ $order->order_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Barcode&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #e8e8e8;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 24px 16px 40px;
            min-height: 100vh;
        }

        /* ── Acciones (no se imprimen) ── */
        .actions {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }
        .btn-print { background: #4d148c; color: #fff; }
        .btn-print:hover { background: #3a0f6e; }
        .btn-back  { background: #fff; color: #333; border: 1.5px solid #ccc; }
        .btn-back:hover { background: #f5f5f5; }

        /* ── Etiqueta principal ── */
        .label {
            width: 102mm;
            background: #fff;
            border: 2px solid #000;
            font-family: Arial, Helvetica, sans-serif;
            page-break-inside: avoid;
        }

        /* ── Banda naranja FedEx ── */
        .fedex-header {
            background: #ff6200;
            padding: 8px 10px 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .fedex-logo {
            font-size: 26px;
            font-weight: 900;
            letter-spacing: -1px;
            color: #fff;
            font-style: italic;
        }
        .fedex-logo span { color: #4d148c; }
        .fedex-service {
            background: #4d148c;
            color: #ff6200;
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 1.5px;
            padding: 3px 7px;
            border-radius: 3px;
        }

        /* ── Guía / Tracking strip ── */
        .tracking-strip {
            background: #000;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 4px 10px;
        }
        .tracking-label { font-size: 8px; letter-spacing: 1px; text-transform: uppercase; }
        .tracking-number { font-size: 13px; font-weight: 900; letter-spacing: 2px; font-family: 'Courier New', monospace; }

        /* ── Body de la etiqueta ── */
        .label-body { padding: 8px 10px; }

        .section-label {
            font-size: 7px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #555;
            margin-bottom: 2px;
        }

        .origin-dest-row {
            display: flex;
            gap: 6px;
            margin-bottom: 8px;
        }
        .addr-block {
            flex: 1;
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 6px 8px;
        }
        .addr-block.dest { border-color: #000; border-width: 2px; }
        .addr-name { font-size: 10px; font-weight: 700; line-height: 1.3; }
        .addr-line { font-size: 8.5px; line-height: 1.4; color: #333; }
        .addr-cp   { font-size: 10px; font-weight: 900; margin-top: 3px; }

        /* ── Separador ── */
        .divider { border: none; border-top: 1.5px dashed #aaa; margin: 7px 0; }
        .divider-solid { border: none; border-top: 2px solid #000; margin: 7px 0; }

        /* ── Contenido / Artículos ── */
        .items-section { margin-bottom: 8px; }
        .item-row {
            display: flex;
            justify-content: space-between;
            font-size: 8px;
            color: #333;
            padding: 1px 0;
        }
        .item-name { flex: 1; }
        .item-weight { font-weight: 700; white-space: nowrap; }

        /* ── QR + código de barras area ── */
        .qr-barcode-row {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 2px solid #000;
            border-radius: 6px;
            padding: 8px;
            margin-bottom: 8px;
            background: #fafafa;
        }
        .qr-img { width: 72px; height: 72px; display: block; border: 1px solid #ccc; }
        .qr-right { flex: 1; }
        .qr-title {
            font-size: 8px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            color: #4d148c;
        }
        .qr-instructions {
            font-size: 7px;
            line-height: 1.4;
            color: #444;
        }
        .qr-instructions strong { color: #000; }

        /* ── Código de barras simulado ── */
        .barcode-area {
            text-align: center;
            padding: 6px 0 4px;
            border-top: 1.5px solid #ddd;
        }
        .barcode-img {
            width: 100%;
            height: 32px;
            object-fit: fill;
        }
        .barcode-text {
            font-family: 'Courier New', monospace;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2px;
            margin-top: 2px;
        }

        /* ── Footer fedex ── */
        .fedex-footer {
            background: #f0f0f0;
            border-top: 1px solid #ccc;
            padding: 4px 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer-text { font-size: 7px; color: #666; }
        .footer-date { font-size: 7px; font-weight: 700; color: #333; }

        /* ── Advertencia de escaneo ── */
        .scan-notice {
            background: linear-gradient(135deg, #4d148c, #7b2fbe);
            color: #fff;
            text-align: center;
            padding: 5px 8px;
            font-size: 7.5px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        @media print {
            body { background: #fff; padding: 0; margin: 0; display: block; }
            .actions { display: none !important; }
            .label { border: 2px solid #000; width: 100%; max-width: 102mm; margin: 0 auto; }
        }
    </style>
</head>
<body>

    <div class="actions">
        <a href="{{ url()->previous() }}" class="btn btn-back">← Volver</a>
        <button onclick="window.print()" class="btn btn-print">🖨️ Imprimir Guía FedEx</button>
    </div>

    <div class="label">

        <!-- ── Header naranja FedEx ── -->
        <div class="fedex-header">
            <div class="fedex-logo">Fed<span>Ex</span></div>
            <div style="text-align:right">
                <div class="fedex-service">ECONOMY</div>
                <div style="color:#fff;font-size:8px;margin-top:2px;letter-spacing:1px">ENVÍO ESTÁNDAR</div>
            </div>
        </div>

        <!-- ── Tracking strip negro ── -->
        <div class="tracking-strip">
            <div>
                <div class="tracking-label">Número de Guía</div>
                <div class="tracking-number">{{ $order->shipment->tracking_number ?? 'FDX-'.strtoupper(substr($order->order_number,3)) }}</div>
            </div>
            <div style="text-align:right">
                <div class="tracking-label">Pedido</div>
                <div style="font-size:10px;font-weight:700;font-family:monospace;">{{ $order->order_number }}</div>
            </div>
        </div>

        <div class="label-body">

            <!-- ── Origen / Destino ── -->
            <div class="origin-dest-row">
                <div class="addr-block">
                    <div class="section-label">Remitente</div>
                    <div class="addr-name">{{ $order->items->first()?->product?->user?->name ?? 'Vendedor ReWear' }}</div>
                    <div class="addr-line">Vendedor registrado<br>ReWear Platform — MX</div>
                </div>
                <div class="addr-block dest">
                    <div class="section-label">⬛ Destinatario</div>
                    <div class="addr-name">{{ $order->address?->recipient_name }}</div>
                    <div class="addr-line">
                        {{ $order->address?->street }} #{{ $order->address?->exterior_number }}
                        @if($order->address?->interior_number) Int. {{ $order->address->interior_number }} @endif<br>
                        Col. {{ $order->address?->neighborhood }}<br>
                        {{ $order->address?->city }}, {{ $order->address?->state }}
                    </div>
                    <div class="addr-cp">C.P. {{ $order->address?->postal_code }}</div>
                </div>
            </div>

            <hr class="divider">

            <!-- ── Artículos ── -->
            <div class="items-section">
                <div class="section-label">Contenido del paquete</div>
                @foreach($order->items as $item)
                    <div class="item-row">
                        <span class="item-name">{{ Str::limit($item->product_title, 40) }}</span>
                        <span class="item-weight">x{{ $item->quantity }}</span>
                    </div>
                @endforeach
            </div>

            <hr class="divider-solid">

            <!-- ── QR + instrucciones ── -->
            <div class="qr-barcode-row">
                <img class="qr-img"
                     src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($confirmationUrl) }}"
                     alt="QR Confirmación de Entrega">
                <div class="qr-right">
                    <div class="qr-title">🔐 Verificación de Entrega</div>
                    <div class="qr-instructions">
                        <strong>Instrucciones para el comprador:</strong><br>
                        Al recibir el paquete, escanea este código QR con la cámara de tu celular para confirmar la recepción y liberar el pago al vendedor.<br><br>
                        <strong>⚠ No escanear hasta recibir físicamente el paquete.</strong>
                    </div>
                </div>
            </div>

            <!-- ── Código de barras simulado ── -->
            <div class="barcode-area">
                <img class="barcode-img"
                     src="https://barcode.tec-it.com/barcode.ashx?data={{ urlencode($order->shipment->tracking_number ?? 'FDXRW'.$order->id) }}&code=Code128&translate-esc=on"
                     alt="Código de barras"
                     onerror="this.style.display='none'">
                <div class="barcode-text">{{ $order->shipment->tracking_number ?? 'FDX-'.$order->id }}</div>
            </div>
        </div>

        <!-- ── Aviso de escaneo ── -->
        <div class="scan-notice">
            📱 El comprador debe escanear el QR para liberar los fondos al vendedor
        </div>

        <!-- ── Footer ── -->
        <div class="fedex-footer">
            <span class="footer-text">fedex.com | 800-900-1100 (simulado)</span>
            <span class="footer-date">Generado: {{ now()->format('d/m/Y') }}</span>
        </div>

    </div>

</body>
</html>
