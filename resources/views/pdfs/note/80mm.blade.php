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

        .invoice-number {
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

        .items-tableL {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin: 0px 0;
            border: 1px solid #000;
        }

        .items-tableL td {
            padding: 1px;
            text-align: left;
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
        }

        .qr-code img {
            width: 100px;
        }

        .footer {
            text-align: center;
            font-size: 9px;
            margin-top: 10px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .legends {
            font-size: 10px;
            margin-top: 10px;
            border-top: 1px solid #000;
        }

        .info-table {
            width: 100%;
            border: 1px solid #000;
            margin: 5px 0;
            font-size: 9px;
        }

        .info-table td {
            padding: 2px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="./img/logo.jpg" alt="Logo" class="logo">
        <div class="company-info">
            <strong>{{ $note->company->razonSocial }}</strong><br>
            R.U.C.: {{ $note->company->ruc }}<br>
            {{ $note->sucursal->address }}<br>
            Telf: {{ $note->sucursal->phone }}<br>
            Email: {{ $note->sucursal->email }}
        </div>
    </div>

    <div class="invoice-number">
        NOTA DE CRÉDITO ELECTRÓNICA<br>
        {{ $note->serie }} - {{ $note->correlativo }}
    </div>

    <div class="customer-info">
        <strong>DATOS CLIENTE</strong><br>
        Razón Social: {{ $note->client->name }}<br>
        {{ strtoupper($note->client->type_code == 1 ? 'DNI' : 'RUC') }}: {{ $note->client->code }}<br>
        @if ($note->client->address)
            Dirección: {{ $note->client->address }}
        @endif
    </div>

    <table class="info-table">
        <tr>
            <td>Fecha Emisión:</td>
            <td>{{ $note->fechaEmision }}</td>
        </tr>
        <tr>
            <td>Documento Afectado:</td>
            <td>{{ $note->tipoDocAfectado == '01' ? 'FACTURA' : 'BOLETA' }} {{ $note->numDocfectado }}</td>
        </tr>
        <tr>
            <td>Moneda:</td>
            <td>{{ $note->tipoMoneda }}</td>
        </tr>
        <tr>
            <td>Motivo:</td>
            <td>{{ $note->desMotivo }}</td>
        </tr>
    </table>

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
            @forelse ($note->details as $detail)
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
                <td style="text-align: right">S/ {{ number_format($note->mtoOperGravadas, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left">IGV (18%):</td>
                <td style="text-align: right">S/ {{ number_format($note->mtoIGV, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left"><strong>Total:</strong></td>
                <td style="text-align: right"><strong>S/
                        {{ number_format($note->mtoOperGravadas + $note->mtoIGV, 2) }}</strong></td>
            </tr>
        </table>
    </div>

    @if ($note->observacion)
        <div class="legends">
            <strong>Observación:</strong> {{ $note->observacion }}
        </div>
    @endif

    <div class="legends">
        @php
            $legends = json_decode($note->legends, true);
        @endphp
        @foreach ($legends as $legend)
            {{ strtoupper(str_replace('"', '', str_replace('Leyenda', '', $legend['value']))) }}<br>
        @endforeach
    </div>
    <table class="items-tableL">
        <tr>
            <td class="text-sm">
                <strong>Observaciones:</strong>
            </td>
            <td class="text-sm text-left">
                @if($note->observacion)
                    {{ $note->observacion }}
                @else
                    <span class="text-gray-400 italic">Sin observaciones</span>
                @endif
            </td>
        </tr>
    </table>
    <div class="qr-code">
        <img height="100" src="./img/consultaqr.png" alt="Logo" class="logo">
    </div>

    <div class="footer">
        Gracias por su compra<br>
        Políticas de Envío<br>
        Corporación Logística Brayan Brush EIRL<br>
        @if ($note->xml_hash)
            Hash: {{ $note->xml_hash }}<br>
        @endif
        Usuario: {{ $note->user->name ?? Auth::user()->name }}
    </div>
</body>

</html>
