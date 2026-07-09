<x-mary-modal wire:model="modalRole" persistent class="backdrop-blur transition-all duration-300"
    box-class="h-full max-w-4xl mx-auto my-4 md:my-8 p-4 md:p-6 bg-white shadow-xl rounded-lg">

    <div class="flex items-center space-x-3 mb-6">
        <x-mary-icon name="s-envelope" class="text-green-500 text-xl"
            label="{{ !isset($roleForm->role) ? 'CREAR ROL' : 'EDITAR ROL' }}" />
    </div>

    <x-mary-form wire:submit.prevent="{{ !isset($roleForm->role) ? 'create' : 'edit' }}" class="space-y-6">
        <div class="border border-green-500 rounded-lg divide-y divide-green-200">
            <div class="p-4 md:p-6">
                <div class="max-w-xl">
                    <x-mary-input label="Nombre" inline wire:model='roleForm.name' class="w-full" />
                </div>
            </div>

            <div class="p-4 md:p-6">
                @php
                    $headers = [
                        ['key' => 'id', 'label' => '#', 'class' => 'w-12'],
                        ['key' => 'name', 'label' => 'Permiso', 'class' => 'flex-1'],
                    ];
                @endphp

                <x-mary-card subtitle="Seleccione los permisos para el rol" class="bg-white" shadow separator>
                    <x-slot:menu>
                        <div class="max-w-sm">
                            <x-mary-input label="Buscar permiso" icon="o-magnifying-glass"
                                wire:model.live='search' placeholder="Escriba para filtrar..." class="w-full" />
                        </div>
                    </x-slot:menu>

                    <x-mary-table :headers="$headers" :rows="$permisos" wire:model="selected" selectable
                        selectable-key="name" with-pagination per-page="perPage2" class="mt-4" />
                </x-mary-card>
            </div>

            <div class="p-4 md:p-6 bg-gray-50 flex justify-end space-x-3">
                <x-mary-button label="Cancelar" @click="$wire.modalRole = false"
                    class="bg-red-500 hover:bg-red-600 text-white transition-colors" />

                <x-mary-button type="submit" spinner="{{ !isset($roleForm->role) ? 'create' : 'edit' }}" label="Guardar"
                    class="bg-blue-500 hover:bg-blue-600 text-white transition-colors" />
            </div>
        </div>
    </x-mary-form>
</x-mary-modal>