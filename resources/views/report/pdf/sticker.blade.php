<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Sticker {{$envio->code}}</title>
</head>
<body style="margin: 0;">
  <style>
    body {
      font-family: Verdana, Arial, Helvetica, sans-serif;
    }
    .titulo {
      font-size: 19px;
    }
    .subtitulo {
      font-size: 9px;
    }
    .width-first {
      width: 90px;
      text-align: right;
    }
    .text-bold {
      font-weight: bold;
    }
  </style>
  <table style="width: 100%">
      <tr>
        <td colspan="2" style="text-align: left;">
          <strong class="titulo">Brayan Bursh</strong>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">
          <strong class="titulo">{{$envio->code}}</strong>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left" class="subtitulo text-bold">CAJAS - ({{$envio->cantidad}})</td>
      </tr>
      <tr>
        <td class="subtitulo width-first text-bold">Destinatario :</td>
        <td class="subtitulo text-bold">{{ $envio->destinatario->name}} </td>
        <td class="subtitulo text-bold">{{ $envio->name}} </td>
        <td class="subtitulo text-bold">{{ $envio->phone}} </td>
        <td class="subtitulo text-bold">{{ $envio->address}} </td>
      </tr>
      <tr>
        <td class="subtitulo width-first text-bold">Direccion destino :</td>
        <td class="subtitulo text-bold">{{ $envio->sucursal_destinatario->name }} </td>
      </tr>
      <tr>
        <td class="subtitulo width-first text-bold">Telefono :</td>
        <td class="subtitulo text-bold">{{ $envio->telefono_destino }} </td>
      </tr>
      <tr>
        <td class="subtitulo width-first text-bold">Fecha de registro :</td>
        <td class="subtitulo text-bold">{{
          \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d') }}</td>
      </tr>
  </table>
</body>
</html>
