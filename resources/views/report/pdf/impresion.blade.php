@php
  function renderTextDocument($typeDocument) {
    $listDocuments = array(1 => "BOLETA ELECTRÓNICA", 2 => "FACTURA ELECTRÓNICA", 3 => "TICKET ELECTRÓNICO");
    return $listDocuments[$typeDocument];
  }
  $total = 0;

  function convertImageBase64($image){
    $pathImage = public_path()."/img/".$image;
    $arrContextOptions = array(
      "ssl" => array (
        "verify_peer" => false,
        "verify_peer_name" => false
      ),
    );
    $path = $pathImage;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path, false, stream_context_create($arrContextOptions));
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
  }
@endphp
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Guía de remisión - {{$envio->id_generado}} </title>
</head>
<body>
  <style>
    table {
      width: 200px;
      max-width: 200px;
    }
    .tabla_dato {
      margin-top: 15px;
    }
    .titulo {
      font-size: 14px;
    }
    .subtitulo {
      font-size: 10px;
    }
    table tbody th{
      text-align: left;
    }
    .text-center {
      text-align: center;
    }
  </style>
  <table>
    <tbody>
      <tr>
        <td colspan="2" class="text-center"> <img src="{{ convertImageBase64("logo_format_ticket.jpg") }}" style="height: 90px;"> </td>
      </tr>
      <tr>
        <td colspan="2" class="titulo text-center">Brayan Brush E.I.R.L</td>
      </tr>

      <tr>
        <th colspan="2" class="titulo text-center"> Cód. Tracking: {{ $envio->id_generado}} </th>
      </tr>
      <tr>
        <th colspan="2" class="titulo text-center"> Guía de Remisión Electrónica Transportista:<br>{{ $envio->guiaRemision->codigo}} </th>
      </tr>

      <tr>
        <td colspan="2" class="titulo text-center">Jr. Los Obreros 125 - La Victoria Lima La Victoria - Lima. </td>
      </tr>

      <tr>
        <td colspan="2" class="titulo text-center"> <b>RUC: 20568031734</b> </td>
      </tr>
      <tr>
        <td colspan="2" class="titulo text-center"> {{$envio->fecha_registro}} </td>
      </tr>
        <tr>
        <td colspan="2" class="titulo text-center"> WhatsApp: +51 970 795 188 </td>
      </tr>
      <tr>
        <td colspan="2" class="titulo text-center"> N°Reg.MTC : 1553682 CNG</td>
      </tr>


      <tr>
        <th colspan="2" style="text-align: center"> ORIGEN </th>
      </tr>
      <tr>
        <td colspan="2" style="font-size: 12px;"><b>LUGAR:</b> {{ $envio->sucursal->nombre }}</td>
      </tr>
      <tr>
        <td colspan="2" style="font-size: 12px;"><b>CLIENTE:</b> {{ $envio->cliente->nombre }}</td>
      </tr>
      <tr>
        <td colspan="2" style="font-size: 12px;"><b>DNI/RUC:</b> {{ $envio->cliente->dni }}</td>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center"> DESTINO </th>
      </tr>
      <tr>
        <td colspan="2" style="font-size: 12px;"><b>LUGAR:</b> {{ $envio->direccion_destino }}</td>
      </tr>
      <tr>
        <td colspan="2" style="font-size: 12px;"><b>DESTINO:</b> {{ $envio->nombre_destinatario }}</td>
      </tr>
      <tr>
        <td colspan="2" style="font-size: 12px;"><b>DNI/RUC:</b> {{ $envio->documento_destinatario }}</td>
      </tr>
      <tr><td></td></tr>
      <tr><td></td></tr>
      <tr>
        <th colspan="2" style="text-align: center; font-size: 12px;">CONDUCTOR/TRASPORTE</th>
      </tr>
      <tr>
        <td colspan="2" style="font-size: 12px;"><b>DNI/RUC:</b> {{ $envio->nro_documento_transporte }}</td>
      </tr>
      <tr>
        <td colspan="2" style="font-size: 12px;"><b>Nombres/Raz. Social:</b> {{ $envio->razon_social_transporte }}</td>
      </tr>
      <tr>
        <td colspan="2" style="font-size: 12px;"><b>Trans. placa:</b> {{ $envio->nro_placa_transporte }}</td>
      </tr>
      <tr>
        <td colspan="2" style="font-size: 12px;"> Firma: </td>
      </tr>

    </tbody>
  </table>

  <table class="subtitulo">
    <tbody>
      <tr>
        <th colspan="4" style="text-align: center"> DESCRIPCIÓN DEL EMBALAJE </th>
      </tr>
      <tr>
        <th>Descripción</th>
        <th>Cant.</th>
        <th>Unit.</th>
        <th>Sub Total</th>
      </tr>
      @foreach($envio->detalle_envio as $detalle)
        <?php
          $total += $detalle->monto * $detalle->cantidad;
          $subTotal = $detalle->monto * $detalle->cantidad;
        ?>
        <tr>
            <td>{{$detalle->descripcion}}</td>
            <td>{{$detalle->cantidad}}</td>
            <td>{{$detalle->monto}}</td>
            <td style="text-align: right;">{{number_format($subTotal,2)}}</td>
        </tr>
      @endforeach
      <tr>
        <td style="text-align: right;" colspan="2">TOTAL:</td>
        <td style="text-align: right;" colspan="2">S/. {{number_format($total,2)}}</td>
      </tr>
    </tbody>
  </table>

</body>
</html>



{{--
  <!doctype html>
  <html lang="es">
    <body>
      <div class="container" style="page-break-after: always">
        <div class="row" style="width: 100%">
            <div class="col-xs-12">
                <table class="table tabla_dato" style="display: inline-table; padding-top: 15px;">

                    <tr>
                        <td style="text-align: center; font-size: .8em; padding: 0;">{{$empleado->placa}}</td>
                        <td style="text-align: right; font-size: .8em; padding: 0; ">
                            <span style="display:block ; width: 70%; "> {{$empleado->mtc}}</span></td>
                    </tr>
                    <tr>
                        <td style="text-align: center; font-size: .8em; padding: 0;">{{$empleado->codigo}}</td>
                        <td style="text-align: right; font-size: .8em; padding: 0;"><span
                                style="display: block; width: 70%;">{{$empleado->licencia}}</span></td>
                    </tr>

                </table>
                <table class="table" style="margin-top: 10px; display: inline-table;">
                    $n = 1;
                    $total = 0;
                    @foreach($detalles as $detalle)
                        @php
                          $total += $detalle->monto;
                        @endphp
                        <tr>
                            <td style="text-align: center; font-size: .8em;width: 5%; padding: 0 8px ">{{$n}}</td>
                            <td style="text-align: center; font-size: .8em; width: 73%; padding: 0 8px">{{$detalle->descripcion}}</td>
                            <td style="text-align: center; font-size: .8em; width: 6%; padding: 0 8px">{{$detalle->cantidad}}</td>
                            <td style="text-align: center; font-size: .8em; width: 6%; padding: 0 8px">{{$detalle->medida}}</td>
                            <td style="text-align: right; font-size: .8em;width: 10%; padding: 0 8px">{{$detalle->peso}}</td>
                        </tr>
                        $n++;
                    @endforeach
                </table>
                <br>
                <table class="table" style="margin-top: 10px; display: inline-table;">
                    <tr>
                        <td colspan="5" style="font-size: .8em;width: 5%; padding: 0 8px ">Monto Total : S/. {{$total}}</td>
                    </tr>
                </table>
            </div>
        </div>
      </div>
    </body>
  </html>
--}}
