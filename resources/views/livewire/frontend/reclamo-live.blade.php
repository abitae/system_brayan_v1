<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>
        </x-slot:menu>
        @php
        $headers = [
        ['key' => 'fecha', 'label' => 'Fecha', 'class' => ''],
        ['key' => 'reclamo_nombre', 'label' => 'Nombre', 'class' => ''],
        ['key' => 'reclamo_documento', 'label' => 'Documento', 'class' => ''],
        ['key' => 'reclamo_telefono', 'label' => 'Telefono', 'class' => ''],
        ['key' => 'reclamo_email', 'label' => 'Email', 'class' => ''],
        ['key' => 'reclamo_producto', 'label' => 'Producto', 'class' => ''],
        ['key' => 'reclamo_monto', 'label' => 'Monto', 'class' => ''],
        ];
        $row_decoration = [
        'bg-yellow-500' => fn(App\Models\Frontend\Reclamacion $reclamo) => $reclamo->reclamo_estado,

        ];
        @endphp
        <x-mary-table :headers="$headers" :rows="$reclamos" with-pagination per-page="perPage"
            :per-page-values="[5, 20, 10, 50]" :row-decoration="$row_decoration"
            @row-click="$wire.readReclamo($event.detail.id)">
            @scope('cell_fecha', $stuff)
            {{ $stuff->created_at->format('d-m-Y H:i A') }}
            @endscope
        </x-mary-table>
    </x-mary-card>
    @if ($reclamo)


    <x-mary-modal wire:model="modalReclamo" title="{{ $reclamo->reclamo_nombre }}" subtitle="{{ $reclamo->email }}" separator>
        <div>
            {{ $reclamo->reclamo_documento }}
            <p>{{ $reclamo->reclamo_descripcion }}</p>
            <p>{{ $reclamo->reclamo_monto }}</p>
            <p>{{ $reclamo->reclamo_tipo }}</p>
            <p>{{ $reclamo->reclamo_producto }}</p>
            <p>{{ $reclamo->reclamo_direccion }}</p>
            <p>{{ $reclamo->reclamo_telefono }}</p>
            <p>{{ $reclamo->reclamo_email }}</p>
        </div>

        <x-slot:actions>
            <x-mary-button label="Cerrar" @click="$wire.modalReclamo = false" />
        </x-slot:actions>
    </x-mary-modal>
    @endif
</div>