@php
    function totalSum($detail) {
      $total = collect($detail)->reduce(function($acc,$item) {
        return $acc + ($item->cantidad * $item->monto);
      },0);
      return $total;
    }
@endphp
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manifiesto</title>
    <style>
      table {
        text-align: left;
      }
    </style>
</head>
<body>
  <table>
    <tr>
      <th colspan="5">Encargado: {{$empleado[0]->ape_doc}} {{$empleado[0]->nom_doc}}</th>
    </tr>
    <tr>
      <th colspan="5">Dni / Ruc: {{$empleado[0]->dni}}</th>
    </tr>
    <tr>
      <th>PLACA</th>
      <th>MTC</th>
      <th>LICENCIA</th>
      <th colspan="2">CONFIGURACIÓN VEHÍCULO</th>
    </tr>
    <tr>
      <th>{{ $empleado[0]->placa }}</th>
      <th>{{ $empleado[0]->mtc }}</th>
      <th>{{ $empleado[0]->licencia }}</th>
      <th colspan="2">{{ $empleado[0]->codigo }}</th>
    </tr>
  </table>

  <table>
    <thead>
      <tr>
        <th>Nro Guía</th>
        <th>Guía Cliente</th>
        <th>Fecha Entrega</th>
        <th>Destino</th>
        <th>Nombres</th>
        <th>Direccion</th>
        <th>Teléfono</th>
        <th>Descripción</th>
        {{-- <th>Cantidad</th> --}}
        {{-- <th>Precio Unit.</th> --}}
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
    @foreach($envios as $envio)
      <tr>
        <td>{{ $envio->id_generado }}</td>
        <td>{{ $envio->doc_traslado }}</td>
        <td>{{ \Carbon\Carbon::parse($envio->fecha)->format('d-m-Y')}}</td>
        <td>
          {{ $envio->sucursal_destino->nombre}}
        </td>
        <td>{{ $envio->nombre_destinatario }}</td>
        <td>{{ $envio->direccion_destino }}</td>
        <td>{{ $envio->telefono_destino }}</td>
        <td>
          @foreach ($envio->detalle_envio as $detalle)
          &nbsp;{{$detalle->descripcion}}({{$detalle->cantidad}} UND)({{number_format($detalle->monto,2)}} {{$detalle->monto > 1 ? 'SOLES' : 'SOL'}}) \&nbsp;
          @endforeach
        </td>
        <td> S/.{{ number_format(totalSum($envio->detalle_envio),2) }} </td>
      </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
