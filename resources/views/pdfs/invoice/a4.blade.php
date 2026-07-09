<html>

<head>
    <style>
        body {
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }

        h1,
        h2,
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

        /* Header Section */
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

        .company-logo {
            max-width: 180px;
            margin-bottom: 5px;
        }

        .invoice-box {
            width: 40%;
            border: 1px solid #000;
            text-align: center;
            padding: 10px;
            padding-top: 20px;
            font-size: 16px;
            vertical-align: middle;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .invoice-title {
            font-size: 18px;
            margin: 5px 0;
        }

        /* Client Section */
        .client-info {
            margin: 20px 0;
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

        .client-label {
            font-weight: bold;
            margin-right: 5px;
            min-width: 100px;
            display: inline-block;
        }

        /* Products Table */
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

        /* Totals Section */
        .totals-table {
            width: 100%;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .total-amount {
            font-weight: bold;
        }

        .total-final {
            font-weight: bold;
            font-size: 16px;
        }

        .amount-in-words {
            font-style: italic;
            color: #555;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding: 15px;
            background-color: #f1f5f9;
            border-top: 1px solid #ddd;
            font-size: 12px;
            text-align: center;
            width: 100%;
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

        .footer-table {
            width: 100%;
        }

        .qr-code {
            width: 100px;
            height: 100px;
        }

        .qr-code-label {
            font-size: 8px;
            margin-top: 4px;
            color: #444;
        }

        .footer-content {
            vertical-align: top;
            padding-left: 15px;
            text-align: left;
        }

        .info-table {
            width: 100%;
            border: 1px solid #ddd;
            padding: 2px;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <!-- Header with Company and Invoice Information -->
    <table class="header">
        <tr>
            <td class="company-info">
                <img height="80" src="./img/logo.jpg" alt="Logo" class="logo">
                <br>
                <strong>{{ $invoice->company->razonSocial }}</strong><br>
                R.U.C.: {{ $invoice->company->ruc }}<br>
                {{ $invoice->sucursal->address }}<br>
                Telf: {{ $invoice->sucursal->phone }}<br>
                Email: {{ $invoice->sucursal->email }}
            </td>
            <td class="invoice-box">
                <h4>R.U.C.: {{ $invoice->company->ruc }}</h4>
                <h3 class="invoice-title">{{ $invoice->tipoDoc == '01' ? 'FACTURA ELECTRONICA' : 'BOLETA ELECTRONICA' }}
                </h3>
                <h4>{{ $invoice->serie }} - {{ $invoice->correlativo }}</h4>
            </td>
        </tr>
    </table>

    <!-- Client Information Section -->
    <div class="client-info">
        <h4 class="client-heading">DATOS CLIENTE:</h4>
        <div class="client-detail"><span class="client-label">RUC:</span>{{ $invoice->client->code }}</div>
        <div class="client-detail"><span class="client-label">RAZON SOCIAL:</span>{{ $invoice->client->name }}</div>
        <div class="client-detail"><span class="client-label">DIRECCION:</span>{{ $invoice->client->address }}</div>
    </div>
    <table class="info-table">
        <tr>
            <td>
                <h4>Fecha de Emisión:</h4>
            </td>
            <td>
                <h4>Forma de Pago:</h4>
            </td>
            <td>
                <h4>Moneda:</h4>
            </td>
            <td>
                <h4>G.R.T:</h4>
            </td>
            <td>
                <h4>G.R.R:</h4>
            </td>
        </tr>
        <tr>
            <td>
                {{ $invoice->fechaEmision }}
            </td>
            <td>
                {{ $invoice->formaPago_tipo }}
            </td>
            <td>
                {{ $invoice->tipoMoneda }}
            </td>
            <td>
                @if ($invoice->encomienda)

                    {{ $invoice->encomienda->despatche->serie ?? '' }} -
                    {{ $invoice->encomienda->despatche->correlativo ?? '' }}


                @endif
            </td>
            <td>
                @if (!is_null($invoice->encomienda))
                    @php

                        $docsTraslado = json_decode($invoice->encomienda->despatche->docsTraslado ?? '', true);
                    @endphp
                    @if (!is_null($docsTraslado))
                    @forelse ($docsTraslado as $doc)
                        <div class="customer-detail">{{ $doc['tipoDoc'] }}: {{ $doc['documento'] }}</div>
                        @empty
                            <div class="customer-detail">Sin documentos</div>
                        @endforelse
                    @endif
                @elseif ($invoice->docAdjunto)
                    <div class="customer-detail">{{ $invoice->docAdjunto_type ?? '' }}: {{ $invoice->docAdjunto ?? '' }}</div>
                @else
                    <div class="customer-detail">Sin documentos</div>
                @endif
            </td>
        </tr>
    </table>
    <!-- Products Table Section -->
    <table class="products-table">
        <thead>
            <tr class="products-header">
                <th width="10%" class="text-right">Cant</th>
                <th width="60%">Descripción</th>
                <th width="15%" class="text-right">Precio</th>
                <th width="15%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoice->details as $detail)
                <tr class="product-item">
                    <td class="text-right">{{ $detail->cantidad }}</td>
                    <td>{{ $detail->descripcion }}</td>

                    <td class="text-right">{{ number_format($detail->mtoPrecioUnitario, 2) }}</td>
                    <td class="text-right">{{ number_format($detail->mtoPrecioUnitario * $detail->cantidad, 2) }}</td>
                </tr>
            @empty
                <tr class="product-item">
                    <td colspan="4" style="text-align: center;">No hay detalles disponibles</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Totals Section -->
    <table class="totals-table">
        <tr>
            <td width="60%" class="amount-in-words">SON: {{ $invoice->monto_letras }}</td>
            <td width="25%" class="text-right">Gravada:</td>
            <td width="15%" class="text-right">S/ {{ number_format($invoice->valorVenta, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="text-right">IGV (18%):</td>
            <td class="text-right">S/ {{ number_format($invoice->mtoIGV, 2) }}</td>
        </tr>
        <tr class="total-final">
            <td></td>
            <td class="text-right">Total:</td>
            <td class="text-right">S/ {{ number_format($invoice->valorVenta + $invoice->mtoIGV, 2) }}</td>
        </tr>
    </table>
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
    <table class="items-tableL">
        <tr>
            <td class="font-bold text-gray-700">
                Observaciones:
            </td>
            <td class="text-sm">
                @if($invoice->observacion)
                    {{ $invoice->observacion }}
                @else
                    <span class="text-gray-400 italic">Sin observaciones</span>
                @endif
            </td>
        </tr>
    </table>
    <!-- Footer Section -->
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td width="20%" style="text-align: center; vertical-align: top;">
                    <img class="qr-code" src="data:image/svg+xml;base64,{{ $qrCode }}" alt="Consulta validez CPE SUNAT">
                    <p class="qr-code-label">Consulta validez en SUNAT</p>
                </td>
                <td class="footer-content">
                    Gracias por su compra<br>
                    Políticas de Envío<br>
                    Corporación Logística Brayan Brush EIRL<br>
                    @if ($invoice->xml_hash)
                        Hash: {{ $invoice->xml_hash }}<br>
                    @endif
                    Usuario: {{ $invoice->encomienda->user->name ?? Auth::user()->name }}
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
