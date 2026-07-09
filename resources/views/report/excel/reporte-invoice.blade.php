<table>
    <thead>
        <tr>
            <th colspan="14">REPORTE DE BOLETAS Y FACTURAS</th>
        </tr>
        <tr>
            <th>#</th>
            <th>Tipo documento</th>
            <th>Número</th>
            <th>Fecha emisión</th>
            <th>Doc. cliente</th>
            <th>Cliente</th>
            <th>Encomienda</th>
            <th>Forma pago</th>
            <th>Base imponible</th>
            <th>IGV</th>
            <th>Total</th>
            <th>Estado SUNAT</th>
            <th>CDR código</th>
            <th>CDR descripción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $invoice)
            @php
                $tipoLabel = match ($invoice->tipoDoc) {
                    '01' => 'Factura',
                    '03' => 'Boleta',
                    default => $invoice->tipoDoc,
                };
                $estadoSunat = $invoice->errorCode
                    ? 'Error'
                    : ($invoice->cdr_code === '0'
                        ? 'Aceptado'
                        : ($invoice->cdr_code
                            ? 'Observado'
                            : 'Pendiente'));
            @endphp
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $tipoLabel }}</td>
                <td>{{ $invoice->serie }}-{{ str_pad((string) $invoice->correlativo, 8, '0', STR_PAD_LEFT) }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->fechaEmision)->format('d/m/Y H:i') }}</td>
                <td>{{ $invoice->client?->code }}</td>
                <td>{{ $invoice->client?->name }}</td>
                <td>{{ $invoice->encomienda?->code ?? '-' }}</td>
                <td>{{ $invoice->formaPago_tipo }}</td>
                <td>{{ number_format((float) $invoice->mtoOperGravadas, 2, '.', '') }}</td>
                <td>{{ number_format((float) $invoice->mtoIGV, 2, '.', '') }}</td>
                <td>{{ number_format((float) $invoice->mtoImpVenta, 2, '.', '') }}</td>
                <td>{{ $estadoSunat }}</td>
                <td>{{ $invoice->cdr_code ?? '-' }}</td>
                <td>{{ $invoice->cdr_description ?? '-' }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8"><strong>TOTALES</strong></td>
            <td><strong>{{ number_format($totalBase, 2, '.', '') }}</strong></td>
            <td><strong>{{ number_format($totalIgv, 2, '.', '') }}</strong></td>
            <td><strong>{{ number_format($totalVentas, 2, '.', '') }}</strong></td>
            <td colspan="3"></td>
        </tr>
    </tbody>
</table>
