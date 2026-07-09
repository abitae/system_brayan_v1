@if($manifiesto)
    <x-mary-modal title="Descargar Manifiesto" wire:model.live="modalFinal">
        <x-mary-card shadow class="p-4">
            <div class="flex flex-col items-center space-y-4">
                <h2 class="text-xl font-bold text-gray-800">Descargar Manifiesto</h2>

                <div class="text-center text-gray-600">
                    <p>El manifiesto está listo para ser descargado</p>
                    <p class="text-sm">ID: {{ $manifiesto->id }}</p>
                </div>

                <div class="flex items-center justify-center w-full">
                    <x-mary-button icon="o-document-arrow-down" label="Descargar Excel"
                        wire:click="excelGenerate({{ $manifiesto->id }})" no-wire-navigate spinner
                        class="text-white bg-orange-500 hover:bg-orange-600 transition-colors duration-200" />
                </div>
            </div>
        </x-mary-card>
    </x-mary-modal>
@endif