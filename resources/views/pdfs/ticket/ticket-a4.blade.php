<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Factura A4</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.3;
        }

        .header {
            width: 100%;
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 20px;
        }

        .logo {
            width: 200px;
            float: left;
        }

        .company-info {
            float: right;
            width: 60%;
            text-align: right;
        }

        .document-type {
            clear: both;
            border: 2px solid #000;
            padding: 10px;
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 20px 0;
        }

        .customer-details {
            width: 100%;
            margin-bottom: 20px;
        }

        .customer-details td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .items-table th {
            background-color: #f2f2f2;
        }

        .totals-table {
            width: 40%;
            float: right;
            margin-top: 20px;
        }

        .totals-table td {
            padding: 5px;
            border: 1px solid #000;
        }

        .qr-section {
            clear: both;
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #000;
        }

        .qr-code {
            width: 100px;
            margin: 0 auto;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10pt;
            border-top: 1px solid #000;
            padding-top: 10px;
        }
    </style>
</head>

<body>
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
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Codigo_QR.svg/500px-Codigo_QR.svg.png?20080824194905"
            alt="Código QR">
    </div>

    <div class="footer">
        Gracias por su compra<br>
        Políticas de Envío<br>
        Corporación Logística Brayan Brush EIRL<br>
        Usuario: {{ $ticket->encomienda->user->name }}
    </div>
</body>

</html>
