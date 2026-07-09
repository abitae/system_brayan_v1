@if($encomienda)
<x-mary-modal wire:model="modalDeliver" persistent class="backdrop-blur" box-class="max-h-full max-w-128">
    <div class="mb-4">
        <x-mary-icon name="s-envelope" class="text-green-500 text-xl" label="ENTREGAR ENCOMIENDA" />
    </div>
    <x-mary-form wire:submit.prevent="deliverPaquetes">
        <div class="border border-green-500 rounded-lg shadow-md bg-white bg-opacity-95">
            <div class="p-4 space-y-4">
                <div class="w-full">
                    <x-mary-input label="Numero documento" inline wire:model.live='document' class="w-full" icon="o-identification" />
                </div>
                @if (!$encomienda->isHome)
                    <div class="w-full">
                        <div class="mb-2">
                            <x-mary-icon name="o-lock-closed" class="text-blue-500" label="CÓDIGO DE SEGURIDAD" />
                        </div>
                        <x-mary-pin ida='pin01' wire:model="pin" size="3" numeric class="flex justify-center" />
                    </div>
                @endif
            </div>
            <div class="bg-gray-50 p-4 rounded-b-lg border-t border-gray-200">
                <x-slot:actions>
                    <x-mary-button label="Cancelar" @click="$wire.modalDeliver = false" class="bg-red-500 hover:bg-red-600 text-white transition-colors duration-200" />
                    <x-mary-button type="submit" spinner="deliverPaquetes" label="Entregar" class="bg-blue-500 hover:bg-blue-600 text-white transition-colors duration-200" icon="o-paper-airplane" />
                </x-slot:actions>
            </div>
        </div>
    </x-mary-form>
</x-mary-modal>
@endif