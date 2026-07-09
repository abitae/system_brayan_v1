<table>
    <thead>
        <tr>
            <th>CODIGO</th>
            <th>SERIE</th>
            <th>CORRELATIVO</th>
            <th>FECHA EMISIÓN</th>
            <th>REMITENTE</th>
            <th>DESTINATARIO</th>
            <th>ESTADO</th>
            <th>TICKET</th>
            <th>CDR CÓDIGO</th>
            <th>CDR DESCRIPCIÓN</th>
        </tr>
    </thead>
    <tbody>
        @foreach($despatches as $despatche)
            <tr>
                <td>{{ $despatche->id }}</td>
                <td>{{ $despatche->serie }}</td>
                <td>{{ $despatche->correlativo }}</td>
                <td>{{ $despatche->fechaEmision }}</td>
                <td>{{ $despatche->remitente->name ?? 'Sin remitente' }}</td>
                <td>{{ $despatche->destinatario->name ?? 'Sin destinatario' }}</td>
                <td>{{ $despatche->estado }}</td>
                <td>{{ $despatche->ticket ?? 'Sin ticket' }}</td>
                <td>{{ $despatche->cdr_code ?? 'Sin código' }}</td>
                <td>{{ $despatche->cdr_description ?? 'Sin descripción' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>