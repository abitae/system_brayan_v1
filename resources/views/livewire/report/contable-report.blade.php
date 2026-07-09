<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" shadow separator progress-indicator>
        <x-slot:menu>
            <x-mary-button icon="o-document-arrow-down" label="Descargar Excel" wire:click="excelGenerate"
                no-wire-navigate spinner
                class="text-white bg-orange-500 hover:bg-orange-600 transition-colors duration-200" />
        </x-slot:menu>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <x-mary-stat title="Documentos" :value="number_format($totalDocumentos)" icon="o-document-text"
                class="bg-base-200/50 rounded-xl" />
            <x-mary-stat title="Base imponible neta" :value="'S/. ' . number_format($totalBase, 2)" icon="o-calculator"
                class="bg-primary/10 rounded-xl" />
            <x-mary-stat title="IGV neto" :value="'S/. ' . number_format($totalIgv, 2)" icon="o-receipt-percent"
                class="bg-secondary/10 rounded-xl" />
            <x-mary-stat title="Total ventas neto" :value="'S/. ' . number_format($totalVentas, 2)" icon="o-banknotes"
                class="bg-success/10 rounded-xl" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-2 p-2 shadow-xl mb-4">
            <x-mary-input type="search" label="Buscar" icon="o-funnel" wire:model.live="search"
                placeholder="Serie, cliente, RUC/DNI" />
            <x-mary-datetime label="Desde" wire:model.live="filtroFechaInicio" icon="o-calendar"
                type="datetime-local" />
            <x-mary-datetime label="Hasta" wire:model.live="filtroFechaFin" icon="o-calendar"
                type="datetime-local" />
            <x-mary-select label="Sucursal" icon="o-building-storefront" :options="$sucursals"
                wire:model.live="filtroSucursal" :disabled="$soloSucursalUsuario" />
            <x-mary-select label="Tipo documento" icon="o-document" :options="$tiposDocumento"
                wire:model.live="filtroTipoDoc" />
            <x-mary-select label="Estado SUNAT" icon="o-shield-check" :options="$estadosSunat"
                wire:model.live="filtroEstadoSunat" />
        </div>

        @if ($soloSucursalUsuario)
            <x-mary-alert icon="o-information-circle" class="alert-info mb-4"
                title="Vista por sucursal"
                description="Mostrando comprobantes de tu sucursal asignada." />
        @endif

        <x-mary-card shadow separator progress-indicator>
            @php
                $headers = [
                    ['key' => 'fecha_emision', 'label' => 'Fecha', 'class' => ''],
                    ['key' => 'tipo_label', 'label' => 'Tipo', 'class' => ''],
                    ['key' => 'numero', 'label' => 'Número', 'class' => ''],
                    ['key' => 'cliente', 'label' => 'Cliente', 'class' => ''],
                    ['key' => 'montos', 'label' => 'Montos (S/.)', 'class' => ''],
                    ['key' => 'estado_sunat', 'label' => 'SUNAT', 'class' => ''],
                    ['key' => 'acciones', 'label' => 'PDF', 'class' => 'w-1'],
                ];
            @endphp

            <x-mary-table :headers="$headers" :rows="$comprobantes" striped with-pagination per-page="perPage"
                :per-page-values="[10, 15, 25, 50, 100]">
                @scope('cell_tipo_label', $row)
                    <x-mary-badge :value="$row['tipo_label']"
                        class="{{ match ($row['tipo_doc']) {
                            '01' => 'badge-primary',
                            '03' => 'badge-secondary',
                            '07' => 'badge-warning',
                            '08' => 'badge-accent',
                            default => 'badge-ghost',
                        } }}" />
                    @if ($row['sucursal'])
                        <div class="text-xs opacity-70 mt-1">{{ $row['sucursal'] }}</div>
                    @endif
                @endscope

                @scope('cell_numero', $row)
                    <span class="font-mono font-medium">{{ $row['numero'] }}</span>
                    @if ($row['encomienda_code'])
                        <div class="text-xs opacity-70">Enc: {{ $row['encomienda_code'] }}</div>
                    @endif
                @endscope

                @scope('cell_cliente', $row)
                    <div class="font-medium">{{ $row['cliente_nombre'] }}</div>
                    <div class="text-xs opacity-70">{{ $row['cliente_doc'] }}</div>
                    <div class="text-xs">{{ $row['forma_pago'] }}</div>
                @endscope

                @scope('cell_montos', $row)
                    @php
                        $factor = $row['factor'];
                        $sign = $factor < 0 ? '-' : '';
                    @endphp
                    <div class="text-xs">Base: {{ $sign }}{{ number_format($row['base'], 2) }}</div>
                    <div class="text-xs">IGV: {{ $sign }}{{ number_format($row['igv'], 2) }}</div>
                    <div class="font-semibold">Total: {{ $sign }}{{ number_format($row['total'], 2) }}</div>
                @endscope

                @scope('cell_estado_sunat', $row)
                    <x-mary-badge :value="$row['estado_sunat']"
                        class="{{ match ($row['estado_sunat']) {
                            'Aceptado' => 'badge-success',
                            'Anulado' => 'badge-neutral',
                            'Error' => 'badge-error',
                            'Pendiente' => 'badge-warning',
                            default => 'badge-info',
                        } }}" />
                @endscope

                @scope('cell_acciones', $row)
                    <x-mary-button icon="o-document-chart-bar" target="_blank" no-wire-navigate
                        link="{{ $row['pdf_url'] }}" spinner class="btn-xs btn-primary" />
                    @if (
                        $row['origen'] === 'invoice'
                        && $row['estado_sunat'] === 'Aceptado'
                        && ($row['estado'] ?? null) !== 'ANULADO'
                        && in_array($row['tipo_doc'], ['01', '03'], true)
                    )
                        <x-mary-button icon="o-trash" wire:click="confirmarAnulacion({{ $row['id'] }})" spinner
                            class="btn-xs btn-error" />
                    @endif
                @endscope
            </x-mary-table>
        </x-mary-card>
    </x-mary-card>

    <x-mary-modal wire:model="modalAnular" title="Anular comprobante" separator>
        <p class="mb-4 text-sm">
            ¿Confirma la anulación del comprobante <strong>{{ $numeroAnular }}</strong>?
            Esta acción se comunicará a SUNAT y no se puede deshacer.
        </p>
        <x-mary-textarea label="Motivo de anulación" wire:model="motivoBaja" rows="3"
            hint="Mínimo 4 caracteres" />
        <x-slot:actions>
            <x-mary-button label="Cancelar" @click="$wire.modalAnular = false" class="btn-ghost" />
            <x-mary-button label="Confirmar anulación" wire:click="ejecutarAnulacion" spinner
                class="btn-error text-white" />
        </x-slot:actions>
    </x-mary-modal>
</div>
