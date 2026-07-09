@if($encomienda)
    <x-mary-modal wire:model.live="modalFinal" persistent class="backdrop-blur" box-class="max-w-4xl">
        <x-mary-card shadow class="p-5">
            <!-- Encabezado con animación sutil -->
            <div class="text-center mb-6 animate-fade-in">
                <h2 class="text-2xl font-bold text-indigo-700 mb-2">¡Encomienda Entregada Exitosamente!</h2>
                <p class="text-gray-600 text-lg">Seleccione una opción para continuar</p>
                <div class="mt-2 border-b-2 border-indigo-200 w-1/2 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-4">
                <!-- Sección de Documentos para imprimir -->
                <div class="col-span-full bg-gray-50 rounded-lg p-3 mb-2">
                    <h3 class="text-base font-semibold text-gray-800 mb-3 flex items-center">
                        <x-mary-icon name="o-printer" class="mr-2 text-indigo-600 h-5 w-5" />
                        <span class="border-b-2 border-indigo-300 pb-1">DOCUMENTOS PARA IMPRIMIR</span>
                    </h3>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="col-span-1">
                            @if ($encomienda->ticket)
                                <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="TICKET"
                                    link="/ticket/80mm/{{ $encomienda->ticket->id }}" spinner
                                    class="w-full text-white bg-cyan-500 hover:bg-cyan-700 shadow-md hover:shadow-lg transition-all duration-200 font-medium" />
                            @endif
                        </div>
                        <div class="col-span-1">
                            @if ($encomienda->invoice)
                                <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="RECIBO"
                                    link="/invoice/80mm/{{ $encomienda->invoice->id }}" spinner
                                    class="w-full text-white bg-purple-500 hover:bg-cyan-700 shadow-md hover:shadow-lg transition-all duration-200 font-medium" />
                            @endif
                        </div>
                        <div class="col-span-1">
                            @if ($encomienda->despatche)
                                <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="GUIA T"
                                    link="/despache/80mm/{{ $encomienda->despatche->id }}" spinner
                                    class="w-full text-white bg-green-500 hover:bg-green-700 shadow-md hover:shadow-lg transition-all duration-200 font-medium" />
                            @endif
                        </div>
                        <div class="col-span-1">
                           
                        </div>
                    </div>
                </div>

                <!-- Sección de Acciones disponibles -->
                <div class="col-span-full bg-gray-50 rounded-lg p-3 mt-2">
                    <h3 class="text-base font-semibold text-gray-800 mb-3 flex items-center">
                        <x-mary-icon name="o-arrow-right-circle" class="mr-2 text-indigo-600 h-5 w-5" />
                        <span class="border-b-2 border-indigo-300 pb-1">ACCIONES DISPONIBLES</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <x-mary-button icon="o-newspaper" link="{{ route('package.register') }}" spinner
                                label="NUEVA ENCOMIENDA"
                                class="w-full text-white bg-indigo-600 hover:bg-indigo-700 shadow-md hover:shadow-lg transition-all duration-200 font-medium" />
                        </div>
                        <div>
                            <x-mary-button icon="s-list-bullet" link="{{ route('package.send') }}" spinner
                                label="LISTA ENCOMIENDAS"
                                class="w-full text-white bg-purple-500 hover:bg-purple-700 shadow-md hover:shadow-lg transition-all duration-200 font-medium" />
                        </div>
                        <div>
                            <x-mary-button icon="o-cursor-arrow-ripple" link="{{ route('package.deliver') }}"
                                no-wire-navigate label="ENTREGAR" spinner
                                class="w-full text-white bg-blue-500 hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200 font-medium" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón para cerrar el modal -->
            <div class="mt-6 text-center">
                <x-mary-button @click="$wire.modalFinal = false" label="CERRAR" icon="o-x-mark"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 shadow-sm transition-all duration-200" />
            </div>
        </x-mary-card>
    </x-mary-modal>
@endif