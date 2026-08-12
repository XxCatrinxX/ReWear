<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Financiero y de Ventas — ReWear Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Outfit:wght@700;800&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', Arial, sans-serif;
            background-color: #f4f6f8;
            color: #1a202c;
            padding: 30px;
        }
        .report-card {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            padding: 36px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #2E7D32;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }
        .brand {
            font-family: 'Outfit', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: #2E7D32;
        }
        .report-title {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            font-weight: 700;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }
        .stat-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
        }
        .stat-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .stat-val {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
        }
        .highlight-val { color: #d97706; }
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 10px;
        }
        .table th {
            background: #f1f5f9;
            color: #475569;
            text-align: left;
            padding: 10px 12px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #cbd5e1;
        }
        .table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        .table tr:nth-child(even) { background: #fafafa; }
        .footer-total {
            background: #fef3c7;
            font-weight: 800;
        }
        .footer-total td {
            border-top: 2px solid #f59e0b;
            font-size: 13px;
        }
        .actions {
            max-width: 900px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }
        .btn-primary { background: #2E7D32; color: white; }
        .btn-secondary { background: white; color: #475569; border: 1px solid #cbd5e1; }
        
        @media print {
            body { background: white; padding: 0; }
            .actions { display: none !important; }
            .report-card { box-shadow: none; border: none; padding: 0; max-width: 100%; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="actions">
        <a href="{{ route('admin.revenue.index') }}" class="btn btn-secondary">← Volver al Panel</a>
        <button onclick="window.print()" class="btn btn-primary">🖨️ Descargar PDF / Imprimir Reporte</button>
    </div>

    <div class="report-card">
        <div class="header">
            <div>
                <div class="brand">♻ ReWear</div>
                <div class="report-title">Informe Ejecutivo de Ganancias y Ventas</div>
            </div>
            <div style="text-align: right; font-size: 12px; color: #64748b;">
                <p><strong>Fecha de Generación:</strong> {{ now()->format('d/m/Y H:i') }}</p>
                <p><strong>Filtro:</strong> Período {{ strtoupper($period) }} | Estado: {{ strtoupper($status) }}</p>
            </div>
        </div>

        <!-- Metricas ejecutivas -->
        <div class="meta-grid">
            <div class="stat-box" style="background:#fffbeb; border-color:#fef3c7">
                <div class="stat-label">Ganancia Empresa (5%)</div>
                <div class="stat-val highlight-val">${{ number_format($totalCommission, 2) }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Ventas Totales</div>
                <div class="stat-val">${{ number_format($totalSales, 2) }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Nº de Órdenes</div>
                <div class="stat-val">{{ $ordersCount }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Ticket Promedio</div>
                <div class="stat-val">${{ number_format($avgOrder, 2) }}</div>
            </div>
        </div>

        <h3 style="font-size:14px; font-weight:700; margin-bottom:12px; color:#334155;">Detalle Consolidado de Órdenes</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>Nº Orden</th>
                    <th>Comprador</th>
                    <th>Estado</th>
                    <th style="text-align:right">Monto Venta</th>
                    <th style="text-align:right">Comisión (5%)</th>
                    <th style="text-align:center">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    @php $com = $order->total * 0.05; @endphp
                    <tr>
                        <td style="font-family:monospace; font-weight:700;">#{{ $order->order_number }}</td>
                        <td>{{ $order->buyer?->name ?? '—' }}</td>
                        <td><span style="font-size:10px; font-weight:700; text-transform:uppercase;">{{ $order->status }}</span></td>
                        <td style="text-align:right; font-weight:600;">${{ number_format($order->total, 2) }}</td>
                        <td style="text-align:right; font-weight:700; color:#d97706;">${{ number_format($com, 2) }}</td>
                        <td style="text-align:center; color:#64748b;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:30px; color:#94a3b8;">
                            No existen registros para el rango seleccionado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if($orders->count() > 0)
            <tfoot>
                <tr class="footer-total">
                    <td colspan="3">TOTALES DEL PERÍODO</td>
                    <td style="text-align:right">${{ number_format($totalSales, 2) }}</td>
                    <td style="text-align:right; color:#b45309;">${{ number_format($totalCommission, 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>

        <div style="margin-top:40px; padding-top:20px; border-top:1px solid #e2e8f0; font-size:10px; color:#94a3b8; display:flex; justify-between:space-between;">
            <span>ReWear E-Commerce Platform — Reporte Oficial de Auditoría Interna</span>
            <span>Página 1 de 1</span>
        </div>
    </div>

</body>
</html>
