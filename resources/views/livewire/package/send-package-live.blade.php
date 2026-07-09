<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator
        progress-indicator>
        <x-slot:menu>
            <x-mary-button wire:click='openModal' responsive icon="s-truck" label="Enviar paquetes"
                class="text-white bg-green-500 w-full" />
        </x-slot:menu>
        <div class="grid grid-cols-1 md:grid-cols-6 gap-2 p-2 shadow-md">
            <div>
                <x-mary-input type='search' label="Buscar encomienda" icon="o-funnel" wire:model.live="search"
                    placeholder="Buscar encomienda" />
            </div>
            <div>
                <x-mary-select label="Destino" icon="s-inbox-stack" :options="$sucursals" wire:model.live="sucursal_dest_id"
                    class="w-full" />
            </div>
            <div>
                <x-mary-datetime label="Desde" wire:model.live="date_ini" icon="o-calendar" type="datetime-local" />
            </div>
            <div>
                <x-mary-datetime label="Hasta" wire:model.live="date_fin" icon="o-calendar" type="datetime-local" />
            </div>
            <div class="flex items-center">
                <x-mary-toggle label="Activos" wire:model.live="isActive" class="toggle-danger" right tight />
            </div>
        </div>
        <x-mary-menu-separator />
        <div class="grid grid-cols-1 gap-1 shadow-xl">
            <div class="col-span-1">
                <x-mary-card shadow separator class="overflow-x-auto">
                    @php
                        $headers = [
                            ['key' => 'actions', 'label' => 'Acción', 'class' => 'w-1/3'],
                            ['key' => 'remitente', 'label' => 'Remitente', 'class' => 'w-1/3'],
                            ['key' => 'destinatario', 'label' => 'Destinatario', 'class' => 'w-1/3'],
                        ];
                        $row_decoration = [
                            'bg-red-400' => fn(App\Models\package\Encomienda $encomienda) => !$encomienda->isActive,
                        ];
                    @endphp
                    <x-mary-table wire:model="selected" selectable :headers="$headers" :rows="$encomiendas" with-pagination
                        per-page="perPage" :row-decoration="$row_decoration" :per-page-values="[100, 150, 200]">
                        <x-slot:empty>
                            <x-mary-icon name="o-cube" label="No se encontraron registros." />
                        </x-slot:empty>
                        @scope('cell_remitente', $stuff)
                            <div class="grid grid-cols-1 grid-rows-auto gap-1 text-xs">
                                <div>
                                    <x-mary-badge :value="$stuff->remitente->code" class="text-white bg-purple-500 w-full sm:w-auto" />
                                </div>
                                <div class="font-medium">
                                    {{ strtoupper($stuff->remitente->name) }}
                                </div>
                                <div>
                                    {{ strtoupper($stuff->sucursal_remitente->name) }}
                                </div>
                                <div>
                                    {{ strtoupper($stuff->created_at->format('d/m/Y')) }}
                                </div>
                                <div class="truncate">
                                    {{ $stuff->sucursal_remitente->address }}
                                </div>
                            </div>
                        @endscope
                        @scope('cell_destinatario', $stuff)
                            <div class="grid grid-cols-1 grid-rows-auto gap-1 text-xs">
                                <div>
                                    <x-mary-badge :value="$stuff->destinatario->code" class="text-white bg-purple-500 w-full sm:w-auto" />
                                </div>
                                <div class="font-medium">
                                    {{ strtoupper($stuff->destinatario->name) }}
                                </div>
                                <div>
                                    {{ strtoupper($stuff->sucursal_destinatario->name) }}
                                </div>
                                <div>
                                    {{ strtoupper($stuff->created_at->format('d/m/Y')) }}
                                </div>
                                <div class="truncate">
                                    @if ($stuff->isHome)
                                        <span class="font-semibold">REPARTO DOMICILIO</span>
                                        <br>
                                        {{ $stuff->destinatario->address }}
                                    @else
                                        <span class="font-semibold">ENTREGA SUCURSAL</span>
                                        <br>
                                        {{ $stuff->sucursal_destinatario->address }}
                                    @endif
                                </div>
                            </div>
                        @endscope
                        @scope('cell_actions', $stuff)
                            <div class="grid grid-cols-2 gap-1 p-1">
                                <div class="col-span-2 mb-1">
                                    <x-mary-badge :value="strtoupper($stuff->code)"
                                        class="w-full text-white text-lg sm:text-xl {{ $stuff->estado_pago == 'CONTRA ENTREGA' ? 'bg-red-500' : 'bg-green-500' }}" />
                                </div>
                                <div class="col-span-2 mb-1">
                                    <div class="flex gap-1">
                                        <x-mary-badge :value="$stuff->tipo_comprobante"
                                            class="text-xs {{ $stuff->tipo_comprobante === 'TICKET' ? 'bg-blue-500' : 'bg-gray-500' }}" />
                                        @if ($stuff->tipo_comprobante === 'TICKET' && in_array($stuff->estado_encomienda, ['REGISTRADO', 'RETORNADO']))
                                            <x-mary-badge value="EDITABLE" class="text-xs bg-green-500" />
                                        @else
                                            <x-mary-badge value="NO EDITABLE" class="text-xs bg-red-500" />
                                        @endif
                                    </div>
                                </div>
                                <div class="col-span-1">
                                    <x-mary-button label='Detalle' icon="s-bars-3"
                                        wire:click="detailEncomienda({{ $stuff->id }})" spinner
                                        class="w-full text-white btn-xs bg-cyan-500" />
                                </div>
                                <div class="col-span-1">
                                    @if ($stuff->invoice)
                                        <x-mary-button label='Recibo' icon="o-printer" target="_blank" no-wire-navigate
                                            link="/invoice/80mm/{{ $stuff->invoice->id }}" spinner
                                            class="w-full text-white bg-purple-500 btn-xs" />
                                    @endif
                                </div>
                                <div class="col-span-1 mt-1">
                                    @if ($stuff->ticket)
                                        <x-mary-button label='Ticket' icon="o-printer" target="_blank" no-wire-navigate
                                            link="/ticket/80mm/{{ $stuff->ticket->id }}" spinner
                                            class="w-full text-white bg-cyan-500 btn-xs" />
                                    @endif
                                </div>
                                <div class="col-span-1 mt-1">
                                    @if ($stuff->despatche)
                                        <x-mary-button label='Guia T' icon="o-printer" target="_blank" no-wire-navigate
                                            link="/despache/80mm/{{ $stuff->despatche->id }}" spinner
                                            class="w-full text-white bg-green-500 btn-xs" />
                                    @endif
                                </div>

                                <div class="col-span-1 mt-1">
                                    <x-mary-button label='Anular' icon="o-no-symbol"
                                        wire:click="enableEncomienda({{ $stuff->id }})" spinner
                                        wire:confirm.prompt="Esta seguro?\n\nEscriba {{ $stuff->remitente->code }} para confirmar|{{ $stuff->remitente->code }}"
                                        class="w-full text-white bg-red-500 btn-xs" />
                                </div>
                                <div class="col-span-1 mt-1">
                                    @if ($stuff->tipo_comprobante === 'TICKET' && in_array($stuff->estado_encomienda, ['REGISTRADO', 'RETORNADO']))
                                        <x-mary-button label='Editar' icon="o-pencil-square"
                                            wire:click="editEncomienda({{ $stuff->id }})" spinner
                                            class="w-full text-white bg-orange-500 btn-xs" />
                                    @else
                                        <x-mary-button label='Editar' icon="o-pencil-square"
                                            class="w-full text-white bg-gray-400 btn-xs cursor-not-allowed" disabled
                                            tooltip="{{ $stuff->tipo_comprobante !== 'TICKET' ? 'Solo se pueden editar encomiendas con TICKET' : 'Solo se pueden editar encomiendas en estado REGISTRADO o RETORNADO' }}" />
                                    @endif
                                </div>
                                <div class="col-span-2 mt-1">
                                    <x-mary-badge :value="strtoupper($stuff->estado_pago)"
                                        class="w-full text-white text-xs {{ $stuff->estado_pago == 'CONTRA ENTREGA' ? 'bg-red-500' : 'bg-green-500' }}" />
                                </div>
                            </div>
                        @endscope

                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>
    </x-mary-card>
    @include('livewire.package.send-edit-encomienda-modal')
    @include('livewire.package.send-modal')
    @include('livewire.package.send-detail-drawer')
    @include('livewire.package.send-manifiesto-modal')
</div>
