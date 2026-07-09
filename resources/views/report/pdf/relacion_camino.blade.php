<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Relacion de envios {{$nombre_empleado}}</title>
  <style>
    @media print{@page {size: landscape}}
    body {
      font-size: 10px;
      /* text-align: center; */
    }
    table {
      width: 100%;
    }

    table[collapse='0'] tr th,
    table[collapse='0'] tr td {
      border-bottom: 1px solid #b9b9b9;
    }
  </style>
</head>
<body>
  <table>
    <tr>
      <td style="text-align: center">Encargado: <b>{{ $empleado[0]->ape_doc}} {{$empleado[0]->nom_doc}}</b></td>
    </tr>
    <tr>
      <td style="text-align: center">DNI: <b>{{ $empleado[0]->dni}}</b></td>
    </tr>
  </table>
  <table collapse="0">
    <thead>
      <tr>
        <th>ID</th>
        <th style="width: 50px;">Fecha</th>
        <th>Origen</th>
        <th style="width: 250px;">Nombres</th>
        <th style="width: 250px;">Dirección</th>
        <th>Teléfono</th>
        <th>Cantidad</th>
        <th>Descripción</th>
        <th>Pago/Debe</th>
      </tr>
    </thead>
    <tbody>
    @foreach($envios as $envio)
      <tr>
        <td style="width: 100px">{{ $envio->id_generado}}</td>
        <td>{{ $envio->fecha}}</td>
        <td style="text-align: center">{{ $envio->nombre_sucursal}}</td>
        <td>{{ ucwords(strtolower($envio->nombre_cliente)) }}</td>
        <td>{{ ucwords(strtolower($envio->direccion)) }}</td>
        <td>{{ $envio->cliente_telefono }}</td>
        <td style="text-align: center">{{ $envio->cantidad }}</td>
        <td>{{ $envio->descripcion }}</td>
        <td style="text-align: center">
          @if($envio->tipo_pago == 1)
            Pagado
          @elseif($envio->tipo_pago == 2)
            S/.{{ number_format($envio->monto,2) }}
          @endif
        </td>
      </tr>
    @endforeach
    <tr>
    <td colspan="8" style="text-align: right; font-weight: bold;">Total paquetes</td>
    <td>{{$total_registro}}</td>
    </tr>

  <script>
    window.print();
    window.onafterprint = (event) => {
      window.close();
    };
  </script>
</tbody>
</table>
</body>
</html>
