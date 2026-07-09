<x-mary-modal wire:model="modalEnvio" class="backdrop-blur"
    box-class="max-h-full max-w-128 sm:max-w-md md:max-w-lg lg:max-w-2xl">
    <div class="flex items-center justify-center mb-4">
        <x-mary-icon name="s-envelope" class="text-green-500 text-2xl mr-2" />
        <h2 class="text-xl font-bold text-gray-800">RECIBIR PAQUETES</h2>
    </div>
    <x-mary-form wire:submit.prevent="receivePaquetes">
        <div class="p-4 border-2 border-green-500 rounded-lg shadow-md">

            <div class="mb-4">
                <x-mary-card title="{{ $numElementos ?? 0 }}" subtitle="Paquetes seleccionados" shadow separator>
                    Sucursal de raiz : {{ $sucursal_rem->name ?? 'Sucursal raiz' }}
                </x-mary-card>
            </div>

            <x-slot:actions>
                <x-mary-button label="Cancelar" wire:click="openModal()" class="bg-red-500" />
                <x-mary-button type="submit" spinner="sendPaquetes" label="Guardar" class="bg-blue-500" />
            </x-slot:actions>
        </div>
    </x-mary-form>
</x-mary-modal>