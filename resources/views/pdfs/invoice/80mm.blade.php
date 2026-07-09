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
            width: 55px;
            height: 55px;
        }

        .qr-code-label {
            font-size: 7px;
            margin-top: 4px;
            color: #333;
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
    </style>
</head>

<body>
    <div class="header">
        <img src="./img/logo.jpg" alt="Logo" class="logo">
        <div class="company-info">
            <strong>{{ $invoice->company->razonSocial }}</strong><br>
            R.U.C.: {{ $invoice->company->ruc }}<br>
            {{ $invoice->sucursal->address }}<br>
            Telf: {{ $invoice->sucursal->phone }}<br>
            Email: {{ $invoice->sucursal->email }}
        </div>
    </div>

    <div class="invoice-number">
        {{ $invoice->tipoDoc == '01' ? 'FACTURA ELECTRONICA' : 'BOLETA ELECTRONICA' }}<br>
        {{ $invoice->serie }} - {{ $invoice->correlativo }}
    </div>
    <div class="customer-info">
        Fecha Emisión: {{ $invoice->created_at->format('Y-m-d') }}<br>
        Metodo de Pago: {{ $invoice->encomienda->metodo_pago ?? 'Efectivo' }}<br>
        @if (isset($invoice->encomienda) && $invoice->encomienda->doc_guia)
            @php
                $guia = $invoice->encomienda->doc_guia;
                $despatche = App\Models\Facturacion\Despatche::find($guia);
            @endphp
            Guia de Remisión Transportista:
            {{ $despatche ? "{$despatche->serie}-{$despatche->correlativo}" : 'No disponible' }}
        @endif
        @if ($invoice->encomienda)
            @php
                $docsTraslado = json_decode($invoice->encomienda->despatche->docsTraslado, true);
            @endphp
            @forelse ($docsTraslado as $doc)
                <div class="customer-detail">{{ $doc['tipoDoc'] }}: {{ $doc['documento'] }}</div>
            @empty
                <div class="customer-detail">Sin documentos</div>
            @endforelse
        @elseif ($invoice->docAdjunto)
            <div class="customer-detail">{{ $invoice->docAdjunto_type }}: {{ $invoice->docAdjunto }}</div>
        @else
            <div class="customer-detail">Sin documentos</div>
        @endif
    </div>
    <div class="customer-info">
        <strong>DATOS CLIENTE</strong><br>
        Razón Social: {{ $invoice->client->name }}<br>
        {{ strtoupper($invoice->client->type_code == 1 ? 'DNI' : 'RUC') }}: {{ $invoice->client->code }}<br>
        @if ($invoice->client->address)
            Dirección: {{ $invoice->client->address }}
        @endif
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
            @forelse ($invoice->details as $detail)
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
                <td style="text-align: right">S/ {{ number_format($invoice->valorVenta, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left">IGV (18%):</td>
                <td style="text-align: right">S/ {{ number_format($invoice->mtoIGV, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left"><strong>Total:</strong></td>
                <td style="text-align: right"><strong>S/
                        {{ number_format($invoice->mtoImpVenta, 2) }}</strong></td>
            </tr>
        </table>
    </div>
    @if ($invoice->observacion)
        <div class="legends">
            <strong>Observación:</strong> {{ $invoice->observacion }}
        </div>
    @endif
    <div class="legends">
        @php
            $legends = json_decode($invoice->legends, true);
        @endphp
        @foreach ($legends as $legend)
            {{ strtoupper(str_replace('"', '', str_replace('Leyenda', '', $legend['value']))) }}<br>
        @endforeach
        @if ($invoice->setPercent && $invoice->setMount)
            <table class="items-tableL">
                <tr>
                    <td>
                        Servicio:
                    </td>
                    <td>
                        027 - Servicio de Transporte de Carga
                    </td>
                </tr>
                <tr>
                    <td>
                        Metodo de Pago:
                    </td>
                    <td>
                        001 - Depósito en cuenta
                    </td>
                </tr>
                <tr>
                    <td>
                        Numero de Cuenta:
                    </td>
                    <td>
                        {{ $invoice->ctaBanco }} Porcentaje: {{ $invoice->setPercent }}% Monto:
                        {{ $invoice->setMount }}
                    </td>
                </tr>
            </table>
        @endif
    </div>
    <div class="qr-code">
        <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="Consulta validez CPE SUNAT">
        <p class="qr-code-label">Consulta validez en SUNAT</p>
    </div>

    <div class="footer">
        Gracias por su compra<br>
        Políticas de Envío<br>
        Corporación Logística Brayan Brush EIRL<br>
        @if ($invoice->xml_hash)
            Hash: {{ $invoice->xml_hash }}<br>
        @endif
        Usuario: {{ $invoice->encomienda->user->name ?? Auth::user()->name }}
    </div>
</body>

</html>
