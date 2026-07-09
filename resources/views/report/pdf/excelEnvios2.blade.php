<?php
  use Carbon\Carbon;
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
  </head>
  <body>
    @foreach ($envios as $nameBranch => $shipmentsBranches)
      <table>
        <tbody>
          <tr>
            <th colspan="8">Sucursal - {{$nameBranch}}</th>
          </tr>
          <tr>
            <th>Tracking</th>
            <th>Fecha Registro</th>
            <th>Destino</th>
            <th>Nombres</th>
            <th>Direccion</th>
            <th>Teléfono</th>
            <th>Cantidad</th>
            <th>Pago/Debe</th>
          </tr>
          @foreach ($shipmentsBranches as $envio)
            <tr>
              <td> {{ $envio->id_generado }}</td>
              <td> {{ Carbon::parse($envio->fecha)->format('d-m-Y') }}</td>
              <td> {{ $envio->sucursal_destino->nombre }}</td>
              <td> {{ $envio->nombre_destinatario }}</td>
              <td> {{ $envio->direccion_destino }}</td>
              <td> {{ $envio->telefono_destino }}</td>
              <td> {{ $envio->cantidad }}</td>
              <td>
                @if($envio->tipo_pago == 1)
                  Pagado
                @elseif($envio->tipo_pago == 2)
                  S/.{{ number_format($envio->monto,2) }}
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endforeach
  </body>
</html>
