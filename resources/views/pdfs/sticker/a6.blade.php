<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Etiqueta {{ $encomienda->code }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #111;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .label {
            width: 100%;
            border: 2px solid #111;
            page-break-inside: avoid;
        }

        .top-bar td {
            padding: 8px 12px;
            vertical-align: middle;
            border-bottom: 2px solid #111;
        }

        .brand {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 0.3px;
        }

        .brand-sub {
            font-size: 9px;
            margin: 2px 0 0 0;
            color: #444;
        }

        .label-type {
            font-size: 11px;
            font-weight: bold;
            text-align: right;
            text-transform: uppercase;
            margin: 0;
            color: #444;
        }

        .destino-bar td {
            text-align: center;
            padding: 8px 10px;
            border-bottom: 1px solid #ccc;
        }

        .destino-name {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .destino-addr {
            font-size: 9px;
            margin: 3px 0 0 0;
            color: #444;
        }

        .section-head td {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #444;
            padding: 5px 8px 3px 8px;
            border-bottom: 1px solid #ccc;
        }

        .party-body td {
            padding: 6px 8px 8px 8px;
            vertical-align: top;
            border-right: 1px solid #ddd;
        }

        .party-name {
            font-size: 13px;
            font-weight: bold;
            margin: 0 0 4px 0;
            line-height: 1.2;
            color: #000;
        }

        .party-line {
            margin: 0 0 3px 0;
            font-size: 10px;
            line-height: 1.3;
            color: #333;
        }

        .party-doc {
            margin: 5px 0 0 0;
            font-size: 11px;
            font-weight: bold;
            color: #000;
        }

        .qr-cell {
            vertical-align: bottom;
            text-align: center;
            padding: 6px 4px;
            border-left: 1px solid #ddd;
            width: 48mm;
        }

        .qr-cell img {
            width: 44mm;
            height: 44mm;
        }

        .qr-code {
            margin: 4px 0 0 0;
            font-size: 12px;
            font-weight: bold;
            color: #000;
        }

        .meta td {
            border-top: 2px solid #111;
            border-right: 1px solid #ddd;
            padding: 6px 6px;
            vertical-align: top;
            width: 16.66%;
        }

        .meta-label {
            font-size: 7px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
            margin: 0 0 2px 0;
            letter-spacing: 0.3px;
        }

        .meta-value {
            font-size: 11px;
            font-weight: bold;
            margin: 0;
            color: #000;
        }

        .footer td {
            padding: 7px 10px;
            vertical-align: middle;
            border-top: 2px solid #111;
        }

        .tracking-sub {
            font-size: 7px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
            margin: 0;
        }

        .tracking-code {
            font-size: 15px;
            font-weight: bold;
            margin: 1px 0 0 0;
            color: #000;
        }

        .origin-line {
            font-size: 9px;
            color: #444;
            margin: 3px 0 0 0;
            line-height: 1.25;
        }

        .tags {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #000;
            text-align: right;
        }

        .tag-sep {
            color: #999;
            font-weight: normal;
            margin: 0 4px;
        }
    </style>
</head>

<body>
    @php
        use Illuminate\Support\Str;
        $pesoTotal = $encomienda->paquetes->sum('peso');
        $tipoEntrega = $encomienda->isHome ? 'DOMICILIO' : 'AGENCIA';
        $docDest = ($encomienda->destinatario->type_code == '6' ? 'RUC' : 'DNI') . ': ' . $encomienda->destinatario->code;
        $docRem = ($encomienda->remitente->type_code == '6' ? 'RUC' : 'DNI') . ': ' . $encomienda->remitente->code;
        try {
            $fechaEnvio = $encomienda->fecha_creacion
                ? \Carbon\Carbon::parse($encomienda->fecha_creacion)->format('d/m/Y')
                : date('d/m/Y');
        } catch (\Exception $e) {
            $fechaEnvio = date('d/m/Y');
        }
        $destAddr = Str::limit($encomienda->sucursal_destinatario->address ?? '', 80);
        $origenTexto = $encomienda->sucursal_remitente
            ? Str::limit($encomienda->sucursal_remitente->name . ($encomienda->sucursal_remitente->address ? ' — ' . $encomienda->sucursal_remitente->address : ''), 90)
            : '';
        $tags = array_filter([
            $encomienda->estado_pago,
            $tipoEntrega,
            $encomienda->isReturn ? 'RETORNO' : null,
        ]);
    @endphp

    <table class="label">
        <tr class="top-bar">
            <td colspan="4">
                <p class="brand">BRAYAN BRUSH EIRL</p>
                <p class="brand-sub">Corporación Logística</p>
            </td>
            <td colspan="2">
                <p class="label-type">Etiqueta de envío</p>
            </td>
        </tr>

        <tr class="destino-bar">
            <td colspan="6">
                <p class="destino-name">Destino: {{ strtoupper($encomienda->sucursal_destinatario->name) }}</p>
                @if ($destAddr)
                    <p class="destino-addr">{{ $destAddr }}</p>
                @endif
            </td>
        </tr>

        <tr class="section-head">
            <td colspan="2">Destinatario</td>
            <td colspan="2">Remitente</td>
            <td colspan="2" rowspan="2" class="qr-cell">
                <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR {{ $encomienda->code }}">
                <p class="qr-code">{{ $encomienda->code }}</p>
            </td>
        </tr>
        <tr class="party-body">
            <td colspan="2">
                <p class="party-name">{{ Str::limit($encomienda->destinatario->name, 40) }}</p>
                @if ($encomienda->destinatario->address)
                    <p class="party-line">{{ Str::limit($encomienda->destinatario->address, 55) }}</p>
                @endif
                @if ($encomienda->destinatario->phone)
                    <p class="party-line">Tel: {{ $encomienda->destinatario->phone }}</p>
                @endif
                <p class="party-doc">{{ $docDest }}</p>
            </td>
            <td colspan="2">
                <p class="party-name">{{ Str::limit($encomienda->remitente->name, 40) }}</p>
                @if ($encomienda->remitente->address)
                    <p class="party-line">{{ Str::limit($encomienda->remitente->address, 55) }}</p>
                @endif
                @if ($encomienda->remitente->phone)
                    <p class="party-line">Tel: {{ $encomienda->remitente->phone }}</p>
                @endif
                <p class="party-doc">{{ $docRem }}</p>
            </td>
        </tr>

        <tr class="meta">
            <td>
                <p class="meta-label">Código</p>
                <p class="meta-value">{{ $encomienda->code }}</p>
            </td>
            <td>
                <p class="meta-label">Referencia</p>
                <p class="meta-value">#{{ $encomienda->id }}</p>
            </td>
            <td>
                <p class="meta-label">Fecha</p>
                <p class="meta-value">{{ $fechaEnvio }}</p>
            </td>
            <td>
                <p class="meta-label">Bultos</p>
                <p class="meta-value">{{ $encomienda->cantidad }}</p>
            </td>
            <td>
                <p class="meta-label">Peso</p>
                <p class="meta-value">{{ $pesoTotal > 0 ? number_format($pesoTotal, 2) . ' kg' : 'N/A' }}</p>
            </td>
            <td>
                <p class="meta-label">Monto</p>
                <p class="meta-value">S/ {{ number_format($encomienda->monto, 2) }}</p>
            </td>
        </tr>

        <tr class="footer">
            <td colspan="4">
                <p class="tracking-sub">Seguimiento</p>
                <p class="tracking-code">{{ $encomienda->code }}</p>
                @if ($origenTexto)
                    <p class="origin-line"><strong>Origen:</strong> {{ $origenTexto }}</p>
                @endif
            </td>
            <td colspan="2">
                <p class="tags">
                    @foreach ($tags as $i => $tag)
                        @if ($i > 0)<span class="tag-sep">|</span>@endif
                        {{ $tag }}
                    @endforeach
                </p>
            </td>
        </tr>
    </table>
</body>

</html>
