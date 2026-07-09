<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .title {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 10pt;
            margin-bottom: 10px;
        }
        .info {
            margin-bottom: 5px;
            font-size: 9pt;
        }
        .info p {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 8pt;
        }
        th, td {
            border: 0.5px solid #ddd;
            padding: 3px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .total {
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8pt;
        }
        .section-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">REPORTE DE CAJA</div>
        <div class="subtitle">{{ date('d/m/Y H:i:s') }}</div>
    </div>

    <div class="info">
        <p><strong>Caja ID:</strong> {{ $caja->id }}</p>
        <p><strong>Usuario:</strong> {{ $caja->user->name }}</p>
        <p><strong>Fecha Apertura:</strong> {{ $caja->created_at->format('d/m/Y H:i:s') }}</p>
        <p><strong>Fecha Cierre:</strong> {{ $caja->isActive ? 'Caja Abierta' : $caja->updated_at->format('d/m/Y H:i:s') }}</p>
        <p><strong>Monto Apertura:</strong> S/. {{ number_format($caja->monto_apertura, 2) }}</p>
    </div>

    <div class="section-title">INGRESOS</div>
    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Método</th>
                <th>Tipo</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($caja->entries as $entry)
            <tr>
                <td>{{ $entry->description }}</td>
                <td>{{ $entry->metodo_pago }}</td>
                <td>{{ $entry->tipo_entry }}</td>
                <td>S/. {{ number_format($entry->monto_entry, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">EGRESOS</div>
    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Método</th>
                <th>Tipo</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($caja->exits as $exit)
            <tr>
                <td>{{ $exit->description }}</td>
                <td>{{ $exit->metodo_pago }}</td>
                <td>{{ $exit->tipo_exit }}</td>
                <td>S/. {{ number_format($exit->monto_exit, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">RESUMEN</div>
    <table>
        <tr>
            <td><strong>Monto Apertura:</strong></td>
            <td>S/. {{ number_format($caja->monto_apertura, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Ingresos Efectivo:</strong></td>
            <td>S/. {{ number_format($caja->entries->whereIn('metodo_pago', ['Efectivo'])->sum('monto_entry'), 2) }}</td>
        </tr>
        <tr>
            <td><strong>Ingresos Yape/Otros:</strong></td>
            <td>S/. {{ number_format($caja->entries->whereNotIn('metodo_pago', ['Efectivo'])->sum('monto_entry'), 2) }}</td>
        </tr>
        <tr>
            <td><strong>Egresos Efectivo:</strong></td>
            <td>S/. {{ number_format($caja->exits->whereIn('metodo_pago', ['Efectivo'])->sum('monto_exit'), 2) }}</td>
        </tr>
        <tr>
            <td><strong>Egresos Yape/Otros:</strong></td>
            <td>S/. {{ number_format($caja->exits->whereNotIn('metodo_pago', ['Efectivo'])->sum('monto_exit'), 2) }}</td>
        </tr>
        <tr>
            <td><strong>Total Efectivo en Caja:</strong></td>
            <td>S/. {{ number_format(
                $caja->monto_apertura +
                $caja->entries->whereIn('metodo_pago', ['Efectivo'])->sum('monto_entry') -
                $caja->exits->whereIn('metodo_pago', ['Efectivo'])->sum('monto_exit'), 2)
            }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Documento generado el {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
