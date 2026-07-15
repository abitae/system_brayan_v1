<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" shadow separator progress-indicator>
        <x-slot:menu>
            <x-mary-button icon="o-document-arrow-down" label="Descargar Excel" wire:click="excelGenerate"
                no-wire-navigate spinner
                class="text-white bg-orange-500 hover:bg-orange-600 transition-colors duration-200" />
        </x-slot:menu>

        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
            <x-mary-stat title="Periodo" :value="$periodoInicio->format('m/Y')" icon="o-calendar"
                class="bg-base-200/50 rounded-xl" />
            <x-mary-stat title="Documentos" :value="number_format($totalDocumentos)" icon="o-document-text"
                class="bg-base-200/50 rounded-xl" />
            <x-mary-stat title="Base gravada" :value="'S/. ' . number_format($totalBase, 2)" icon="o-calculator"
                class="bg-primary/10 rounded-xl" />
            <x-mary-stat title="IGV" :value="'S/. ' . number_format($totalIgv, 2)" icon="o-receipt-percent"
                class="bg-secondary/10 rounded-xl" />
            <x-mary-stat title="Total" :value="'S/. ' . number_format($totalVentas, 2)" icon="o-banknotes"
                class="bg-success/10 rounded-xl" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 p-2 shadow-xl mb-4">
            <x-mary-input type="month" label="Mes" icon="o-calendar" wire:model.live="filtroMes" />
            <x-mary-select label="Origen" icon="o-funnel" :options="$origenes" wire:model.live="filtroOrigen" />
            <x-mary-select label="Sucursal" icon="o-building-storefront" :options="$sucursals"
                wire:model.live="filtroSucursal" :disabled="$soloSucursalUsuario" />
        </div>

        @if ($soloSucursalUsuario)
            <x-mary-alert icon="o-information-circle" class="alert-info mb-4" title="Vista por sucursal"
                description="Mostrando comprobantes de tu sucursal asignada." />
        @endif

        @php
            $headers = [
                ['key' => 'fecha_emision', 'label' => 'Fecha', 'class' => ''],
                ['key' => 'comprobante', 'label' => 'Comprobante', 'class' => ''],
                ['key' => 'cliente', 'label' => 'Cliente', 'class' => ''],
                ['key' => 'articulo', 'label' => 'Artículo', 'class' => ''],
                ['key' => 'montos', 'label' => 'Montos', 'class' => ''],
                ['key' => 'estado', 'label' => 'SUNAT', 'class' => ''],
            ];
        @endphp

        <x-mary-table :headers="$headers" :rows="collect($rows)->take(50)" striped>
            @scope('cell_comprobante', $row)
                <div class="font-mono font-medium">{{ $row['serie'] }}-{{ $row['numero'] }}</div>
                <div class="text-xs opacity-70">Tipo {{ $row['tipo_doc'] }}</div>
            @endscope

            @scope('cell_cliente', $row)
                <div class="font-medium">{{ $row['cliente_nombre'] }}</div>
                <div class="text-xs opacity-70">{{ $row['cliente_numero'] }}</div>
            @endscope

            @scope('cell_articulo', $row)
                <div>{{ $row['articulo'] ?: '-' }}</div>
                <div class="text-xs opacity-70">Cant. {{ number_format((float) $row['cantidad'], 3) }}</div>
            @endscope

            @scope('cell_montos', $row)
                <div class="text-xs">Base: {{ number_format((float) $row['base_gravada'], 2) }}</div>
                <div class="text-xs">IGV: {{ number_format((float) $row['igv'], 2) }}</div>
                <div class="font-semibold">Total: {{ number_format((float) $row['importe_total'], 2) }}</div>
            @endscope

            @scope('cell_estado', $row)
                <x-mary-badge :value="$row['descripcion_estado_sunat']"
                    class="{{ $row['codigo_estado_sunat'] === '0' ? 'badge-success' : 'badge-warning' }}" />
                <div class="text-xs opacity-70">{{ $row['forma_pago'] }}</div>
            @endscope
        </x-mary-table>

        @if ($totalLineas > 50)
            <p class="text-xs opacity-70 mt-2">
                Mostrando 50 de {{ number_format($totalLineas) }} líneas. El Excel incluirá todo el mes filtrado.
            </p>
        @endif
    </x-mary-card>
</div>
