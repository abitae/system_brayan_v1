<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>
            <!-- Opcional: agregar elementos de menú aquí -->
        </x-slot:menu>
        @php
        $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-green-500 w-1 text-white'],
        ['key' => 'fecha', 'label' => 'Fecha', 'class' => ''],
        ['key' => 'sucursal', 'label' => 'Sucursal', 'class' => ''],
        ['key' => 'destino', 'label' => 'Destino', 'class' => ''],
        ['key' => 'excel', 'label' => 'Excel', 'class' => ''],
        ];
        @endphp
        <x-mary-table :headers="$headers" :rows="$manifiestos" striped with-pagination per-page="perPage"
            :per-page-values="[5, 20, 10, 50]">
            @scope('cell_fecha', $stuff)
            <div class="text-xs">{{ $stuff->created_at->format('d-m-Y H:i A') }}</div>
            @endscope
            @scope('cell_sucursal', $stuff)
            <div class="text-xs">{{ $stuff->sucursal->name }}</div>
            @endscope
            @scope('cell_destino', $stuff)
            <div class="text-xs">{{ $stuff->destino->name }}</div>
            @endscope
            @scope('cell_excel', $stuff)
            <x-mary-button icon="o-document-arrow-down" target="_blank" wire:click="excelGenerate({{ $stuff->id }})"
                no-wire-navigate spinner class="text-white bg-orange-500 btn-xs" />
            @endscope
        </x-mary-table>
    </x-mary-card>
</div>