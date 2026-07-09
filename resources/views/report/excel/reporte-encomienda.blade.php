<table>
    <thead>
        <tr>
            <th>CODIGO</th>
            <th>GUIA CLIENTE</th>
            <th>DESTINATARIO</th>
            <th>TELEFONO</th>
            <th>REMITENTE</th>
            <th>CANTIDAD</th>
            <th>PAQUETES</th>
            <th>MONTO</th>
            <th>DESCUENTO</th>
            <th>METODO DE PAGO</th>
            <th>TIPO DE COMPROBANTE</th>
            <th>RETORNO</th>
            <th>TIPO ENVIO</th>
            <th>CREDITO</th>
            <th>DOCUMENTO</th>
            <th>FECHA DE REGISTRO</th>
            <th>FECHA DE ENTRAGA</th>
        </tr>
    </thead>
    <tbody>
        @foreach($encomiendas as $encomiendaLibre)
                <tr>
                    <td>{{ $encomiendaLibre->code }}</td>
                    <td>
                        @php
                            $docs = $encomiendaLibre->docsTraslado ? json_decode($encomiendaLibre->docsTraslado, true) : null;
                        @endphp
                        @if($docs && is_array($docs) && count($docs) > 0)
                            @foreach($docs as $doc)
                                {{ is_array($doc) ? json_encode($doc) : $doc }}@if(!$loop->last), @endif
                            @endforeach
                        @else
                            NINGUNO
                        @endif
                    </td>
                    <td>{{ $encomiendaLibre->destinatario->name ?? '' }}</td>
                    <td>{{ $encomiendaLibre->destinatario->phone ?? '' }}</td>
                    <td>{{ $encomiendaLibre->remitente->name ?? '' }}</td>
                    <td>{{ $encomiendaLibre->cantidad }}</td>
                    <td>
                        @php
                            $packsLibre = [];
                            foreach ($encomiendaLibre->paquetes as $paquete) {
                                $packsLibre[] = $paquete->description . '(' . $paquete->cantidad . ')(' . $paquete->amount . ')';
                            }
                        @endphp
                        {{ implode(' - ', $packsLibre) }}
                    </td>
                    <td>{{ $encomiendaLibre->monto }}</td>
                    <td>{{ $encomiendaLibre->monto_descuento }}</td>
                    <td>{{ $encomiendaLibre->metodo_pago ?? 'CONTADO' }}</td>
                    <td>{{ $encomiendaLibre->tipo_comprobante ?? 'NINGUNO' }}</td>
                    <td>{{ $encomiendaLibre->isReturn ? 'SI' : 'NO' }}</td>
                    <td>{{ $encomiendaLibre->isHome ? 'DOMICILIO' : 'AGENCIA' }}</td>
                    <td>{{ $encomiendaLibre->estado_credito ?? '' }}</td>
                    <td>{{ $encomiendaLibre->destinatario->code ?? '' }}</td>
                    <td>{{ $encomiendaLibre->fecha_creacion }}</td>
                    <td>{{ $encomiendaLibre->fecha_entrega }}</td>
                </tr>
        @endforeach
    </tbody>
</table>
