<table>
    <tbody>
        <tr>
            <th colspan="5">{{ $encomienda->created_at->format('d/m/Y') }}</th>
        </tr>
        <tr>
            <td colspan="1">
            </td>
            <th>CONDUCTOR
            </th>
            <td>{{ $encomienda->transportista->name }}
            </td>
            <th>MARCA DEL VEHICULO
            </th>
            <td> {{ $encomienda->vehiculo->marca }}
            </td>
        </tr>
        <tr>
            <td colspan="1">
            </td>
            <th>DNI
            </th>
            <td>{{ $encomienda->transportista->dni }}
            </td>
            <th>CONFIGURACION VEHICULAR
            </th>
            <td>{{ $encomienda->vehiculo->tipo }}
            </td>
        </tr>
        <tr>
            <td colspan="1">
            </td>
            <th>PLACA
            </th>
            <td>{{ $encomienda->vehiculo->name }}
            </td>
            <th>MTC
            </th>
            <td>{{ $encomienda->transportista->licencia }}
            </td>
        </tr>
        <tr>
            <td colspan="1">
            </td>
            <th>LICENCIA
            </th>
            <td>{{ $encomienda->transportista->licencia }}
            </td>
            <th>TELEF
            </th>
            <td>{{ $encomienda->transportista->tipo }}
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>NRO GUIA</th>
            <th>GUIA CLIENTE</th>
            <th>REMITENTE</th>
            <th>TELEFONO</th>
            <th>DESTINATARIO</th>
            <th>TELEFONO</th>
            <th>DIRECCION</th>
            <th>CANTIDAD</th>
            <th>PAQUETES</th>
            <th>MONTO</th>
            <th>AGENCIA</th>
            <th>PAGO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($encomiendas as $encomiendaLibre)
            <tr>
                <td>{{ $encomiendaLibre->code }}</td>

                <td>
                    @forelse (json_decode($encomiendaLibre->docsTraslado,true) as $doc)
                        {{ $doc['documento'] }}
                    @empty
                        S/D
                    @endforelse

                </td>

                <td>{{ $encomiendaLibre->remitente->name }}</td>
                <td>{{ $encomiendaLibre->remitente->phone }}</td>
                <td>{{ $encomiendaLibre->destinatario->name }}</td>
                <td>{{ $encomiendaLibre->destinatario->phone }}</td>
                <td>{{ $encomiendaLibre->destinatario->address }}</td>
                <td>{{ $encomiendaLibre->cantidad }}</td>
                <td>
                    @php
                        $packsLibre = '';
                    @endphp
                    @forelse ($encomiendaLibre->paquetes as $paquete)
                        {{ $packsLibre . '' . $paquete->description . '(' . $paquete->cantidad . ')' . '(' . $paquete->amount . ')-' }}
                    @empty
                    @endforelse
                </td>
                <td>
                    {{ $encomiendaLibre->monto }}
                </td>
                <td>
                    {{ $encomiendaLibre->isHome ? 'DOMICILIO' : 'AGENCIA' }}
                </td>
                <td>
                    {{ $encomiendaLibre->estado_pago }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="10">
                Total: {{ $encomiendas->sum('monto') }}
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>NRO GUIA</th>
            <th>GUIA CLIENTE</th>
            <th>REMITENTE</th>
            <th>TELEFONO</th>
            <th>DESTINATARIO</th>
            <th>TELEFONO</th>
            <th>DIRECCION</th>
            <th>CANTIDAD</th>
            <th>PAQUETES</th>
            <th>MONTO</th>
            <th>DOMICILIO</th>
            <th>PAGO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($encomiendasIsHome as $encomienda)
            <tr>
                <td>{{ $encomienda->code }}</td>
                <td>
                    @forelse (json_decode($encomienda->docsTraslado,true) as $doc)
                        {{ $doc['documento'] }}
                    @empty
                        S/D
                    @endforelse
                </td>
                <td>{{ $encomienda->remitente->name }}</td>
                <td>{{ $encomienda->remitente->phone }}</td>
                <td>{{ $encomienda->destinatario->name }}</td>
                <td>{{ $encomienda->destinatario->phone }}</td>
                <td>{{ $encomienda->destinatario->address }}</td>
                <td>{{ $encomienda->cantidad }}</td>
                <td>
                    @php
                        $packs = '';
                    @endphp
                    @forelse ($encomienda->paquetes as $paquete)
                        {{ $packs . '' . $paquete->description . '(' . $paquete->cantidad . ')' . '(' . $paquete->amount . ')-' }}
                    @empty
                    @endforelse
                </td>
                <td>
                    {{ $encomienda->monto }}
                </td>
                <td>
                    {{ $encomienda->isHome ? 'DOMICILIO' : 'AGENCIA' }}
                </td>
                <td>
                    {{ $encomienda->estado_pago }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="10">
                Total: {{ $encomiendasIsHome->sum('monto') }}
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>NRO GUIA</th>
            <th>GUIA CLIENTE</th>
            <th>REMITENTE</th>
            <th>TELEFONO</th>
            <th>DESTINATARIO</th>
            <th>TELEFONO</th>
            <th>DIRECCION</th>
            <th>CANTIDAD</th>
            <th>PAQUETES</th>
            <th>MONTO</th>
            <th>RETORNO</th>
            <th>PAGO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($encomiendasIsReturn as $encomiendaReturn)
            <tr>
                <td>{{ $encomiendaReturn->code }}</td>
                <td>
                    @forelse (json_decode($encomiendaReturn->docsTraslado,true) as $doc)
                        {{ $doc['documento'] }}
                    @empty
                        S/D
                    @endforelse
                </td>
                <td>{{ $encomiendaReturn->remitente->name }}</td>
                <td>{{ $encomiendaReturn->remitente->phone }}</td>
                <td>{{ $encomiendaReturn->destinatario->name }}</td>
                <td>{{ $encomiendaReturn->destinatario->phone }}</td>
                <td>{{ $encomiendaReturn->destinatario->address }}</td>
                <td>{{ $encomiendaReturn->cantidad }}</td>
                <td>
                    @php
                        $packs = '';
                    @endphp
                    @forelse ($encomiendaReturn->paquetes as $paquete)
                        {{ $packs . '' . $paquete->description . '(' . $paquete->cantidad . ')' . '(' . $paquete->amount . ')-' }}
                    @empty
                    @endforelse
                </td>
                <td>
                    {{ $encomiendaReturn->monto }}
                </td>
                <td>
                    {{ $encomiendaReturn->isReturn ? 'RETORNO' : 'NO' }}
                </td>
                <td>
                    {{ $encomiendaReturn->estado_pago }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="10">
                Total: {{ $encomiendasIsReturn->sum('monto') }}
            </td>
        </tr>
    </tbody>
</table>
