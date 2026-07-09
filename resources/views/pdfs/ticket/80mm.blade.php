<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo {
            max-width: 150px;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 10px;
            margin-bottom: 10px;
        }

        .ticket-number {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 5px 0;
            text-align: center;
            font-weight: bold;
        }

        .customer-info {
            font-size: 10px;
            margin: 4px 0;
            border-bottom: 1px solid #000;
            padding-top: 5px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin: 10px 0;
        }

        .items-table th,
        .items-table td {
            padding: 3px;
            text-align: left;
        }

        .items-table th {
            background-color: #f0f0f0;
        }

        .totals {
            font-size: 10px;
            text-align: right;
            margin: 10px 0;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .qr-code {
            text-align: center;
            margin: 10px 0;
            border-top: 1px dashed #ccc;
            padding-top: 8px;
        }

        .qr-code img {
            width: 55px;
            height: 55px;
        }

        .qr-code-label {
            font-size: 8px;
            margin: 4px 0 0 0;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 9px;
            margin-top: 10px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
    </style>
</head>

<body>
    <div class="header">

        <img src="./img/logo.jpg" alt="Logo" class="logo">
        <div class="company-info">
            <strong>{{ $ticket->company->razonSocial }}</strong><br>
            R.U.C.: {{ $ticket->company->ruc }}<br>
            {{ $ticket->encomienda->sucursal_remitente->address }}<br>
            Telf: {{ $ticket->encomienda->sucursal_remitente->phone }}<br>
            Email: {{ $ticket->encomienda->sucursal_remitente->email }}
        </div>
    </div>

    <div class="ticket-number">
        TICKET N° {{ $ticket->serie }}<br>
        {{ $ticket->encomienda->estado_pago }}<br>
    </div>
    <div class="ticket-number">
        @if ($ticket->encomienda->isHome)
            DOMICILIO
        @else
            AGENCIA
        @endif
    </div>

    <div class="customer-info">
        Fecha Emisión: {{ $ticket->created_at->format('Y-m-d') }}<br>
        Fecha Traslado: {{ $ticket->updated_at->format('Y-m-d') }}<br>
    </div>
    <div class="customer-info">
        <strong>DATOS REMITENTE</strong><br>
        Razón Social: {{ $ticket->client->name }}<br>
        {{ strtoupper($ticket->client->type_code == 1 ? 'DNI' : 'RUC') }}: {{ $ticket->client->code }}<br>
        @if ($ticket->client->address)
            Dirección: {{ $ticket->client->address }}
        @endif
    </div>
    <div class="customer-info">
        <strong>DATOS DESTINATARIO</strong><br>
        Razón Social: {{ $ticket->encomienda->destinatario->name }}<br>
        {{ strtoupper($ticket->encomienda->destinatario->type_code == 1 ? 'DNI' : 'RUC') }}:
        {{ $ticket->encomienda->destinatario->code }}<br>
        @if ($ticket->encomienda->destinatario->address)
            Dirección: {{ $ticket->encomienda->destinatario->address }}
        @endif
        @if ($ticket->docsTraslado)
            Documento de Traslado: <br>
            @php
                $docsTraslado = json_decode($ticket->docsTraslado, true);
            @endphp
            @forelse ($docsTraslado as $doc)
                {{ $doc['tipoDoc'] }}: {{ $doc['documento'] }} - {{ $doc['ruc'] }}<br>
            @empty
                Sin documentos<br>
            @endforelse
        @endif
    </div>
    <div class="customer-info">
        <strong>DATOS ENVIO</strong><br>
        <strong>ORIGEN :<br></strong>{{ $ticket->encomienda->sucursal_remitente->address }}<br>
        <strong>DESTINO:<br></strong>{{ $ticket->encomienda->sucursal_destinatario->address }}
    </div>
    <div class="customer-info">
        <strong>TRANSPORTE y CONDUCTOR</strong><br>
        <strong>PLACA N°: :</strong>{{ $ticket->encomienda->vehiculo->name }}<br>
        <strong>DNI:</strong>{{ $ticket->encomienda->transportista->dni }}<br>
        <strong>NOMBRE:</strong>{{ $ticket->encomienda->transportista->name }}<br>
        <strong>LICENCIA:</strong>{{ $ticket->encomienda->transportista->licencia }}
    </div>
    <table class="items-table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th style="text-align: right">Cant</th>
                <th style="text-align: right">Precio</th>
                <th style="text-align: right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ticket->details as $detail)
                <tr>
                    <td>{{ $detail->descripcion }}</td>
                    <td style="text-align: right">{{ $detail->cantidad }}</td>
                    <td style="text-align: right">{{ $detail->mtoPrecioUnitario }}</td>
                    <td style="text-align: right">
                        {{ number_format($detail->mtoPrecioUnitario * $detail->cantidad, 2) }}</td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>

    <div class="totals">
        <table style="width: 100%">
            <tr>
                <td style="text-align: left">Gravada:</td>
                <td style="text-align: right">S/ {{ number_format($ticket->valorVenta, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left">IGV (18%):</td>
                <td style="text-align: right">S/ {{ number_format($ticket->mtoIGV, 2) }}</td>
            </tr>
            @if ($ticket->monto_descuento)
                <tr>
                    <td style="text-align: left">Descuento:</td>
                    <td style="text-align: right">S/ {{ number_format($ticket->monto_descuento, 2) }}</td>
                </tr>
            @endif
            <tr>
                <td style="text-align: left"><strong>Total:</strong></td>
                <td style="text-align: right"><strong>S/
                        {{ number_format($ticket->mtoImpVenta - $ticket->monto_descuento, 2) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="qr-code">
        <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR {{ $ticket->encomienda->code }}">
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
