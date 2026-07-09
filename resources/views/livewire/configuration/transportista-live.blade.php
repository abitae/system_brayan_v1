<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-button wire:click='openModal' responsive icon="o-plus" label="NUEVO" class="text-white bg-sky-500" />
        </x-slot:menu>
    </x-mary-card>
    <div class="grid grid-cols-4 space-x-2">
        <div class="grid col-span-4 pt-2">
            <x-mary-card shadow separator>
                @php
                    $headers = [
                        ['key' => 'id', 'label' => '#', 'class' => 'bg-blue-500 w-1'],
                        ['key' => 'name', 'label' => 'Name', 'class' => ''],
                        ['key' => 'licencia', 'label' => 'Licencia', 'class' => ''],
                        ['key' => 'dni', 'label' => 'Dni', 'class' => ''],
                        ['key' => 'tipo', 'label' => 'Tipo', 'class' => ''],
                        ['key' => 'isActive', 'label' => 'isActive', 'class' => ''],
                    ];
                    $row_decoration = [
                        'bg-red-50' => fn(
                            App\Models\Configuration\Transportista $transportista,
                        ) => !$transportista->isActive,
                    ];
                @endphp
                <x-mary-table :headers="$headers" :rows="$transportistas" with-pagination per-page="perPage" :row-decoration="$row_decoration"
                    :per-page-values="[5, 20, 10, 50]">
                    @scope('cell_isActive', $stuff)
                        <button wire:click='estado({{ $stuff->id }})'
                            wire:confirm.prompt="Estas seguro de eliminar registro?\n\nEscriba 'SI' para confirmar!|SI"
                            class="flex items-center">
                            <div
                                class="h-2.5 w-2.5 rounded-full {{ $stuff->isActive ? 'bg-green-400' : 'bg-red-600' }} mr-2">
                            </div>
                            {{ $stuff->isActive ? 'Active' : 'Disabled' }}
                        </button>
                    @endscope
                    @scope('actions', $transportista)
                        <nobr>
                            <x-mary-button icon="s-pencil-square" wire:click="openEditModal({{ $transportista->id }})" spinner
                                class="btn-sm" />
                            <x-mary-button icon="o-trash" wire:click="delete({{ $transportista->id }})"
                                wire:confirm.prompt="Estas seguro?\n\nEscribe DELETE para confirmar|DELETE" spinner
                                class="btn-sm" />
                        </nobr>
                    @endscope
                </x-mary-table>
            </x-mary-card>
        </div>
    </div>
    <x-mary-modal wire:model="modalTransportista" persistent class="backdrop-blur" box-class="max-h-full max-w-128 ">
        <x-mary-icon name="o-identification" class="text-primary text-md"
            label="{{ $transportistaForm->transportista ? 'EDITAR CHOFER' : 'REGISTRAR CHOFER' }}" />
        <x-mary-form wire:submit="{{ $transportistaForm->transportista ? 'edit' : 'create' }}">
            <div class="border border-green-500 rounded-lg">
                <div class="grid grid-cols-4 p-2">
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Nombre" inline wire:model='transportistaForm.name' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Licencia" inline wire:model='transportistaForm.licencia' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="DNI" inline wire:model='transportistaForm.dni' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        @php
                            $tipos = [
                                ['id' => 'INTERNO', 'name' => 'INTERNO'],
                                ['id' => 'EXTERNO', 'name' => 'EXTERNO'],
                            ];
                        @endphp
                        <x-mary-select label="Tipo" icon="o-user" :options="$tipos"
                            wire:model="transportistaForm.tipo" inline />
                    </div>
                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancelar" @click="$wire.closeModal()" class="btn-ghost" />
                    <x-mary-button type="submit"
                        spinner="{{ $transportistaForm->transportista ? 'edit' : 'create' }}" label="Guardar"
                        class="btn-primary text-white" />
                </x-slot:actions>
            </div>
        </x-mary-form>
    </x-mary-modal>
</div>
