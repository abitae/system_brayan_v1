<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Cierre de Caja</title>
    <style>
        html {
            margin: 5pt 10pt;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 12px;
            margin-bottom: 5px;
        }

        h1 {
            color: #333;
            text-align: center;
            font-size: 22px;
            margin-bottom: 15px;
        }

        h2 {
            color: #444;
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 10px;
            background-color: #f5f5f5;
            padding: 5px;
            border-left: 4px solid #333;
        }

        .info-section {
            margin-bottom: 15px;
        }

        .info-section p {
            margin: 5px 0;
        }

        .info-section span {
            font-weight: bold;
        }

        table {
            border-collapse: collapse;
            margin: 10px 0 20px 0;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tfoot th {
            background-color: #e6e6e6;
        }

        .summary-section {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .summary-total {
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
            border-top: 2px solid #333;
            padding-top: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-name">CORPORACIÓN LOGÍSTICO BRAYAN BRUHS E.I.R.L</div>
        <div class="company-info">RUC: 20568031734</div>
        <div class="company-info">PJ. LOS PEDREGALES MZA. D LOTE. 4 GRU.SECTOR 3 LOS PEDREGAL - JUNÍN - HUANCAYO - EL TAMBO</div>
    </div>

    <h1>REPORTE DE CIERRE DE CAJA</h1>

    <div class="info-section">
        <p>Fecha Apertura: <span>{{ $caja->created_at->format('d/m/Y H:i:s') }}</span></p>
        <p>Fecha Cierre: <span>{{ $caja->updated_at->format('d/m/Y H:i:s') }}</span></p>
        <p>Cajero/a: <span>{{ $caja->user->name }}</span></p>
        <p>Saldo Inicial: <span>S/ {{ number_format($caja->monto_apertura, 2) }}</span></p>
    </div>

    <!-- Tabla de Ingresos -->
    <h2>Ingresos Efectivo</h2>
    <table>
        <thead>
            <tr>
                <th width="70%">Descripción</th>
                <th width="30%">Monto (S/)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($caja->entries->whereIn('metodo_pago',['Contado']) as $entrie)
            <tr>
                <td>{{ $entrie->description }}</td>
                <td>{{ number_format($entrie->monto_entry, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" style="text-align: center; font-style: italic;">No existen registros</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Total Ingresos en Efectivo</th>
                <th>S/ {{ number_format($caja->entries->whereIn('metodo_pago',['Contado'])->sum('monto_entry'), 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <!-- Tabla de Ingresos por Transferencias -->
    <h2>Ingresos por Transferencias</h2>
    <table>
        <thead>
            <tr>
                <th width="70%">Descripción</th>
                <th width="30%">Monto (S/)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($caja->entries->whereIn('metodo_pago',['Yape','Transferencia','Deposito']) as $entrie)
            <tr>
                <td>{{ $entrie->description }}</td>
                <td>{{ number_format($entrie->monto_entry, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" style="text-align: center; font-style: italic;">No existen registros</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Total Ingresos por Transferencias</th>
                <th>S/ {{ number_format($caja->entries->whereIn('metodo_pago',['Yape','Transferencia','Deposito'])->sum('monto_entry'), 2) }}</th>
            </tr>
        </tfoot>
    </table>
    <!-- Tabla de Egresos en Efectivo -->
    <h2>Egresos Efectivo</h2>
    <table>
        <thead>
            <tr>
                <th width="70%">Descripción</th>
                <th width="30%">Monto (S/)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($caja->exits->whereIn('metodo_pago',['Contado']) as $exit)
            <tr>
                <td>{{ $exit->description }}</td>
                <td>{{ number_format($exit->monto_exit, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" style="text-align: center; font-style: italic;">No existen registros</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Total Egresos en Efectivo</th>
                <th>S/ {{ number_format($caja->exits->whereIn('metodo_pago',['Contado'])->sum('monto_exit'), 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <!-- Tabla de Egresos por Transferencias -->
    <h2>Egresos por Transferencias</h2>
    <table>
        <thead>
            <tr>
                <th width="70%">Descripción</th>
                <th width="30%">Monto (S/)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($caja->exits->whereIn('metodo_pago',['Yape','Transferencia','Deposito']) as $exit)
            <tr>
                <td>{{ $exit->description }}</td>
                <td>{{ number_format($exit->monto_exit, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" style="text-align: center; font-style: italic;">No existen registros</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Total Egresos por Transferencias</th>
                <th>S/ {{ number_format($caja->exits->whereIn('metodo_pago',['Yape','Transferencia','Deposito'])->sum('monto_exit'), 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <!-- Sección de Resumen -->
    <div class="summary-section">
        <h2>Resumen de Caja</h2>
        <div class="summary-item">
            <div>Saldo Inicial:</div>
            <div>S/ {{ number_format($caja->monto_apertura, 2) }}</div>
        </div>
        <div class="summary-item">
            <div>Total Ingresos en Efectivo:</div>
            <div>S/ {{ number_format($caja->entries->whereIn('metodo_pago',['Contado'])->sum('monto_entry'), 2) }}</div>
        </div>
        <div class="summary-item">
            <div>Total Ingresos por Transferencias:</div>
            <div>S/ {{ number_format($caja->entries->whereIn('metodo_pago',['Yape','Transferencia','Deposito'])->sum('monto_entry'), 2) }}</div>
        </div>
        <div class="summary-item">
            <div>Total Egresos en Efectivo:</div>
            <div>S/ {{ number_format($caja->exits->whereIn('metodo_pago',['Contado'])->sum('monto_exit'), 2) }}</div>
        </div>
        <div class="summary-item">
            <div>Total Egresos por Transferencias:</div>
            <div>S/ {{ number_format($caja->exits->whereIn('metodo_pago',['Yape','Transferencia','Deposito'])->sum('monto_exit'), 2) }}</div>
        </div>
        <div class="summary-total">
            <div>Saldo Final:</div>
            <div>S/ {{ number_format($caja->monto_cierre, 2) }}</div>
        </div>
    </div>
</body>

</html>