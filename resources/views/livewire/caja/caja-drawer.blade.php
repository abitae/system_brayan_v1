<x-mary-drawer wire:model="showHistory" title="Historial de cajas" subtitle="Sesiones anteriores de caja" class="w-11/12 lg:w-3/4" right with-close-button>
    @if ($cajas->isEmpty())
        <div class="flex flex-col items-center py-12 text-center text-base-content/50">
            <x-mary-icon name="o-clock" class="w-12 h-12 mb-3 opacity-40" />
            <p>No hay historial de cajas registrado.</p>
        </div>
    @else
        @php
            $row_decoration = [
                'bg-success/5' => fn (App\Models\Caja\Caja $caja) => $caja->isActive,
            ];
        @endphp

        <x-mary-table :headers="$headersHistory" :rows="$cajas" striped :row-decoration="$row_decoration"
            with-pagination per-page="perPage" :per-page-values="[10, 20, 50]">

            @scope('cell_estado', $row)
                @if ($row->isActive)
                    <x-mary-badge value="Abierta" class="badge-success badge-sm" />
                @else
                    <x-mary-badge value="Cerrada" class="badge-ghost badge-sm" />
                @endif
            @endscope

            @scope('cell_created_at', $row)
                <span class="text-sm">{{ $row->created_at->format('d/m/Y H:i') }}</span>
            @endscope

            @scope('cell_updated_at', $row)
                <span class="text-sm">{{ $row->isActive ? '—' : $row->updated_at->format('d/m/Y H:i') }}</span>
            @endscope

            @scope('cell_monto_apertura', $row)
                <span class="font-medium">S/. {{ number_format($row->monto_apertura, 2) }}</span>
            @endscope

            @scope('cell_monto_cierre', $row)
                @if ($row->isActive)
                    <span class="text-base-content/40">—</span>
                @else
                    <span class="font-medium">S/. {{ number_format($row->monto_cierre, 2) }}</span>
                @endif
            @endscope

            @scope('cell_ingresos', $row)
                <div class="text-xs space-y-0.5">
                    <div class="flex justify-between gap-4"><span class="text-base-content/50">Efectivo</span><span class="text-success font-medium">S/. {{ number_format($row->entries->where('metodo_pago', 'Efectivo')->sum('monto_entry'), 2) }}</span></div>
                    <div class="flex justify-between gap-4"><span class="text-base-content/50">Yape</span><span>S/. {{ number_format($row->entries->where('metodo_pago', 'Yape')->sum('monto_entry'), 2) }}</span></div>
                    <div class="flex justify-between gap-4"><span class="text-base-content/50">Transfer.</span><span>S/. {{ number_format($row->entries->where('metodo_pago', 'Transferencia')->sum('monto_entry'), 2) }}</span></div>
                    <div class="flex justify-between gap-4"><span class="text-base-content/50">Depósito</span><span>S/. {{ number_format($row->entries->where('metodo_pago', 'Deposito')->sum('monto_entry'), 2) }}</span></div>
                </div>
            @endscope

            @scope('cell_egresos', $row)
                <div class="text-xs space-y-0.5">
                    <div class="flex justify-between gap-4"><span class="text-base-content/50">Efectivo</span><span class="text-error font-medium">S/. {{ number_format($row->exits->where('metodo_pago', 'Efectivo')->sum('monto_exit'), 2) }}</span></div>
                    <div class="flex justify-between gap-4"><span class="text-base-content/50">Yape</span><span>S/. {{ number_format($row->exits->where('metodo_pago', 'Yape')->sum('monto_exit'), 2) }}</span></div>
                    <div class="flex justify-between gap-4"><span class="text-base-content/50">Transfer.</span><span>S/. {{ number_format($row->exits->where('metodo_pago', 'Transferencia')->sum('monto_exit'), 2) }}</span></div>
                    <div class="flex justify-between gap-4"><span class="text-base-content/50">Depósito</span><span>S/. {{ number_format($row->exits->where('metodo_pago', 'Deposito')->sum('monto_exit'), 2) }}</span></div>
                </div>
            @endscope

            @scope('cell_action', $row)
                @if (! $row->isActive)
                    <x-mary-button icon="o-printer" target="_blank" no-wire-navigate
                        link="/caja/80mm/{{ $row->id }}" class="btn-ghost btn-sm" tooltip="Imprimir ticket" />
                @endif
            @endscope
        </x-mary-table>
    @endif
</x-mary-drawer>
