<html>

<head>
    <style>
        body {
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }

        h3,
        h4 {
            margin: 0;
            font-weight: bold;
            color: #222;
        }

        table {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        .company-info {
            width: 60%;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            vertical-align: top;
        }

        .invoice-box {
            width: 40%;
            border: 1px solid #000;
            text-align: center;
            padding: 10px;
            font-size: 16px;
            vertical-align: middle;
        }

        .invoice-title {
            font-size: 18px;
            margin: 5px 0;
        }

        .client-info {
            margin: 12px 0;
            width: 100%;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .client-heading {
            font-size: 14px;
            margin-bottom: 5px;
            color: #33ad48;
        }

        .client-detail {
            margin-bottom: 3px;
        }

        .products-table {
            width: 100%;
            margin: 20px 0;
            border: 1px solid #ddd;
        }

        .products-header {
            background-color: #f1f5f9;
            font-size: 14px;
            font-weight: bold;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .products-header th {
            padding: 8px;
        }

        .product-item td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right;
        }

        .totals-table {
            width: 40%;
            margin-top: 10px;
            margin-left: auto;
        }

        .totals-table td {
            padding: 4px 8px;
        }

        .total-final {
            font-weight: bold;
            font-size: 14px;
        }

        .footer {
            margin-top: 30px;
            padding: 15px;
            background-color: #f1f5f9;
            border-top: 1px solid #ddd;
            font-size: 12px;
            text-align: center;
            width: 100%;
        }

        .qr-code {
            width: 100px;
            height: 100px;
        }

        .qr-code-label {
            font-size: 10px;
            margin-top: 4px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <table class="header">
        <tr>
            <td class="company-info">
                <img height="80" src="./img/logo.jpg" alt="Logo"><br>
                <strong>{{ $ticket->company->razonSocial }}</strong><br>
                R.U.C.: {{ $ticket->company->ruc }}<br>
                {{ $ticket->encomienda->sucursal_remitente->address }}<br>
                Telf: {{ $ticket->encomienda->sucursal_remitente->phone }}<br>
                Email: {{ $ticket->encomienda->sucursal_remitente->email }}
            </td>
            <td class="invoice-box">
                <h3 class="invoice-title">TICKET</h3>
                <h4>{{ $ticket->serie }}</h4>
                <p>{{ $ticket->encomienda->estado_pago }}</p>
                <p>{{ $ticket->encomienda->isHome ? 'DOMICILIO' : 'AGENCIA' }}</p>
            </td>
        </tr>
    </table>

    <div class="client-info">
        <div class="client-detail">Fecha Emisión: {{ $ticket->created_at->format('Y-m-d') }}</div>
        <div class="client-detail">Fecha Traslado: {{ $ticket->updated_at->format('Y-m-d') }}</div>
    </div>

    <div class="client-info">
        <h4 class="client-heading">DATOS REMITENTE</h4>
        <div class="client-detail">Razón Social: {{ $ticket->client->name }}</div>
        <div class="client-detail">
            {{ strtoupper($ticket->client->type_code == 1 ? 'DNI' : 'RUC') }}: {{ $ticket->client->code }}
        </div>
        @if ($ticket->client->address)
            <div class="client-detail">Dirección: {{ $ticket->client->address }}</div>
        @endif
    </div>

    <div class="client-info">
        <h4 class="client-heading">DATOS DESTINATARIO</h4>
        <div class="client-detail">Razón Social: {{ $ticket->encomienda->destinatario->name }}</div>
        <div class="client-detail">
            {{ strtoupper($ticket->encomienda->destinatario->type_code == 1 ? 'DNI' : 'RUC') }}:
            {{ $ticket->encomienda->destinatario->code }}
        </div>
        @if ($ticket->encomienda->destinatario->address)
            <div class="client-detail">Dirección: {{ $ticket->encomienda->destinatario->address }}</div>
        @endif
        @if ($ticket->docsTraslado)
            <div class="client-detail">Documento de Traslado:</div>
            @php
                $docsTraslado = json_decode($ticket->docsTraslado, true);
            @endphp
            @forelse ($docsTraslado ?? [] as $doc)
                <div class="client-detail">{{ $doc['tipoDoc'] }}: {{ $doc['documento'] }} - {{ $doc['ruc'] }}</div>
            @empty
                <div class="client-detail">Sin documentos</div>
            @endforelse
        @endif
    </div>

    <div class="client-info">
        <h4 class="client-heading">DATOS ENVIO</h4>
        <div class="client-detail"><strong>ORIGEN:</strong> {{ $ticket->encomienda->sucursal_remitente->address }}</div>
        <div class="client-detail"><strong>DESTINO:</strong> {{ $ticket->encomienda->sucursal_destinatario->address }}</div>
    </div>

    <div class="client-info">
        <h4 class="client-heading">TRANSPORTE Y CONDUCTOR</h4>
        <div class="client-detail"><strong>PLACA N°:</strong> {{ $ticket->encomienda->vehiculo->name }}</div>
        <div class="client-detail"><strong>DNI:</strong> {{ $ticket->encomienda->transportista->dni }}</div>
        <div class="client-detail"><strong>NOMBRE:</strong> {{ $ticket->encomienda->transportista->name }}</div>
        <div class="client-detail"><strong>LICENCIA:</strong> {{ $ticket->encomienda->transportista->licencia }}</div>
    </div>

    <table class="products-table">
        <thead>
            <tr class="products-header">
                <th>Descripción</th>
                <th class="text-right">Cant</th>
                <th class="text-right">Precio</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ticket->details as $detail)
                <tr class="product-item">
                    <td>{{ $detail->descripcion }}</td>
                    <td class="text-right">{{ $detail->cantidad }}</td>
                    <td class="text-right">{{ number_format($detail->mtoPrecioUnitario, 2) }}</td>
                    <td class="text-right">{{ number_format($detail->mtoPrecioUnitario * $detail->cantidad, 2) }}</td>
                </tr>
            @empty
                <tr class="product-item">
                    <td colspan="4" class="text-right">Sin detalles</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td>Gravada:</td>
            <td class="text-right">S/ {{ number_format($ticket->valorVenta, 2) }}</td>
        </tr>
        <tr>
            <td>IGV (18%):</td>
            <td class="text-right">S/ {{ number_format($ticket->mtoIGV, 2) }}</td>
        </tr>
        @if ($ticket->monto_descuento)
            <tr>
                <td>Descuento:</td>
                <td class="text-right">S/ {{ number_format($ticket->monto_descuento, 2) }}</td>
            </tr>
        @endif
        <tr class="total-final">
            <td><strong>Total:</strong></td>
            <td class="text-right"><strong>S/
                    {{ number_format($ticket->mtoImpVenta - $ticket->monto_descuento, 2) }}</strong></td>
        </tr>
    </table>

    <div style="text-align: center; margin-top: 24px;">
        <img class="qr-code" src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR {{ $ticket->encomienda->code }}">
        <p class="qr-code-label">{{ $ticket->encomienda->code }}</p>
    </div>

    <div class="footer">
        Gracias por su compra<br>
        Políticas de Envío<br>
        Corporación Logística Brayan Brush EIRL<br>
        Usuario: {{ $ticket->encomienda->user->name }}
    </div>
</body>

</html>
