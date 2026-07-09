<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>

        </x-slot:menu>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 p-2 shadow-xl">
            <div>
                <x-mary-input type='search' label="Buscar nota" icon="o-funnel" wire:model.live="search"
                    placeholder="Buscar nota" />
            </div>
            <div>
                <x-mary-datetime label="Desde" wire:model.live="filtroFechaInicio" icon="o-calendar"
                    type="datetime-local" />
            </div>
            <div>
                <x-mary-datetime label="Hasta" wire:model.live="filtroFechaFin" icon="o-calendar"
                    type="datetime-local" />
            </div>
        </div>
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
        <x-mary-table :headers="$headers" :rows="$notes" striped with-pagination per-page="perPage"
            :per-page-values="[5, 20, 10, 50]">
            @scope('cell_document', $stuff)
            @php
            $valor = $stuff->serie . '-' . $stuff->correlativo;
            @endphp
            <x-mary-badge :value="$valor" class="bg-cyan-500 text-white" />
            <br>
            <div class="text-xs">{{ $stuff->created_at->format('d-m-Y H:i A') }}</div>
            Modifica:<x-mary-badge :value="$stuff->numDocfectado" class="bg-green-500 text-white" />
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
                link="/note/a4/{{ $stuff->id }}" spinner class="text-white bg-purple-500 btn-xs" />
            <x-mary-button icon="o-ticket" target="_blank" no-wire-navigate link="/note/80mm/{{ $stuff->id }}"
                spinner class="text-white bg-green-500 btn-xs" />
            @endscope

            @scope('cell_xml', $stuff)
            @if ($stuff->xml_path && $stuff->xml_hash)
            <x-mary-button icon="o-document-arrow-down" target="_blank" wire:click="xmlDownload({{ $stuff->id }})"
                no-wire-navigate spinner class="text-white bg-cyan-500 btn-xs" />
            @else
            <x-mary-button icon="o-arrow-path" target="_blank" wire:click="xmlGenerate({{ $stuff->id }})"
                no-wire-navigate spinner class="text-white bg-orange-500 btn-xs" />
            @endif
            @if ($stuff->cdr_path)
            <x-mary-button icon="o-document-arrow-down" target="_blank" wire:click="downloadCdrFile({{ $stuff->id }})"
                no-wire-navigate spinner class="text-white bg-blue-500 btn-xs" />
            @else
            <x-mary-button icon="o-arrow-path" target="_blank" wire:click="sendXmlFile({{ $stuff->id }})"
                no-wire-navigate spinner class="text-white bg-orange-500 btn-xs" />
            @endif
            @endscope


            @scope('cell_menu', $stuff)
            <x-mary-dropdown>
                <x-slot:trigger>
                    <x-mary-button icon="m-bars-4" class="btn-outline" />
                </x-slot:trigger>
                <x-mary-menu-item title="Estado SUNAT" icon="o-archive-box"
                    wire:click="statusNote({{ $stuff->id }})" />
            </x-mary-dropdown>
            @endscope
        </x-mary-table>
    </x-mary-card>
    <x-mary-modal class="backdrop-blur" title="Informacion de la factura" wire:model="infoModal">
        <x-mary-icon name="o-envelope" label="SUNAT" icon="o-information-circle" class="text-blue-500" />
        <div class="text-sm">
            <p>
                <strong>Codigo:</strong>
                <span>{{ $cdr_code }}</span>
            </p>
            <p>
                <strong>Descripcion:</strong>
                <span>{{ $cdr_description }}</span>
            </p>
            <p>
                <strong>Nota:</strong>
                <span>{{ $cdr_note }}</span>
            </p>
            <p>
                <strong>Error Code:</strong>
                <span>{{ $errorCode ?? 'No hay error' }}</span>
            </p>
            <p>
                <strong>Error Message:</strong>
                <span>{{ $errorMessage ?? 'No hay error' }}</span>
            </p>
        </div>
        <div class="flex justify-end">
            <x-mary-button icon="o-x-mark" class="btn-outline btn-sm" label="Cancel" @click="$wire.infoModal = false" />
        </div>
    </x-mary-modal>
</div>