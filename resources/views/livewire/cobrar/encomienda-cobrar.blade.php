<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" shadow separator progress-indicator>
        <x-slot:menu>
            <x-mary-button icon="o-document-arrow-down" label="Descargar Excel" wire:click="excelGenerate" no-wire-navigate
                spinner class="text-white bg-orange-500 hover:bg-orange-600 transition-colors duration-200" />
        </x-slot:menu>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-2 p-2 shadow-xl">
            <div>
                <x-mary-input type='search' label="Buscar encomienda" icon="o-funnel" wire:model.live="search"
                    placeholder="Buscar encomienda" />
            </div>
            <div>
                <x-mary-select label="Sucursal" icon="s-inbox-stack" :options="$sucursals"
                    wire:model.live="filtroSucursal" />
            </div>
            <div>
                <x-mary-datetime label="Desde" wire:model.live="filtroFechaInicio" icon="o-calendar"
                    type="datetime-local" />
            </div>
            <div>
                <x-mary-datetime label="Hasta" wire:model.live="filtroFechaFin" icon="o-calendar"
                    type="datetime-local" />
            </div>
            <div>
                <x-mary-select label="Estado crédito" icon="s-inbox-stack" :options="$estadosCredito"
                    wire:model.live="FiltroEstadoCredito" placeholder="Todos" />
            </div>
            <div>
                <x-mary-select label="Estado encomienda" icon="s-inbox-stack" :options="$estados"
                    wire:model.live="FiltroEstadoEncomienda" placeholder="Todos" />
            </div>

        </div>
        <x-mary-menu-separator />
        <div class="grid grid-cols-4 gap-1 shadow-2xl">
            <div class="grid col-span-4">
                <x-mary-card shadow separator progress-indicator>
                    @php
                        $headers = [
                            ['key' => 'id', 'label' => '#', 'class' => 'bg-green-500 w-1 text-white'],
                            ['key' => 'code', 'label' => 'Codigo', 'class' => ''],
                            ['key' => 'remitente', 'label' => 'Remitente', 'class' => ''],
                            ['key' => 'destinatario', 'label' => 'Destinatario', 'class' => ''],
                            ['key' => 'monto', 'label' => 'Monto', 'class' => ''],
                            ['key' => 'estado', 'label' => 'Estado Encomienda', 'class' => ''],
                            ['key' => 'fecha', 'label' => 'Fechas', 'class' => ''],
                            ['key' => 'comprobante', 'label' => 'Comprobante', 'class' => ''],
                            ['key' => 'menu', 'label' => 'Menu', 'class' => ''],
                        ];
                    @endphp
                    <x-mary-table :headers="$headers" :rows="$encomiendas" striped with-pagination per-page="perPage"
                        :per-page-values="[5, 20, 10, 50]">
                        @scope('cell_estado', $stuff)
                            <div class="flex items-center">
                                <div class="ml-2">
                                    <p class="font-medium">{{ $stuff->estado_encomienda }}</p>
                                    <p class="font-medium animate-bounce">{{ $stuff->estado_credito }}</p>
                                    <p class="font-medium">{{ $stuff->tipo_pago }}</p>
                                </div>
                            </div>
                        @endscope
                        @scope('cell_remitente', $stuff)
                            <div class="flex items-center">
                                <div class="ml-2">
                                    <p class="font-medium">{{ $stuff->remitente->name }}</p>
                                    <p>{{ $stuff->remitente->type_code == 1 ? 'DNI:' : 'RUC:' }}
                                        {{ $stuff->remitente->code }}
                                    </p>
                                </div>
                            </div>
                        @endscope
                        @scope('cell_destinatario', $stuff)
                            <div class="flex items-center">
                                <div class="ml-2">
                                    <p class="font-medium">{{ $stuff->destinatario->name }}</p>
                                    <p>{{ $stuff->destinatario->type_code == 1 ? 'DNI:' : 'RUC:' }}
                                        {{ $stuff->destinatario->code }}
                                    </p>
                                </div>
                            </div>
                        @endscope
                        @scope('cell_fecha', $stuff)
                            <div class="flex items-center">
                                <div class="ml-2">
                                    Creado:<p class="font-medium">{{ $stuff->created_at->format('d-m-Y H:i') }}</p>
                                    Actualizado:<p class="font-medium">{{ $stuff->updated_at->format('d-m-Y H:i') }}</p>
                                </div>
                            </div>
                        @endscope
                        @scope('cell_comprobante', $stuff)
                            <div class="grid grid-cols-1 gap-1">
                                <div>
                                    @if ($stuff->invoice)
                                        <x-mary-button label='Recibo' icon="o-printer" target="_blank" no-wire-navigate
                                            link="/invoice/80mm/{{ $stuff->invoice->id }}" spinner
                                            class="w-full h-full text-white bg-purple-500 btn-xs" />
                                    @endif
                                </div>
                                <div>
                                    @if ($stuff->ticket)
                                        <x-mary-button label='Ticket' icon="o-printer" target="_blank" no-wire-navigate
                                            link="/ticket/80mm/{{ $stuff->ticket->id }}" spinner
                                            class="w-full h-full text-white bg-cyan-500 btn-xs" />
                                    @endif
                                </div>
                                <div>
                                    @if ($stuff->despatche)
                                        <x-mary-button label='Guia T' icon="o-printer" target="_blank" no-wire-navigate
                                            link="/despache/80mm/{{ $stuff->despatche->id }}" spinner
                                            class="w-full h-full text-white bg-green-500 btn-xs" />
                                    @endif
                                </div>
                            </div>
                        @endscope
                        @scope('cell_menu', $stuff)
                            <div class="flex items-center">
                                @if ($stuff->estado_credito === 'Pendiente')
                                    <x-mary-button wire:click='modalCobrarOpen({{ $stuff->id }})' label="Cobrar"
                                        class="bg-orange-500 hover:bg-orange-700 text-white" spinner />
                                @else
                                    <x-mary-badge value="Cobrado" class="bg-green-500 text-white" />
                                @endif
                            </div>
                        @endscope
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>
    </x-mary-card>
    @include('livewire.package.deliver-cobrar-modal')
</div>
