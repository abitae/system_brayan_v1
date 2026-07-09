<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>
            <x-mary-button icon="o-document-arrow-down" label="Descargar Excel" wire:click="excelGenerate"
                no-wire-navigate spinner class="text-white bg-orange-500 hover:bg-orange-600 transition-colors duration-200" />
            <x-mary-button wire:click.prevent="buscaResumen" label="Resumen Boletas" icon="o-arrow-path"
                spinner responsive />
            <x-mary-button wire:click.prevent="enviarBloque" label="Enviar bloque" icon="o-arrow-path"
                spinner responsive />
        </x-slot:menu>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-2 p-2 shadow-xl">
            <div>
                <x-mary-input type='search' label="Buscar encomienda" icon="o-funnel" wire:model.live="search"
                    placeholder="Buscar comprobante" />
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
                            ['key' => 'xml', 'label' => 'XML/CDR', 'class' => ''],
                            ['key' => 'menu', 'label' => 'Menu', 'class' => ''],
                        ];
                    @endphp
                    <x-mary-table :headers="$headers" :rows="$invoices" striped with-pagination per-page="perPage"
                        :per-page-values="[5, 20, 10, 50]">
                        @scope('cell_document', $stuff)
                            @php
                                $valor = $stuff->serie . '-' . $stuff->correlativo;
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
                                link="/invoice/a4/{{ $stuff->id }}" spinner class="text-white bg-purple-500 btn-xs" />
                            <x-mary-button icon="o-ticket" target="_blank" no-wire-navigate
                                link="/invoice/80mm/{{ $stuff->id }}" spinner class="text-white bg-green-500 btn-xs" />
                        @endscope

                        @scope('cell_xml', $stuff)
                            @if ($stuff->xml_path && $stuff->xml_hash)
                                <x-mary-button icon="o-document-arrow-down" target="_blank"
                                    wire:click="xmlDownload({{ $stuff->id }})" no-wire-navigate spinner
                                    class="text-white bg-cyan-500 btn-xs" />
                            @else
                                <x-mary-button icon="o-arrow-path" target="_blank"
                                    wire:click="xmlGenerate({{ $stuff->id }})" no-wire-navigate spinner
                                    class="text-white bg-orange-500 btn-xs" />
                            @endif
                            @if ($stuff->cdr_code != 0)
                                <x-mary-button icon="o-exclamation-triangle" target="_blank"
                                    wire:click="statusInvoice({{ $stuff->id }})" no-wire-navigate spinner
                                    class="text-white bg-red-500 btn-xs" />
                            @else
                                @if ($stuff->cdr_path)
                                    <x-mary-button icon="o-document-arrow-down" target="_blank"
                                        wire:click="downloadCdrFile({{ $stuff->id }})" no-wire-navigate spinner
                                        class="text-white bg-blue-500 btn-xs" />
                                @else
                                    <x-mary-button icon="o-arrow-path" target="_blank"
                                        wire:click="sendXmlFile({{ $stuff->id }})" no-wire-navigate spinner
                                        class="text-white bg-orange-500 btn-xs" />
                                @endif
                            @endif
                        @endscope

                        @scope('cell_menu', $stuff)
                            <x-mary-dropdown>
                                <x-slot:trigger>
                                    <x-mary-button icon="m-bars-3" class="btn-xs" />
                                </x-slot:trigger>
                                <x-mary-menu-item title="Estado SUNAT" icon="o-archive-box"
                                    wire:click="statusInvoice({{ $stuff->id }})" />
                                @if ($stuff->cdr_path)
                                    <x-mary-menu-item title="Crear Nota de credito" icon="o-archive-box"
                                        wire:click="createNote({{ $stuff->id }})" />
                                @endif
                            </x-mary-dropdown>
                        @endscope
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>
    </x-mary-card>
    <x-mary-modal class="backdrop-blur" wire:model="infoModal"
        box-class="max-h-full max-w-128 sm:max-w-md md:max-w-lg lg:max-w-2xl">
        <!-- Modal Content Container -->
        <div class="space-y-6">
            <!-- Header Section -->
            <header class="p-6 border-b border-gray-20">
                <div class="flex items-center justify-center">
                    <x-mary-icon name="s-envelope" class="text-green-500 text-2xl mr-2" />
                    <h2 class="text-xl font-bold text-gray-800">ESTADO SUNAT</h2>
                </div>
            </header>
            <!-- Content Section -->
            <div class="px-6">
                <div class="space-y-3 text-sm">
                    @php
                        $statusItems = [
                            ['label' => 'Código', 'value' => $cdr_code],
                            ['label' => 'Descripción', 'value' => $cdr_description],
                            ['label' => 'Nota', 'value' => $cdr_note],
                            [
                                'label' => 'Error Code',
                                'value' => $errorCode ?? 'No hay error',
                                'isError' => isset($errorCode),
                            ],
                            [
                                'label' => 'Error Message',
                                'value' => $errorMessage ?? 'No hay error',
                                'isError' => isset($errorMessage),
                            ],
                        ];
                    @endphp
                    @foreach ($statusItems as $item)
                        <div
                            class="grid grid-cols-3 items-center p-1 rounded-lg  transition-colors duration-200 hover:bg-gray-100">
                            <strong class="text-gray-700">{{ $item['label'] }}:</strong>
                            <span
                                class="col-span-2 {{ isset($item['isError']) ? ($item['isError'] ? 'text-red-500' : 'text-green-500') : '' }}">
                                {{ $item['value'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Footer Section -->
            <footer class="flex justify-center gap-2  px-6 py-3 rounded-b-lg">
                <x-mary-button label="Cancelar" @click="$wire.infoModal = false"
                    class="bg-red-500 hover:bg-red-600 text-white" />
                <x-mary-button type="submit" spinner="sendPaquetes" label="Guardar"
                    class="bg-blue-500 hover:bg-blue-600 text-white" />
            </footer>
        </div>
    </x-mary-modal>
</div>
