<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-button wire:click='openModal' responsive icon="o-plus" label="Nuevo vehiculo"
                class="text-white bg-sky-500" />
        </x-slot:menu>

    </x-mary-card>
    <div class="grid grid-cols-4 space-x-2">
        <div class="grid col-span-4 pt-2">
            <x-mary-card shadow separator>
                @php
                $headers = [
                ['key' => 'id', 'label' => '#', 'class' => 'bg-blue-500 w-1'],
                ['key' => 'name', 'label' => 'Placa', 'class' => ''],
                ['key' => 'marca', 'label' => 'Marca', 'class' => ''],
                ['key' => 'modelo', 'label' => 'Modelo', 'class' => ''],
                ['key' => 'tipo', 'label' => 'Tipo', 'class' => ''],
                ['key' => 'isActive', 'label' => 'isActive', 'class' => ''],
                ];
                $row_decoration = [
                'bg-red-50' => fn(App\Models\Configuration\Vehiculo $vehiculo) => !$vehiculo->isActive,
                ];
                @endphp
                <x-mary-table :headers="$headers" :rows="$vehiculos" with-pagination per-page="perPage"
                    :row-decoration="$row_decoration" :per-page-values="[5, 20, 10, 50]">
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
                    @scope('actions', $vehiculo)
                    <nobr>
                        <x-mary-button icon="s-pencil-square" wire:click="openEditModal({{ $vehiculo->id }})" spinner
                            class="btn-sm" />
                        <x-mary-button icon="o-trash" wire:click="delete({{ $vehiculo->id }})"
                            wire:confirm.prompt="Estas seguro?\n\nEscribe DELETE para confirmar|DELETE" spinner
                            class="btn-sm" />
                    </nobr>
                    @endscope
                </x-mary-table>
            </x-mary-card>
        </div>
    </div>
    <x-mary-modal wire:model="modalVehiculo" persistent class="backdrop-blur" box-class="max-h-full max-w-128 ">
        <x-mary-icon name="s-envelope" class="text-green-500 text-md"
            label="{{ $vehiculoForm->vehiculo ? 'EDITAR VEHÍCULO' : 'REGISTRAR VEHÍCULO' }}" />
        <x-mary-form wire:submit="{{ $vehiculoForm->vehiculo ? 'edit' : 'create' }}">
            <div class="border border-green-500 rounded-lg">
                <div class="grid grid-cols-4 p-2">
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Placa" inline wire:model='vehiculoForm.name' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Marca" inline wire:model='vehiculoForm.marca' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Modelo" inline wire:model='vehiculoForm.modelo' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="nroCirculacion" inline wire:model='vehiculoForm.nroCirculacion' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="nroAutorizacion" inline wire:model='vehiculoForm.nroAutorizacion' />
                    </div>

                    <div class="grid col-span-4 pt-2">
                        @php
                        $tipos = [
                        ['id'=> 'INTERNO' , 'name' => 'INTERNO'],
                        ['id'=> 'EXTERNO', 'name' => 'EXTERNO'],
                        ]
                        @endphp
                        <x-mary-select label="Tipo" icon="o-user" :options="$tipos" wire:model='vehiculoForm.tipo'
                            inline />
                    </div>

                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancelar" @click="$wire.closeModal()" class="btn-ghost" />
                    <x-mary-button type="submit" spinner="{{ $vehiculoForm->vehiculo ? 'edit' : 'create' }}"
                        label="Guardar" class="btn-primary text-white" />
                </x-slot:actions>
            </div>
        </x-mary-form>
    </x-mary-modal>
</div>