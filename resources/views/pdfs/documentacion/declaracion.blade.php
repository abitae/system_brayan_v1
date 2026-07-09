<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        /* Reset y estilos base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            padding: 10px;
            font-size: 12px;
            color: #000000;
        }

        /* Tablas */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td {
            padding: 5px;
        }

        /* Header */
        .header {
            margin-bottom: 20px;
        }

        .header__logo {
            width: 200px;
        }

        .header__company {
            text-align: right;
        }

        .header__title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header__info {
            font-size: 12px;
            line-height: 1.3;
        }

        /* Documento */
        .document {
            margin-bottom: 20px;
        }

        .document__title {
            border-bottom: 1px solid #000000;
            padding-bottom: 5px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .document__section {
            margin: 10px 0;
        }

        /* Contenido */
        .content-box {
            border: 1px solid #000000;
            padding: 10px;
            margin: 5px 0;
            min-height: 70px;
        }

        .content-box__item {
            margin: 5px 0;
        }

        /* Firmas */
        .signatures {
            margin-top: 20px;
        }

        .signature {
            width: 100%;
        }

        .signature_box {
            border: 1px solid #000000;
            height: 100px;
            width: 100%;
            margin-bottom: 10px;
        }


        .signature_info {
            text-align: center;
            line-height: 1.4;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            line-height: 1.3;
            padding: 0 20px;
        }

        /* Utilidades */
        .text-bold { font-weight: bold; }
        .text-justify { text-align: justify; }
        .text-center { text-align: center; }
        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 10px; }
        .mt-2 { margin-top: 10px; }
    </style>
</head>

<body>
    <table class="table header">
        <tr>
            <td style="width: 40%;">
                <img class="header__logo" src="./img/logo.jpg" alt="Logo">
            </td>
            <td>
                <div class="header__company">
                    <div class="header__title">{{ $encomienda->ticket->company->razonSocial }}</div>
                    <div class="header__title">{{ $encomienda->ticket->company->ruc }}</div>
                    <div class="header__info">
                        {{ $encomienda->ticket->company->address }}<br>
                        {{ $encomienda->ticket->company->phone }}<br>
                        {{ $encomienda->ticket->company->email }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="document">
        <div class="document__title">
            ASUNTO: DECLARACIÓN JURADA DE TRANSPORTE
        </div>

        <div class="document__section">
            Yo, <span class="text-bold">{{ $encomienda->remitente->name }}</span>, de nacionalidad
            □ Peruana □ Extranjera, identificado(a) con DNI/C.E. N° <span class="text-bold">{{ $encomienda->remitente->code }}</span>,
            declaro que la mercancía transportada a través de la agencia:
            <span class="text-bold">{{ $encomienda->sucursal_remitente->name }}</span>
            de la empresa CORPORACIÓN LOGÍSTICO BRAYAN BRUHS E.I.R.L., corresponde a:
        </div>

        <div class="document__section">
            <div class="text-bold mb-1">DESCRIPCIÓN DE LA MERCANCÍA (Especificar tipo de producto y cantidad)</div>
            <div class="content-box">
                @forelse ($encomienda->paquetes as $paquete)
                    <div class="content-box__item">
                        {{ $paquete->cantidad }} {{ $paquete->description }} - {{ $paquete->peso }} Kg
                    </div>
                @empty
                    <div class="content-box__item">No hay paquetes registrados</div>
                @endforelse
            </div>
        </div>

        <div class="document__section">
            <span class="text-bold">N° de ticket de tracking o guía de envío:</span>
            {{ $encomienda->ticket->serie }}
        </div>

        <div class="document__section">
            <div class="text-bold mb-1">SEGURO DE CARGA</div>
            <div class="mb-1">□ Sí, cuenta con seguro.</div>
            <div>□ No, la carga no cuenta con seguro, asumiendo el declarante la total responsabilidad.</div>
        </div>

        <div class="document__section text-justify">
            Declaro bajo juramento que la mercancía antes descrita <span class="text-bold">no cuenta con sustento documental</span>
            (guía de remisión, boleta o factura), pero que su envío <span class="text-bold">es legítimo y verídico, siendo de mi entera
            propiedad</span>. Asimismo, asumo plena responsabilidad sobre el contenido, origen y destino de la
            mercancía, exonerando a la empresa transportista de cualquier consecuencia derivada de su traslado.
            Declaro que los datos consignados en el presente documento son verídicos, sujetándome a lo dispuesto
            en el <span class="text-bold">Artículo 411 del Código Penal</span>, respecto a las sanciones por falsedad genérica.
        </div>

        <div class="document__section mt-2">
            <div class="mb-1"><span class="text-bold">LUGAR:</span> {{ $encomienda->sucursal_remitente->name }}</div>
            <div><span class="text-bold">FECHA Y HORA:</span> {{ $encomienda->ticket->fechaEmision }}</div>
        </div>

        <table class="signatures">
            <tr>
                <td class="signature">
                    <div class="signature_box">
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                    <div class="signature_info">
                        <div class="text-bold mb-1">FIRMA Y HUELLA DIGITAL DEL DECLARANTE</div>
                        <div>Nombre: {{ $encomienda->remitente->name }}</div>
                        <div>Teléfono: {{ $encomienda->remitente->phone }}</div>
                    </div>
                </td>
                <td class="signature">
                    <div class="signature_box">
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                    <div class="signature_info">
                        <div class="text-bold">OBSERVACIONES DEL RECEPCIONISTA</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        {{ $encomienda->sucursal_remitente->address }}<br>
        {{ $encomienda->sucursal_remitente->phone }}<br>
        {{ $encomienda->sucursal_remitente->email }}
    </div>
</body>

</html>
