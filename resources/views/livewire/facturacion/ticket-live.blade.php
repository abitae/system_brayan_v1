<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>


        </x-slot:menu>
        <div class="grid grid-cols-6 gap-2 p-2 shadow-xl">
            <div>
                <x-mary-input type='search' label="Buscar encomienda" icon="o-funnel" wire:model.live="search"
                    placeholder="Buscar ticket" />
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
                <x-mary-select label="Estado pago" icon="s-inbox-stack" :options="$formaPagos"
                    wire:model.live="FiltroFormaPagoTipo" />
            </div>

        </div>
        <div class="grid grid-cols-4 gap-1 shadow-2xl">
            <div class="grid col-span-4">
                <x-mary-card shadow separator progress-indicator>
                    @php
                        $headers = [
                            ['key' => 'id', 'label' => '#', 'class' => 'bg-green-500 w-1 text-white'],
                            ['key' => 'document', 'label' => 'Documento', 'class' => ''],
                            ['key' => 'cliente', 'label' => 'Cliente', 'class' => ''],
                            ['key' => 'mtoImpVenta', 'label' => 'Monto', 'class' => ''],
                            ['key' => 'pdf', 'label' => 'PDF A4', 'class' => ''],
                            ['key' => 'comprobante', 'label' => 'Comprobante', 'class' => ''],
                            ['key' => 'menu', 'label' => 'Menu', 'class' => ''],
                        ];
                    @endphp
                    <x-mary-table :headers="$headers" :rows="$tickets" striped with-pagination per-page="perPage"
                        :per-page-values="[5, 20, 10, 50]">
                        @scope('cell_document', $stuff)
                        @php
                            $valor = $stuff->serie;
                        @endphp
                        <x-mary-badge :value="$valor" class="bg-purple-500 text-white" />
                        <br>
                        <div class="text-xs">{{ $stuff->created_at->format('d-m-Y H:i A') }}</div>
                        <x-mary-badge :value="$stuff->formaPago_tipo"
                            class="bg-{{ $stuff->formaPago_tipo == 'Contado' ? 'cyan-500' : 'red-500 animate-bounce' }} text-white" />
                        @endscope
                        @scope('cell_cliente', $stuff)
                        <div class="text-xs">{{ $stuff->client->code }}</div>
                        <div class="text-xs">{{ $stuff->client->name }}</div>
                        @endscope
                        @scope('cell_mtoImpVenta', $stuff)
                        <div class="text-xs">S/{{ $stuff->mtoImpVenta }}</div>
                        @endscope

                        @scope('cell_pdf', $stuff)
                        <x-mary-button icon="o-document-chart-bar" target="_blank" no-wire-navigate
                            link="/ticket/a4/{{ $stuff->id }}" spinner class="text-white bg-purple-500 btn-xs" />
                        <x-mary-button icon="o-ticket" target="_blank" no-wire-navigate
                            link="/ticket/80mm/{{ $stuff->id }}" spinner class="text-white bg-green-500 btn-xs" />
                        @endscope
                        @scope('cell_comprobante', $stuff)
                        <div class="grid grid-cols-1 gap-1">
                            <div>
                                @if ($stuff->encomienda->invoice)
                                    <x-mary-button label='Recibo' icon="o-printer" target="_blank" no-wire-navigate
                                        link="/invoice/80mm/{{ $stuff->encomienda->invoice->id }}" spinner
                                        class="w-full h-full text-white bg-purple-500 btn-xs" />
                                @endif
                            </div>
                            <div>
                                @if ($stuff->encomienda->ticket)
                                    <x-mary-button label='Ticket' icon="o-printer" target="_blank" no-wire-navigate
                                        link="/ticket/80mm/{{ $stuff->encomienda->ticket->id }}" spinner
                                        class="w-full h-full text-white bg-cyan-500 btn-xs" />
                                @endif
                            </div>
                            <div>
                                @if ($stuff->encomienda->despatche)
                                    <x-mary-button label='Guia T' icon="o-printer" target="_blank" no-wire-navigate
                                        link="/despache/80mm/{{ $stuff->encomienda->despatche->id }}" spinner
                                        class="w-full h-full text-white bg-green-500 btn-xs" />
                                @endif
                            </div>
                        </div>
                        @endscope
                        @scope('cell_menu', $stuff)
                        <x-mary-dropdown>
                            <x-slot:trigger>
                                <x-mary-button icon="m-bars-3" class="btn-outline" />
                            </x-slot:trigger>
                            <x-mary-menu-item title="Estado SUNAT" icon="o-archive-box" />
                        </x-mary-dropdown>
                        @endscope
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>
    </x-mary-card>
</div>