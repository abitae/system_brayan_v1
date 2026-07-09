<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-size: 11px;
            color: #333;
            line-height: 1.2;
            margin: 0;
            padding: 0;
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
            margin-bottom: 10px;
        }

        .company-info {
            width: 60%;
            text-align: center;
            padding: 5px;
            font-size: 12px;
            vertical-align: top;
        }

        .company-logo {
            max-width: 150px;
            margin-bottom: 3px;
        }

        .despache-box {
            width: 40%;
            border: 1px solid #000;
            text-align: center;
            padding: 5px;
            font-size: 14px;
            vertical-align: middle;
        }

        .despache-title {
            font-size: 16px;
            margin: 3px 0;
        }

        /* Client Section */
        .customer-info {
            margin: 10px 0;
            width: 100%;
            border: 1px solid #ddd;
            padding: 5px;
            background-color: #f9f9f9;
        }

        .customer-heading {
            font-size: 12px;
            margin-bottom: 3px;
            color: #24af52;
        }

        .customer-detail {
            margin-bottom: 2px;
        }

        .customer-label {
            font-weight: bold;
            margin-right: 3px;
            min-width: 80px;
            display: inline-block;
        }

        /* Products Table */
        .items-table {
            width: 100%;
            margin: 10px 0;
            border: 1px solid #ddd;
        }

        .items-header {
            background-color: #f1f5f9;
            font-size: 12px;
            font-weight: bold;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .items-header th {
            padding: 4px;
        }

        .item-row td {
            padding: 4px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right;
        }

        /* Totals Section */
        .totals {
            width: 100%;
            margin-top: 10px;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

        .total-amount {
            font-weight: bold;
        }

        .total-final {
            font-weight: bold;
            font-size: 14px;
        }

        /* Footer */
        .footer {
            margin-top: 15px;
            padding: 10px;
            background-color: #f1f5f9;
            border-top: 1px solid #ddd;
            font-size: 11px;
            text-align: center;
            width: 100%;
        }

        .footer-table {
            width: 100%;
        }

        .footer-content {
            vertical-align: top;
            padding-left: 10px;
            text-align: left;
        }

        .signature-section {
            width: 100%;
            margin-top: 10px;
        }

        .signature-box {
            border: 1px dashed #000;
            height: 60px;
            margin-bottom: 3px;
        }
    </style>
</head>

<body>
    <!-- Header with Company and Despache Information -->
    <table class="header">
        <tr>
            <td class="company-info">
                <img class="company-logo" src="./img/logo.jpg" alt="Logo">
                <strong>{{ $despache->company->razonSocial }}</strong><br>
                R.U.C.: {{ $despache->company->ruc }}<br>
                {{ $despache->encomienda->sucursal_remitente->address }}<br>
                Telf: {{ $despache->encomienda->sucursal_remitente->phone }}<br>
                Email: {{ $despache->encomienda->sucursal_remitente->email }}<br>
                <strong>Registro MTC: 1553682CNG</strong>
            </td>
            <td class="despache-box">
                <h4>R.U.C.: {{ $despache->company->ruc }}</h4>
                <h3 class="despache-title">GUIA DE REMISION ELECTRONICA TRANSPORTISTA</h3>
                <h4>{{ $despache->serie }} - {{ $despache->correlativo }}</h4>
                <h4>
                    @if ($despache->encomienda->isHome)
                        DOMICILIO
                    @else
                        AGENCIA
                    @endif
                </h4>
            </td>
        </tr>
    </table>

    <!-- Dates Information -->
    <div class="customer-info">
        <div class="customer-detail"><span class="customer-label">Fecha
                Emisión:</span>{{ $despache->created_at->format('Y-m-d H:i') }}</div>
        <div class="customer-detail"><span class="customer-label">Fecha
                Traslado:</span>{{ $despache->updated_at->format('Y-m-d H:i') }}</div>
    </div>

    <!-- Remitente and Destinatario Information -->
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <div class="customer-info">
                    <h4 class="customer-heading">DATOS REMITENTE</h4>
                    <div class="customer-detail"><span class="customer-label">Razón
                            Social:</span>{{ $despache->remitente->name }}</div>
                    <div class="customer-detail"><span
                            class="customer-label">{{ strtoupper($despache->remitente->type_code == 1 ? 'DNI' : 'RUC') }}:</span>{{ $despache->remitente->code }}
                    </div>
                    @if ($despache->remitente->address)
                        <div class="customer-detail"><span
                                class="customer-label">Dirección:</span>{{ $despache->remitente->address }}</div>
                    @endif
                    @if ($despache->docsTraslado)
                        <div class="customer-detail"><span class="customer-label">Documento de Traslado:</span></div>
                        @php
                            $docsTraslado = json_decode($despache->docsTraslado, true);
                        @endphp
                        @forelse ($docsTraslado as $doc)
                            <div class="customer-detail">{{ $doc['tipoDoc'] }}: {{ $doc['documento'] }} -
                                {{ $doc['ruc'] }}</div>
                        @empty
                            <div class="customer-detail">Sin documentos</div>
                        @endforelse
                    @endif
                </div>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <div class="customer-info">
                    <h4 class="customer-heading">DATOS DESTINATARIO</h4>
                    <div class="customer-detail"><span class="customer-label">Razón
                            Social:</span><strong>{{ $despache->destinatario->name }}</strong></div>
                    <div class="customer-detail"><span
                            class="customer-label">{{ strtoupper($despache->destinatario->type_code == 1 ? 'DNI' : 'RUC') }}:</span><strong>{{ $despache->destinatario->code }}</strong>
                    </div>
                    @if ($despache->destinatario->address)
                        <div class="customer-detail"><span
                                class="customer-label">Dirección:</span>{{ $despache->destinatario->address }}</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>
    <!-- Transporte y Conductor -->
    <div class="customer-info">
        <h4 class="customer-heading">TRANSPORTE Y CONDUCTOR</h4>
        <div class="customer-detail"><span class="customer-label">PLACA
                N°:</span>{{ $despache->encomienda->vehiculo->name }}</div>
        <div class="customer-detail"><span
                class="customer-label">DNI:</span>{{ $despache->encomienda->transportista->dni }}</div>
        <div class="customer-detail"><span
                class="customer-label">NOMBRE:</span>{{ $despache->encomienda->transportista->name }}</div>
        <div class="customer-detail"><span
                class="customer-label">LICENCIA:</span>{{ $despache->encomienda->transportista->licencia }}</div>
    </div>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <div class="customer-info">
                    <h4 class="customer-heading">ESTADO DE PAGO</h4>
                    <div class="customer-detail">{{ $despache->encomienda->estado_pago }}</div>
                    <div class="customer-detail">{{ $despache->encomienda->code }}</div>
                </div>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <div class="customer-info">
                    <h4 class="customer-heading">RUTA</h4>
                    <div class="customer-detail"><span
                            class="customer-label">ORIGEN:</span>{{ $despache->encomienda->sucursal_remitente->name }}</div>
                    <div class="customer-detail"><span
                            class="customer-label">DESTINO:</span>{{ $despache->encomienda->sucursal_destinatario->name }}</div>
                </div>
            </td>
        </tr>
    </table>



    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr class="items-header">
                <th width="50%">Descripción</th>
                <th width="10%" class="text-right">Cant</th>
                <th width="10%" class="text-right">Unidad</th>
                <th width="15%" class="text-right">Precio</th>
                <th width="15%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($despache->details as $detail)
                <tr class="item-row">
                    <td>{{ $detail->descripcion }}</td>
                    <td class="text-right">{{ $detail->cantidad }}</td>
                    <td class="text-right">{{ $detail->unidad }}</td>
                    <td class="text-right">{{ $detail->mtoPrecioUnitario }}</td>
                    <td class="text-right">{{ number_format($detail->mtoPrecioUnitario * $detail->cantidad, 2) }}</td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>

    <!-- Totals Section -->
    <div class="totals">
        <table style="width: 100%">
            <tr>
                <td width="75%" class="text-right">Gravada:</td>
                <td width="25%" class="text-right">S/ {{ number_format($despache->valorVenta, 2) }}</td>
            </tr>
            <tr>
                <td class="text-right">IGV (18%):</td>
                <td class="text-right">S/ {{ number_format($despache->mtoIGV, 2) }}</td>
            </tr>
            <tr class="total-final">
                <td class="text-right">Importe total:</td>
                <td class="text-right">S/ {{ number_format($despache->mtoImpVenta, 2) }}</td>
            </tr>
        </table>
    </div>

    <!-- Glosa y Observaciones -->
    <div class="customer-info">
        <h4 class="customer-heading">GLOSA Y OBSERVACIONES</h4>
        <div class="customer-detail">{{ $despache->encomienda->glosa }}</div>
        <div class="customer-detail">{{ $despache->encomienda->observation }}</div>
        <div class="customer-detail">MERCADERIA SIN VERIFICAR Y SIN RESPONSABILIDAD PARA LA
            EMPRESA DE TRANSPORTES</div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <table style="width: 100%;">
            <tr>
                <td style="width: 75%;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding-bottom: 10px;">
                                <p style="font-size: 8px; text-transform: uppercase;">USTED ESTA ACEPTANDO LAS
                                    CONDICIONES DE ENVÍO DEL COMPROBANTE QUE SE LE ENTREGO</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 10px;">
                                <p style="margin-top: 40px;">
                                    ____________________________<br>
                                    <span style="font-size: 8px;">Firma y Huella Digital</span><br>
                                    <span style="font-size: 8px;">DNI: _________________</span>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 25%;">
                    <div class="signature-box"></div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td width="20%">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Codigo_QR.svg/100px-Codigo_QR.svg.png?20080824194905"
                        alt="Código QR">
                </td>
                <td class="footer-content">
                    Gracias por su compra<br>
                    Políticas de Envío<br>
                    Corporación Logística Brayan Brush EIRL<br>
                    Usuario: {{ $despache->encomienda->user->name }}
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
