<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> {{ $envio->tipo_comprobante}} - {{ $envio->code }} </title>

  <style>
    html {
      margin: 5pt 5pt;
    }

    body {
      padding: 0;
      margin-left: 0;
    }

    table {
      border-top: 1px solid black;
      border-collapse: collapse;
      margin: 0px;
    }

    .titulo {
      font-size: 12px;
    }

    .subtitulo {
      font-size: 10px;
    }

    table tbody th {
      text-align: left;
    }

    .text-center {
      text-align: center;
    }

    .footer {
      text-align: center;
      margin-top: 20px;
      font-size: 12px;
      
    }
    .firma {
      border: 2px solid black;
      height: 100px;
      width: 250px;
    }
  </style>
</head>

<body>

  @php
  $total = 0;

  function convertImageBase64($image){
  $pathImage = public_path()."/img/".$image;
  $arrContextOptions = array(
  "ssl" => array (
  "verify_peer" => false,
  "verify_peer_name" => false,
  ),
  );
  $path = $pathImage;
  $type = pathinfo($path, PATHINFO_EXTENSION);
  $data = file_get_contents($path, false, stream_context_create($arrContextOptions));
  $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
  return $base64;
  }
  @endphp
  <table>
    <tbody>
      <tr>
        <td colspan="2" class="text-center"> <img src="{{ convertImageBase64("logo_format_ticket.jpg") }}"
            style="height: 90px;"> </td>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center">{{ $envio->tipo_comprobante }}</th>
      </tr>
      <tr>
        <th colspan="2" class="text-center titulo"> Guía Elect: {{ $envio->code }} </th>
      </tr>
      <tr>
        <th colspan="2" class="text-center titulo"> Doc. Traslado: {{ $envio->doc_traslado ?? ''}} </th>
      </tr>

      <tr>
        <td class="text-center titulo" colspan="2">Brayan Brush E.I.R.L</td>
      </tr>

      <tr>
        <td class="text-center titulo" colspan="2">Jr. Los Obreros 125 - La Victoria Lima La Victoria - Lima. </td>
      </tr>

      <tr>
        <td colspan="2" class="text-center titulo"> <b>RUC: 20568031734</b> </td>
      </tr>

      <tr>
        <td colspan="2" class="text-center titulo"> Central Telefónica: +51 970 795 188 </td>
      </tr>

      <tr>
        <td colspan="2" class="text-center titulo"> WhatsApp: +51 970 795 188</td>
      </tr>

      <tr>
        <td colspan="2" class="text-center subtitulo"> DATOS GUIA DE REMISION - TRANSPORTISTA</td>
      </tr>

      <tr>
        <td colspan="2" class="text-center subtitulo"> N° REGISTRO MTC - <b> 1553682 CNG </b>
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo"> Fecha Emisión: {{
          \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d H:s') }} </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo"> 
          Fecha Traslado: {{ $envio->fecha }} 
          
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          Usuario : {{ $envio->user->name }}
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>Origen: </b>{{ $envio->sucursal_remitente->name }}
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>Destino: </b>{{ $envio->sucursal_destinatario->name }}
        </td>
      </tr>

      <tr>
        <td colspan="2" class="titulo">
          <b>DATOS DEL REMITENTE: </b>
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>Nombre/Raz. Social: </b> {{ $envio->remitente->name }}
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>DNI/RUC: </b> {{ $envio->remitente->code }}
        </td>
      </tr>

      <tr>
        <td colspan="2" class="titulo">
          <b>DATOS DEL DESTINATARIO: </b>
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>Nombre/Raz. Social: </b> {{ $envio->destinatario->name }}
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>{{ $envio->destinatario->type_code }}: </b> {{ $envio->destinatario->code }}
        </td>
      </tr>

      <tr>
        <td colspan="2" class="subtitulo">
          <b>Dirección: </b> {{ $envio->destinatario->address }}
        </td>
      </tr>
      <tr>
        <td colspan="2" class="subtitulo">
          <b>Teléfono: </b> {{ $envio->destinatario->phone }}
        </td>
      </tr>
    </tbody>
  </table>

  <table>
    <tbody class="subtitulo">
      <tr>
        <th colspan="2" class="text-center subtitulo" style="font-size: 10px">
          DATOS DE LA UNIDAD DE TRANSPORTE Y CONDUCTOR
        </th>
      </tr>
      <tr>
        <td colspan="2">
          <b>Placa N°: </b> {{ $envio->vehiculo->placa }}
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <b>DNI: </b> {{$envio->transportista->dni }}
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <b>Nombres :</b> {{$envio->transportista->name}}
        </td>
      </tr>
      <tr>
        <td colspan="2"> Firma: </td>
      </tr>
    </tbody>
  </table>

  <table>
    <tbody class="subtitulo">
      <tr>
        <th colspan="4" class="text-center subtitulo" style="font-size: 10px">
          DESCRIPCIÓN DEL EMBALAJE
        </th>
      </tr>
      <tr>
        <th>Descripcion</th>
        <th>Cantidad</th>
        <th>Unitario</th>
        <th>Sub Total</th>
      </tr>
      @foreach($envio->paquetes as $detalle)
      <?php
          $total += $detalle->amount * $detalle->cantidad;
          $subTotal = $detalle->amount * $detalle->cantidad;
        ?>
      <tr>
        <td>{{$detalle->description}}</td>
        <td>{{$detalle->cantidad}}</td>
        <td>{{$detalle->amount}}</td>
        <td>{{number_format($subTotal,2)}}</td>
      </tr>
      @endforeach
      <tr>
        <td style="text-align: right;" colspan="2">TOTAL:</td>
        <td style="text-align: right;" colspan="2">S/. {{number_format($total,2)}}</td>
      </tr>
    </tbody>
  </table>
  <div class="firma">

  </div>
  <div class="footer">
    Políticas de Envío - Corporación Logística Brayan Brush
    <br>
•	El cliente debe proporcionar una dirección completa y un número de teléfono válido. Si no es posible contactar al destinatario o la dirección es incorrecta, el paquete será devuelto a nuestros almacenes.
•	Después de dos intentos fallidos, el envío será devuelto a nuestros almacenes. El cliente deberá coordinar el retiro o solicitar un nuevo envío, sujeto a costos adicionales.
•	Si el cliente requiere una entrega fuera del horario de 9 a.m. a 6 p.m., debe coordinarlo previamente. Este servicio está sujeto a disponibilidad y costos adicionales.
•	El destinatario puede autorizar a un tercero para recoger la encomienda, siempre que presente su DNI y la carta poder correspondiente.
•	El cliente puede optar por retirar su encomienda en un punto de recogida, acelerando el proceso y reduciendo riesgos.
•	En los envíos contra entrega, el cliente debe realizar el pago antes de recibir el paquete.
•	Si el envío no se recoge en 30 días, la empresa no se hará responsable. Desde el tercer día, se cobrará 5 soles por día de almacenamiento.
•	La empresa no verifica el contenido de los envíos. Es responsabilidad del cliente asegurarse de que los paquetes estén correctamente empaquetados.
•	Si el paquete llega dañado, debe ser revisado y grabado en el momento de la entrega. La empresa no se hace responsable si el daño es por mal embalaje.
•	Si no se recoge un envío con retorno de cargo en 60 días, no habrá regularización pendiente.
•	caso de extravío, se realizará una conciliación con el destinatario.
•	Los reclamos por daños o pérdidas deben presentarse en 3 días hábiles con boleta/factura y la guía de remisión.
•	Recuperar el código de envío tiene un costo de 10 soles y puede tomar entre 1 y 24 horas.
•	Se requiere presentar el DNI físico y el código de verificación para retirar el paquete.
•	La empresa no se responsabiliza por retrasos causados por factores externos como clima o bloqueos de carreteras.
</div>
</body>

</html>