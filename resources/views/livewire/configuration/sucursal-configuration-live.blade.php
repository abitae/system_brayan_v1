<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <div class="grid grid-col-1">
            <div>
                <x-mary-form wire:submit.prevent="save" class="space-y-4">
                    <div class="grid grid-cols-1 gap-1 md:grid-cols-4">
                        <div>
                            <x-mary-select label="SUCURSAL DESTINO" icon="o-home-modern" :options="$sucursales"
                                wire:model.live="sucursal_destino_id" placeholder="NO SELECT" placeholder-value="0" />
                        </div>
                        <div>
                            <x-mary-select label="CHOFERES" icon="o-user-circle" :options="$transportistas"
                                wire:model.live="transportista_id" placeholder="NO SELECT" placeholder-value="0" />
                        </div>
                        <div>
                            <x-mary-select label="VEHICULO" icon="m-truck" :options="$vehiculos"
                                wire:model.live="vehiculo_id" placeholder="NO SELECT" placeholder-value="0" />
                        </div>
                        <div class="flex items-end">
                            <x-mary-button label="Actualizar" class="btn-primary w-full" type="submit" spinner="save" />
                        </div>
                    </div>
                </x-mary-form>
                <div class="grid grid-cols-1">
                    <div>
                        @php
                            $headers = [
                                ['key' => 'destino', 'label' => 'DESTINO'],
                                ['key' => 'transportista', 'label' => 'TRANSPORTISTA'],
                                ['key' => 'vehiculo', 'label' => 'VEHICULO'],
                            ];
                        @endphp
                        <x-mary-table :headers="$headers" :rows="$configurations" striped class="mt-6">
                            @scope('cell_destino', $config)
                                <p>{{ $config->destino->name }}</p>
                            @endscope
                            @scope('cell_transportista', $config)
                                <x-mary-badge :value="$config->transportista->name" class="text-xs" />
                            @endscope
                            @scope('cell_vehiculo', $config)
                                <x-mary-badge :value="$config->vehiculo->name" class="text-xs badge-primary" />
                                <x-mary-badge :value="$config->vehiculo->modelo" class="text-xs bg-cyan-500" />
                            @endscope
                        </x-mary-table>
                    </div>

                </div>
            </div>
        </div>
    </x-mary-card>
</div>
