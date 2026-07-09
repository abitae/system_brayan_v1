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

        .despache-number {
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
            font-size: 8px;
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
    </style>
</head>

<body>
    <div class="header">
        <img src="./img/logo.jpg" alt="Logo" class="logo">
        <div class="company-info">
            <strong>{{ $despache->company->razonSocial }}</strong><br>
            R.U.C.: {{ $despache->company->ruc }}<br>
            {{ $despache->encomienda->sucursal_remitente->address }}<br>
            Telf: {{ $despache->encomienda->sucursal_remitente->phone }}<br>
            Email: {{ $despache->encomienda->sucursal_remitente->email }}<br>
            <strong>Registro MTC: 1553682CNG</strong>
        </div>
    </div>

    <div class="despache-number">
        GUIA DE REMISION ELECTRONICA TRANSPORTISTA<br>
        {{ $despache->serie }} - {{ $despache->correlativo }}<br>
    </div>
    <div class="despache-number">
        @if ($despache->encomienda->isHome)
            DOMICILIO
        @else
            AGENCIA
        @endif
        <br>
        <strong>{{ $despache->encomienda->code }}</strong>
    </div>

    <div class="customer-info">
        Fecha Emisión: {{ $despache->created_at->format('Y-m-d H:i') }}<br>
        Fecha Traslado: {{ $despache->updated_at->format('Y-m-d H:i') }}<br>
    </div>
    <div class="customer-info">
        <strong>DATOS REMITENTE</strong><br>
        Razón Social: {{ $despache->remitente->name }}<br>
        {{ strtoupper($despache->remitente->type_code == 1 ? 'DNI' : 'RUC') }}: {{ $despache->remitente->code }}<br>
        @if ($despache->remitente->address)
            Dirección: {{ $despache->remitente->address }}<br>
        @endif
        @if ($despache->docsTraslado)
            Documento de Traslado: <br>
            @php
                $docsTraslado = json_decode($despache->docsTraslado, true);
            @endphp
            @forelse ($docsTraslado as $doc)
                {{ $doc['tipoDoc'] }}: {{ $doc['documento'] }} - {{ $doc['ruc'] }}<br>
            @empty
                Sin documentos<br>
            @endforelse
        @endif
    </div>
    <div class="customer-info">
        <strong>DATOS DESTINATARIO</strong><br>
        Razón Social: <strong>{{ $despache->destinatario->name }}</strong><br>
        {{ strtoupper($despache->destinatario->type_code == 1 ? 'DNI' : 'RUC') }}:
        <strong>{{ $despache->destinatario->code }}</strong><br>
        @if ($despache->destinatario->address)
            Dirección: {{ $despache->destinatario->address }}
        @endif
    </div>
    <div class="despache-number">
        {{ $despache->encomienda->estado_pago }}
    </div>
    <div class="customer-info">
        <strong>ORIGEN :</strong>{{ $despache->encomienda->sucursal_remitente->name }}<br>
        <strong>DESTINO:{{ $despache->encomienda->sucursal_destinatario->name }}</strong>
    </div>
    <div class="customer-info">
        <strong>TRANSPORTE y CONDUCTOR</strong><br>
        <strong>PLACA N°: :</strong>{{ $despache->encomienda->vehiculo->name }}<br>
        <strong>Config Vehiculo: :</strong>{{ $despache->encomienda->vehiculo->modelo }}<br>
        <strong>MTC: :</strong>{{ $despache->encomienda->vehiculo->nroCirculacion }}<br>
        <strong>DNI:</strong>{{ $despache->encomienda->transportista->dni }}<br>
        <strong>NOMBRE:</strong>{{ $despache->encomienda->transportista->name }}<br>
        <strong>LICENCIA:</strong>{{ $despache->encomienda->transportista->licencia }}
    </div>
    <table class="items-table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th style="text-align: right">Cant</th>
                <th style="text-align: right">Unidad</th>
                <th style="text-align: right">Precio</th>
                <th style="text-align: right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($despache->details as $detail)
                <tr>
                    <td>{{ $detail->descripcion }}</td>
                    <td style="text-align: right">{{ $detail->cantidad }}</td>
                    <td style="text-align: right">{{ $detail->unidad }}</td>
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
                <td style="text-align: right">S/ {{ number_format($despache->valorVenta, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left">IGV (18%):</td>
                <td style="text-align: right">S/ {{ number_format($despache->mtoIGV, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left"><strong>Importe total:</strong></td>
                <td style="text-align: right"><strong>S/
                        {{ number_format($despache->mtoImpVenta, 2) }}</strong></td>
            </tr>
        </table>
    </div>
    <div class="customer-info">
        <strong>GLOSA Y OBSERVACIONES</strong><br>
        {{ $despache->encomienda->glosa }}<br>
        {{ $despache->encomienda->observation }}<br>
        <div style="text-align: center">MERCADERIA SIN VERIFICAR Y SIN RESPONSABILIDAD PARA LA EMPRESA DE TRANSPORTES
        </div>
    </div>
    <div>
        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td style="width: 75%;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding-bottom: 20px;">
                                <p style="font-size: 8px; text-transform: uppercase;">USTED ESTA ACEPTANDO LAS
                                    CONDICIONES DE ENVÍO
                                    DEL COMPROBANTE QUE SE LE ENTREGO</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 20px;">
                                <p style="margin-top: 60px;">
                                    ____________________________<br>
                                    <span style="font-size: 8px;">Firma y Huella Digital</span><br>
                                    <span style="font-size: 8px;">DNI: _________________</span>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 25%;border: 1px dashed #000; height: 50px;margin-bottom: 5px;height: 80px;">
                </td>
            </tr>
        </table>
    </div>
    <div class="qr-code">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Codigo_QR.svg/100px-Codigo_QR.svg.png?20080824194905"
            alt="Código QR">
    </div>

    <div class="footer">
        Gracias por su compra<br>
        Políticas de Envío<br>
        Corporación Logística Brayan Brush EIRL<br>
        Usuario: {{ $despache->encomienda->user->name }}
    </div>
</body>

</html>
