<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>
            <x-mary-button icon="o-document-arrow-down" label="Descargar Excel" wire:click="excelGenerate" no-wire-navigate
                spinner class="text-white bg-orange-500 hover:bg-orange-600 transition-colors duration-200" />
            <x-mary-button wire:click.prevent="enviarBloque" label="Enviar bloque" icon="o-arrow-path"
                 spinner responsive />
        </x-slot:menu>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-2 p-2 shadow-xl">
            <div>
                <x-mary-input type='search' label="Buscar guia" icon="o-funnel" wire:model.live="search"
                    placeholder="Buscar guia" />
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
                <x-mary-select label="Sucursal" icon="o-building-office" :options="$sucursales"
                    wire:model.live="FiltroSucursal" />
            </div>

        </div>
        <div class="grid grid-cols-4 gap-1 shadow-2xl">
            <div class="grid col-span-4">
                <x-mary-card shadow separator progress-indicator>
                    @php
                        $headers = [
                            ['key' => 'id', 'label' => '#', 'class' => 'bg-green-500 w-1'],
                            ['key' => 'document', 'label' => 'Documento', 'class' => ''],
                            ['key' => 'remitente', 'label' => 'Remitente', 'class' => ''],
                            ['key' => 'pdf', 'label' => 'PDF A4', 'class' => ''],
                            ['key' => 'xml', 'label' => 'XML/CDR', 'class' => ''],
                            ['key' => 'menu', 'label' => 'Menu', 'class' => ''],
                        ];
                    @endphp
                    <x-mary-table :headers="$headers" :rows="$despaches" striped with-pagination per-page="perPage"
                        :per-page-values="[5, 20, 10, 50]">
                        @scope('cell_document', $stuff)
                            @php
                                $valor = $stuff->serie . '-' . $stuff->correlativo;
                            @endphp
                            <x-mary-badge :value="$valor" class="bg-cyan-500" />
                            <br>
                            <div class="text-xs">{{ $stuff->created_at->format('d-m-Y H:i A') }}</div>
                        @endscope

                        @scope('cell_remitente', $stuff)
                            <div class="text-xs">{{ $stuff->remitente->code }}</div>
                            <div class="text-xs">{{ $stuff->remitente->name }}</div>
                        @endscope
                        @scope('cell_pdf', $stuff)
                            <x-mary-button icon="o-document-chart-bar" target="_blank" no-wire-navigate
                                link="/despache/a4/{{ $stuff->id }}" spinner class="text-white bg-purple-500 btn-xs" />
                            <x-mary-button icon="o-ticket" target="_blank" no-wire-navigate
                                link="/despache/80mm/{{ $stuff->id }}" spinner class="text-white bg-green-500 btn-xs" />
                        @endscope
                        @scope('cell_xml', $stuff)
                            @if ($stuff->cdr_code != 0)
                                <x-mary-button icon="o-exclamation-triangle" target="_blank" label="{{ $stuff->cdr_code }}"
                                    wire:click="statusDespatch({{ $stuff->id }})" no-wire-navigate spinner
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
                                    wire:click="statusDespatch({{ $stuff->id }})" />
                            </x-mary-dropdown>
                        @endscope
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>
    </x-mary-card>
    @if ($despatche)
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
                <form wire:submit="save">
                    <div class="px-6">
                        <div class="space-y-3 text-sm">
                            @php
                                $statusItems = [
                                    ['label' => 'Código', 'value' => $cdr_code ?? 'No hay código'],
                                    ['label' => 'Descripción', 'value' => $cdr_description ?? 'No hay descripción'],
                                    ['label' => 'Nota', 'value' => $cdr_note ?? 'No hay nota'],
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
                            <x-mary-input label="Ticket" wire:model="ticket" />
                            @if ($despatche->ticket)
                                <x-mary-button label="Actualizar"
                                    wire:click="ActualizarDespatche({{ $despatche }})" />
                            @endif
                        </div>
                    </div>
                    <!-- Footer Section -->
                    <footer class="flex justify-center gap-2  px-6 py-3 rounded-b-lg">
                        <x-mary-button label="Cancelar" @click="$wire.infoModal = false"
                            class="bg-red-500 hover:bg-red-600 text-white" />
                        <x-mary-button type="submit" spinner="save" label="Guardar"
                            class="bg-blue-500 hover:bg-blue-600 text-white" />
                    </footer>
            </div>
            </form>
        </x-mary-modal>
    @endif
</div>
