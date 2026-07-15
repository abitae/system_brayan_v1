<table>
    <tbody>
        <tr>
            <td colspan="29">{{ $companyName }}</td>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="29">
                REGISTRO DE VENTAS DEL PERIODO DEL {{ $periodoInicio->format('d/m/Y') }} AL {{ $periodoFin->format('d/m/Y') }}
            </td>
        </tr>
        <tr></tr>
        <tr>
            <th>Número Correlativo</th>
            <th>Fecha de Emisión del Comprobante</th>
            <th>Fecha de Vcmto.</th>
            <th colspan="4">Comprobante de Pago</th>
            <th colspan="3">Información del Cliente</th>
            <th>Articulo</th>
            <th>Cantidad</th>
            <th>Valor Facturado de la Exportación</th>
            <th>Base imponible de la Operación Gravada</th>
            <th colspan="2">Importe Total de la Operación Exonerada o Inafecta</th>
            <th>ISC</th>
            <th>IGV y/o IPM</th>
            <th>Otros Tributos y Cargos que no forman parte de la Base Imponible</th>
            <th>Importe Total del Comprobante de Pago</th>
            <th>Tipo de Cambio</th>
            <th colspan="4">Referencia del Comprobante de Pago o Doc Orig que se modifica</th>
            <th>Fecha de Proceso</th>
            <th>Codigo Estado SUNAT</th>
            <th>Descripcion Estado SUNAT</th>
            <th>Forma de Pago</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th>Tipo (Tabla 10)</th>
            <th>Nro de Serie</th>
            <th>Número</th>
            <th></th>
            <th colspan="2">Documento de Identidad</th>
            <th>Apellidos y Nombre, Razón Social</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Tipo (Tabla 2)</th>
            <th>Número</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Exonerada</th>
            <th>Inafecto</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Fecha</th>
            <th>Tipo (Tabla 10)</th>
            <th>Nro de Serie</th>
            <th>Número</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr></tr>
        @foreach ($rows as $row)
            <tr>
                <td>{{ $row['numero_correlativo'] }}</td>
                <td>{{ $row['fecha_emision'] }}</td>
                <td>{{ $row['fecha_vencimiento'] }}</td>
                <td>{{ $row['tipo_doc_tabla'] }}</td>
                <td>{{ $row['serie'] }}</td>
                <td>{{ $row['numero'] }}</td>
                <td></td>
                <td>{{ $row['cliente_tipo_doc'] }}</td>
                <td>{{ $row['cliente_numero'] }}</td>
                <td>{{ $row['cliente_nombre'] }}</td>
                <td>{{ $row['articulo'] }}</td>
                <td>{{ $row['cantidad'] }}</td>
                <td>{{ number_format((float) $row['exportacion'], 2, '.', '') }}</td>
                <td>{{ number_format((float) $row['base_gravada'], 2, '.', '') }}</td>
                <td>{{ number_format((float) $row['exonerada'], 2, '.', '') }}</td>
                <td>{{ number_format((float) $row['inafecta'], 2, '.', '') }}</td>
                <td>{{ number_format((float) $row['isc'], 2, '.', '') }}</td>
                <td>{{ number_format((float) $row['igv'], 2, '.', '') }}</td>
                <td>{{ number_format((float) $row['otros_tributos'], 2, '.', '') }}</td>
                <td>{{ number_format((float) $row['importe_total'], 2, '.', '') }}</td>
                <td>{{ $row['tipo_cambio'] }}</td>
                <td>{{ $row['ref_fecha'] }}</td>
                <td>{{ $row['ref_tipo'] }}</td>
                <td>{{ $row['ref_serie'] }}</td>
                <td>{{ $row['ref_numero'] }}</td>
                <td>{{ $row['fecha_proceso'] }}</td>
                <td>{{ $row['codigo_estado_sunat'] }}</td>
                <td>{{ $row['descripcion_estado_sunat'] }}</td>
                <td>{{ $row['forma_pago'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
