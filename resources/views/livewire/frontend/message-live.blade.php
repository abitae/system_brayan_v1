<div>
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator>
        <x-slot:menu>


        </x-slot:menu>
        @php
        $headers = [
        ['key' => 'name', 'label' => 'Nombre', 'class' => ''],
        ['key' => 'email', 'label' => 'Email', 'class' => ''],
        ['key' => 'phone', 'label' => 'Telefono', 'class' => ''],
        ['key' => 'select', 'label' => 'Tipo', 'class' => ''],
        ['key' => 'fecha', 'label' => 'Fecha', 'class' => ''],
        ];
        $row_decoration = [
        'bg-yellow-500' => fn(App\Models\Frontend\Message $message) => $message->isActive,

        ];
        @endphp
        <x-mary-table :headers="$headers" :rows="$messages" with-pagination per-page="perPage"
            :per-page-values="[5, 20, 10, 50]" :row-decoration="$row_decoration"
            @row-click="$wire.readMessage($event.detail.id)">
            @scope('cell_fecha', $stuff)
            {{ $stuff->created_at->format('d-m-Y H:i A') }}
            @endscope
        </x-mary-table>
    </x-mary-card>
    @if ($message)


    <x-mary-modal wire:model="modalMessage" title="{{ $message->name }}" subtitle="{{ $message->email }}" separator>
        <div>
            {{ $message->select }}
            <p>{{ $message->message }}</p>
        </div>

        <x-slot:actions>
            <x-mary-button label="Cerrar" @click="$wire.modalMessage = false" />
        </x-slot:actions>
    </x-mary-modal>
    @endif
</div>