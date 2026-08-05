<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta de Envío {{ $order->order_number }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Outfit:wght@600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            color: #263238;
            background-color: #f9f9f9;
        }
        .label-container {
            max-width: 550px;
            margin: 0 auto;
            background-color: #fff;
            border: 2px solid #263238;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .header {
            display: flex;
            justify-between;
            align-items: center;
            border-bottom: 2px dashed #cfd8dc;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .logo {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 24px;
            color: #2E7D32;
        }
        .order-num {
            font-family: monospace;
            font-weight: 700;
            font-size: 16px;
            background-color: #f1f8e9;
            color: #2E7D32;
            padding: 4px 10px;
            border-radius: 6px;
        }
        .section-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #607D8B;
            margin-bottom: 5px;
            font-weight: 700;
        }
        .address-box {
            background-color: #f8f9fa;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .recipient-name {
            font-weight: 700;
            font-size: 16px;
            margin: 0 0 5px 0;
        }
        .address-text {
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
        }
        .qr-section {
            display: flex;
            align-items: center;
            gap: 20px;
            border-top: 2px dashed #cfd8dc;
            padding-top: 20px;
            margin-top: 25px;
        }
        .qr-code {
            width: 120px;
            height: 120px;
            border: 1px solid #cfd8dc;
            padding: 5px;
            border-radius: 10px;
        }
        .qr-info {
            flex-grow: 1;
        }
        .qr-info h4 {
            margin: 0 0 5px 0;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
        }
        .qr-info p {
            margin: 0;
            font-size: 11px;
            color: #607D8B;
            line-height: 1.4;
        }
        .print-btn {
            display: block;
            width: fit-content;
            margin: 20px auto 0 auto;
            padding: 10px 24px;
            background-color: #2E7D32;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .print-btn:hover {
            background-color: #1B5E20;
        }
        @media print {
            body {
                background-color: #fff;
                padding: 0;
            }
            .label-container {
                box-shadow: none;
                border: 2px solid #000;
                margin: 0;
                max-width: 100%;
            }
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="label-container">
        <div class="header" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="logo">♻ ReWear</div>
            <div style="text-align: right;">
                <div class="order-num" style="margin-bottom: 4px;">Pedido: {{ $order->order_number }}</div>
                <div style="font-family: monospace; font-size: 13px; font-weight: bold; color: #263238;">Guía: {{ $order->shipment->tracking_number ?? 'RW-N/A' }}</div>
            </div>
        </div>

        <div class="section-title">Remitente</div>
        <div class="address-box" style="margin-bottom: 15px; padding: 10px 15px;">
            <p class="recipient-name" style="font-size: 13px;">{{ $order->items->first()->product->user->name }}</p>
            <p class="address-text" style="font-size: 12px; color: #607D8B;">Vendedor registrado de ReWear</p>
        </div>

        <div class="section-title">Destinatario (Enviar a)</div>
        <div class="address-box">
            <h3 class="recipient-name">{{ $order->address->recipient_name }}</h3>
            <p class="address-text">
                {{ $order->address->street }} #{{ $order->address->exterior_number }} 
                @if($order->address->interior_number) Int. {{ $order->address->interior_number }} @endif<br>
                Col. {{ $order->address->neighborhood }}<br>
                {{ $order->address->city }}, {{ $order->address->state }}<br>
                <strong>C.P. {{ $order->address->postal_code }}</strong><br>
                Tel: {{ $order->address->phone }}
            </p>
        </div>

        <div class="qr-section">
            <!-- Usamos un API gratis y confiable de códigos QR -->
            <img class="qr-code" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($confirmationUrl) }}" alt="QR de Entrega">
            <div class="qr-info">
                <h4>CÓDIGO DE VERIFICACIÓN DE ENTREGA</h4>
                <p>
                    <strong>Instrucciones para el vendedor:</strong> Pega esta etiqueta firmemente en el exterior de tu paquete.<br><br>
                    <strong>Instrucciones para el comprador:</strong> Al recibir este paquete físicamente, escanea este código QR con tu celular para confirmar la recepción y liberar los fondos al vendedor de forma segura.
                </p>
            </div>
        </div>
    </div>

    <button class="print-btn" onclick="window.print()">Imprimir Etiqueta</button>

</body>
</html>
