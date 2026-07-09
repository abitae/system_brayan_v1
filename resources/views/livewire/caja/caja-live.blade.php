<div>
    <x-mary-card title="{{ $title }}" subtitle="Control de efectivo y movimientos del día — {{ $fechaActual }}" shadow separator progress-indicator>
        <x-slot:menu>
            <x-mary-button wire:click="openModal" icon="{{ $openCaja ? 'o-lock-closed' : 'o-lock-open' }}"
                label="{{ $openCaja ? 'Cerrar caja' : 'Abrir caja' }}"
                class="{{ $openCaja ? 'btn-error' : 'btn-success' }} text-white" responsive />
            <x-mary-button @click="$wire.showHistory = true" icon="o-clock" label="Historial"
                class="btn-primary text-white" responsive />
        </x-slot:menu>

        @if ($openCaja && $caja)
            {{-- Estado de sesión --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6 p-4 rounded-xl bg-success/10 border border-success/20">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-success text-success-content">
                        <x-mary-icon name="o-check-circle" class="w-6 h-6" />
                    </div>
                    <div>
                        <p class="font-semibold text-success">Caja abierta</p>
                        <p class="text-sm text-base-content/70">
                            Desde {{ $caja->created_at->format('d/m/Y H:i') }}
                            · {{ $stats['movimientos'] ?? 0 }} movimientos
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs uppercase tracking-wide text-base-content/50">Saldo efectivo actual</p>
                    <p class="text-2xl font-bold text-success">S/. {{ number_format($stats['saldo_efectivo'] ?? 0, 2) }}</p>
                </div>
            </div>

            {{-- KPIs principales --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <x-mary-stat title="Apertura" :value="'S/. ' . number_format($stats['apertura'] ?? 0, 2)"
                    icon="o-banknotes" class="bg-base-200/50 rounded-xl" />
                <x-mary-stat title="Ingresos" :value="'S/. ' . number_format($stats['ingresos_total'] ?? 0, 2)"
                    icon="o-arrow-trending-up" class="bg-success/10 rounded-xl" tooltip="Total de entradas" />
                <x-mary-stat title="Egresos" :value="'S/. ' . number_format($stats['egresos_total'] ?? 0, 2)"
                    icon="o-arrow-trending-down" class="bg-error/10 rounded-xl" tooltip="Total de salidas" />
                <x-mary-stat title="Saldo efectivo" :value="'S/. ' . number_format($stats['saldo_efectivo'] ?? 0, 2)"
                    icon="o-calculator" class="bg-primary/10 rounded-xl" tooltip="Apertura + efectivo in − efectivo out" />
            </div>

            {{-- Desglose por método --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                <div class="p-3 rounded-lg border border-base-300/60 bg-base-100">
                    <p class="text-[10px] uppercase text-base-content/45 font-semibold">Ing. efectivo</p>
                    <p class="text-lg font-semibold text-success">S/. {{ number_format($stats['ingresos_efectivo'] ?? 0, 2) }}</p>
                </div>
                <div class="p-3 rounded-lg border border-base-300/60 bg-base-100">
                    <p class="text-[10px] uppercase text-base-content/45 font-semibold">Ing. otros medios</p>
                    <p class="text-lg font-semibold text-info">S/. {{ number_format($stats['ingresos_otros'] ?? 0, 2) }}</p>
                </div>
                <div class="p-3 rounded-lg border border-base-300/60 bg-base-100">
                    <p class="text-[10px] uppercase text-base-content/45 font-semibold">Egr. efectivo</p>
                    <p class="text-lg font-semibold text-error">S/. {{ number_format($stats['egresos_efectivo'] ?? 0, 2) }}</p>
                </div>
                <div class="p-3 rounded-lg border border-base-300/60 bg-base-100">
                    <p class="text-[10px] uppercase text-base-content/45 font-semibold">Egr. otros medios</p>
                    <p class="text-lg font-semibold text-warning">S/. {{ number_format($stats['egresos_otros'] ?? 0, 2) }}</p>
                </div>
            </div>

            {{-- Movimientos --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <div class="rounded-xl border border-base-300/60 bg-base-100 overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3 bg-success/5 border-b border-base-300/50">
                        <div class="flex items-center gap-2">
                            <x-mary-icon name="o-arrow-down-circle" class="w-5 h-5 text-success" />
                            <div>
                                <p class="font-semibold">Ingresos</p>
                                <p class="text-xs text-base-content/50">{{ $caja->entries->count() }} registros</p>
                            </div>
                        </div>
                        <x-mary-button @click="$wire.modalEntry = true" icon="o-plus" label="Nuevo"
                            class="btn-success btn-sm text-white" />
                    </div>
                    <div class="p-2">
                        @if ($caja->entries->isEmpty())
                            <p class="text-center text-sm text-base-content/50 py-8">No hay ingresos registrados</p>
                        @else
                            <x-mary-table :headers="$headersIngreso" :rows="$caja->entries->sortByDesc('created_at')" striped>
                                @scope('cell_tipo_entry', $row)
                                    <x-mary-badge :value="$row->tipo_entry" class="badge-success badge-outline badge-sm" />
                                @endscope
                                @scope('cell_metodo_pago', $row)
                                    <x-mary-badge :value="$row->metodo_pago" class="badge-ghost badge-sm" />
                                @endscope
                                @scope('cell_monto_entry', $row)
                                    <span class="font-semibold text-success">S/. {{ number_format($row->monto_entry, 2) }}</span>
                                @endscope
                            </x-mary-table>
                        @endif
                    </div>
                </div>

                <div class="rounded-xl border border-base-300/60 bg-base-100 overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3 bg-error/5 border-b border-base-300/50">
                        <div class="flex items-center gap-2">
                            <x-mary-icon name="o-arrow-up-circle" class="w-5 h-5 text-error" />
                            <div>
                                <p class="font-semibold">Egresos</p>
                                <p class="text-xs text-base-content/50">{{ $caja->exits->count() }} registros</p>
                            </div>
                        </div>
                        <x-mary-button @click="$wire.modalExit = true" icon="o-minus" label="Nuevo"
                            class="btn-error btn-sm text-white" />
                    </div>
                    <div class="p-2">
                        @if ($caja->exits->isEmpty())
                            <p class="text-center text-sm text-base-content/50 py-8">No hay egresos registrados</p>
                        @else
                            <x-mary-table :headers="$headersEgreso" :rows="$caja->exits->sortByDesc('created_at')" striped>
                                @scope('cell_tipo_exit', $row)
                                    <x-mary-badge :value="$row->tipo_exit" class="badge-error badge-outline badge-sm" />
                                @endscope
                                @scope('cell_metodo_pago', $row)
                                    <x-mary-badge :value="$row->metodo_pago" class="badge-ghost badge-sm" />
                                @endscope
                                @scope('cell_monto_exit', $row)
                                    <span class="font-semibold text-error">S/. {{ number_format($row->monto_exit, 2) }}</span>
                                @endscope
                            </x-mary-table>
                        @endif
                    </div>
                </div>
            </div>
        @else
            {{-- Sin caja abierta --}}
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-base-200 mb-4">
                    <x-mary-icon name="o-lock-closed" class="w-10 h-10 text-base-content/30" />
                </div>
                <h3 class="text-lg font-semibold mb-2">No hay caja abierta</h3>
                <p class="text-sm text-base-content/60 max-w-md mb-6">
                    Abre la caja con el monto inicial en efectivo para registrar ingresos, egresos y cerrar el arqueo al final del turno.
                </p>
                <x-mary-button wire:click="openModal" icon="o-lock-open" label="Abrir caja"
                    class="btn-success text-white" />
            </div>
        @endif
    </x-mary-card>

    @include('livewire.caja.caja-modal')
    @include('livewire.caja.caja-drawer')
</div>
