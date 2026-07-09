@if ($note)
    <x-mary-modal wire:model.live="modalPrintNote" class="backdrop-blur animate-fadeIn"
        box-class="w-full max-w-lg transform transition-all duration-300 ease-in-out" persistent>
        <x-mary-card shadow class="p-4 sm:p-6 animate-slideDown border border-purple-500 rounded">
            <div class="flex flex-col items-center space-y-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 animate-fadeIn">Imprimir Documento</h2>
                <div class="text-center text-gray-600 space-y-2 animate-fadeIn delay-100">
                    <p class="text-base md:text-lg">El documento está listo para ser descargado</p>
                    <p class="text-sm md:text-base font-medium">DOCUMENTO: {{ $note->serie }} -
                        {{ $note->correlativo }}</p>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-center w-full gap-4 animate-fadeIn delay-200">
                    @if ($Invoice)
                        <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="TICKET 80MM"
                            link="/note/80mm/{{ $note->id }}" spinner
                            class="w-full sm:w-auto px-6 py-3 text-white bg-purple-500 hover:bg-purple-600 shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105 font-medium rounded-lg" />

                        <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="FORMATO A4"
                            link="/note/a4/{{ $note->id }}" spinner
                            class="w-full sm:w-auto px-6 py-3 text-white bg-purple-500 hover:bg-purple-600 shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105 font-medium rounded-lg" />
                    @endif
                </div>
            </div>
        </x-mary-card>
        <x-slot:actions>
            <div class="flex justify-center w-full">
                <x-mary-button label="CERRAR" wire:click='closePrintNote' icon="o-x-mark"
                    class="animate-fadeIn delay-300 hover:scale-105 transition-transform duration-200" />
            </div>
        </x-slot:actions>
    </x-mary-modal>
@endif