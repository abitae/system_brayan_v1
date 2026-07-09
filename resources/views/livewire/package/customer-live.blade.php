<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-input label="Buscar cliente" inline wire:model.live='search' />
            <x-mary-button wire:click='openModal' responsive icon="o-plus" label="Nuevo cliente"
                class="text-white bg-sky-500" />
        </x-slot:menu>
        <div class="grid grid-cols-4 gap-1 shadow-xl">
            <div class="grid col-span-4">
                <x-mary-card shadow separator>
                    @php
                        $headers = [
                            ['key' => 'id', 'label' => '#', 'class' => 'bg-purple-500 w-1'],
                            ['key' => 'code', 'label' => 'Documento', 'class' => ''],
                            ['key' => 'name', 'label' => 'Name', 'class' => ''],
                            ['key' => 'phone', 'label' => 'Telefono', 'class' => ''],
                            ['key' => 'isActive', 'label' => 'isActive', 'class' => ''],
                        ];
                        $row_decoration = [
                            'bg-red-50' => fn(App\Models\package\Customer $customer) => !$customer->isActive,
                        ];
                    @endphp
                    <x-mary-table :headers="$headers" :rows="$customers" with-pagination per-page="perPage"
                        :row-decoration="$row_decoration" :sort-by="$sortBy" :per-page-values="[5, 20, 10, 50]">
                        @scope('cell_code', $stuff)
                            <nobr>
                                @if ($stuff->type_code == '1')
                                    <x-mary-badge :value="strtoupper('DNI')" class="badge-info" />
                                @else
                                    <x-mary-badge :value="strtoupper('RUC')" class="badge-info" />
                                @endif
                                {{ $stuff->code }}
                            </nobr>
                        @endscope
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
                        @scope('actions', $user)
                            <nobr>
                                <x-mary-button icon="s-pencil-square" wire:click="edit({{ $user->id }})" spinner
                                    class="btn-sm" />
                                <x-mary-button icon="o-trash" wire:click="delete({{ $user->id }})"
                                    wire:confirm.prompt="Estas seguro?\n\nEscribe DELETE para confirmar|DELETE" spinner
                                    class="btn-sm" />
                            </nobr>
                        @endscope
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>
    </x-mary-card>

    <x-mary-modal wire:model="modalCustomer" persistent class="backdrop-blur" box-class="max-h-full max-w-128 ">
        <x-mary-icon name="s-envelope" class="text-green-500 text-md"
            label="{{ !isset($customerForm->user) ? 'CREAR CLIENTE' : 'EDITAR CLIENTE' }}" />
        <x-mary-form wire:submit.prevent="{{ !isset($customerForm->customer) ? 'create' : 'update' }}">
            <div class="border border-green-500 rounded-lg">
                <div class="grid grid-cols-4 p-2">
                    <div class="grid col-span-4 pt-2">

                        <x-mary-input wire:model.live='customerForm.code' label="Numero documento" inline>
                            <x-slot:prepend>
                                @php
                                    $docs = [
                                        ['id' => '1', 'name' => 'DNI'],
                                        ['id' => '6', 'name' => 'RUC'],
                                    ];
                                @endphp
                                <x-mary-select wire:model='customerForm.type_code' icon="o-user" :options="$docs"
                                    class="bg-purple-300 rounded-e-none" />
                            </x-slot:prepend>
                            <x-slot:append>
                                <x-mary-button icon="o-magnifying-glass"
                                    class="bg-purple-300 btn-secondary rounded-s-none" wire:click='SearchDocument'
                                    spinner='SearchDocument' />
                            </x-slot:append>
                        </x-mary-input>
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Denominacion" inline wire:model='customerForm.name' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Email" inline wire:model='customerForm.email' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Telefono" inline wire:model='customerForm.phone' />
                    </div>
                    <div class="grid col-span-4 pt-2">
                        <x-mary-input label="Direccion" inline wire:model='customerForm.address' />
                    </div>
                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancel" wire:click="openModal()" class="bg-red-500" />
                    <x-mary-button type="submit" spinner="{{ !isset($customerForm->customer) ? 'create' : 'edit' }}"
                        label="Save" class="bg-blue-500" />
                </x-slot:actions>
            </div>
        </x-mary-form>
    </x-mary-modal>
</div>
