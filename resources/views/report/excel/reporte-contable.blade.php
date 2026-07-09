<table>
    <thead>
        <tr>
            <th colspan="13">REPORTE CONTABLE — COMPROBANTES ELECTRÓNICOS</th>
        </tr>
        <tr>
            <th>Fecha emisión</th>
            <th>Tipo documento</th>
            <th>Número</th>
            <th>Doc. cliente</th>
            <th>Cliente</th>
            <th>Encomienda</th>
            <th>Sucursal</th>
            <th>Forma pago / Ref.</th>
            <th>Base imponible</th>
            <th>IGV</th>
            <th>Total</th>
            <th>Estado SUNAT</th>
            <th>CDR</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $row)
            @php
                $factor = $row['factor'] ?? 1;
            @endphp
            <tr>
                <td>{{ $row['fecha_emision'] }}</td>
                <td>{{ $row['tipo_label'] }}</td>
                <td>{{ $row['numero'] }}</td>
                <td>{{ $row['cliente_doc'] }}</td>
                <td>{{ $row['cliente_nombre'] }}</td>
                <td>{{ $row['encomienda_code'] ?? '-' }}</td>
                <td>{{ $row['sucursal'] }}</td>
                <td>{{ $row['forma_pago'] }}</td>
                <td>{{ number_format($row['base'] * $factor, 2, '.', '') }}</td>
                <td>{{ number_format($row['igv'] * $factor, 2, '.', '') }}</td>
                <td>{{ number_format($row['total'] * $factor, 2, '.', '') }}</td>
                <td>{{ $row['estado_sunat'] }}</td>
                <td>{{ $row['cdr_code'] ?? '-' }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8"><strong>TOTALES NETOS</strong></td>
            <td><strong>{{ number_format($totalBase, 2, '.', '') }}</strong></td>
            <td><strong>{{ number_format($totalIgv, 2, '.', '') }}</strong></td>
            <td><strong>{{ number_format($totalVentas, 2, '.', '') }}</strong></td>
            <td colspan="2"></td>
        </tr>
    </tbody>
</table>
