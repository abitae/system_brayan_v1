<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>
            @php
                $tipes = [
                    ['id' => 'Y', 'name' => 'Año'],
                    ['id' => 'm', 'name' => 'Mes'],
                    ['id' => 'd', 'name' => 'Día'],
                ];
            @endphp
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <x-mary-datetime label="Desde" wire:model.live="date_ini" icon="o-calendar" type="datetime-local" />
                <x-mary-datetime label="Hasta" wire:model.live="date_end" icon="o-calendar" type="datetime-local" />
                <x-mary-select label="Agrupar por" wire:model.live="selectedTipe" :options="$tipes" class="w-full sm:w-40" />
            </div>
        </x-slot:menu>

        {{-- KPIs --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <x-mary-stat
                title="Total encomiendas"
                :value="number_format($statTotal)"
                icon="o-truck"
                class="bg-base-200/50 rounded-xl"
                tooltip="Encomiendas registradas en el periodo"
            />
            <x-mary-stat
                title="Monto recaudado"
                :value="'S/. ' . number_format($statMonto, 2)"
                icon="o-banknotes"
                class="bg-primary/10 rounded-xl"
                tooltip="Suma de montos en el periodo"
            />
            <x-mary-stat
                title="Entregadas"
                :value="number_format($statEntregadas)"
                icon="o-check-circle"
                class="bg-success/10 rounded-xl"
                tooltip="Encomiendas con estado ENTREGADO"
            />
            <x-mary-stat
                title="En proceso"
                :value="number_format($statEnProceso)"
                icon="o-clock"
                class="bg-warning/10 rounded-xl"
                tooltip="Pendientes de entrega o en tránsito"
            />
        </div>

        @if (!$sucursalNombre)
            <x-mary-alert title="Sin sucursal asignada" description="Tu usuario no tiene una sucursal. Los gráficos no mostrarán datos." icon="o-exclamation-triangle" class="alert-warning mb-6" />
        @endif

        {{-- Gráficos principales --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
            <div class="bg-base-100 border border-base-300 rounded-xl shadow-sm p-5">
                <div class="flex items-center gap-2 mb-4">
                    <x-mary-icon name="o-presentation-chart-line" class="w-6 h-6 text-primary" />
                    <div>
                        <p class="font-semibold">Monto recaudado</p>
                        <p class="text-xs text-base-content/60">Tendencia según el periodo seleccionado</p>
                    </div>
                </div>
                <div class="h-72" wire:key="chart-line-{{ $selectedTipe }}-{{ $date_ini }}-{{ $date_end }}">
                    <x-mary-chart wire:model="myLine" />
                </div>
            </div>

            <div class="bg-base-100 border border-base-300 rounded-xl shadow-sm p-5">
                <div class="flex items-center gap-2 mb-4">
                    <x-mary-icon name="o-credit-card" class="w-6 h-6 text-secondary" />
                    <div>
                        <p class="font-semibold">Método de pago</p>
                        <p class="text-xs text-base-content/60">Desglose por canal de cobro</p>
                    </div>
                </div>
                <div class="h-72" wire:key="chart-metodo-{{ $selectedTipe }}-{{ $date_ini }}-{{ $date_end }}">
                    <x-mary-chart wire:model="myBarTipoCobro" />
                </div>
            </div>
        </div>

        {{-- Gráficos secundarios --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div class="bg-base-100 border border-base-300 rounded-xl shadow-sm p-5">
                <div class="flex items-center gap-2 mb-4">
                    <x-mary-icon name="o-chart-bar" class="w-6 h-6 text-accent" />
                    <div>
                        <p class="font-semibold">Encomiendas por estado</p>
                        <p class="text-xs text-base-content/60">Flujo operativo de la sucursal</p>
                    </div>
                </div>
                <div class="h-72" wire:key="chart-estado-{{ $selectedTipe }}-{{ $date_ini }}-{{ $date_end }}">
                    <x-mary-chart wire:model="myBar" />
                </div>
            </div>

            <div class="bg-base-100 border border-base-300 rounded-xl shadow-sm p-5">
                <div class="flex items-center gap-2 mb-4">
                    <x-mary-icon name="o-chart-pie" class="w-6 h-6 text-info" />
                    <div>
                        <p class="font-semibold">Contado vs crédito</p>
                        <p class="text-xs text-base-content/60">Proporción de tipo de cobro</p>
                    </div>
                </div>
                <div class="h-72 flex items-center justify-center" wire:key="chart-pie-{{ $selectedTipe }}-{{ $date_ini }}-{{ $date_end }}">
                    <x-mary-chart wire:model="myPie" />
                </div>
            </div>
        </div>
    </x-mary-card>
</div>
