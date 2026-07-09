<?php
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=boletas.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
?>
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table>
    <tr>
        <td></td>
        <td>Sucursal</td>
        <td>Cantidad</td>
    </tr>
    @php
        $n = 0;
    @endphp
    @foreach($total_envios as $total)
        @php
            $n++;
        @endphp
        <tr>
            <td>{{$n}}</td>
            <td>{{$total["nombre"]}}</td>
            <td>{{$total["total"]}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
