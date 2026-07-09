<x-mary-modal wire:model="modalEnvio" class="backdrop-blur" box-class="max-h-full max-w-128 sm:max-w-md md:max-w-lg lg:max-w-2xl">
    <div class="flex items-center justify-center mb-4">
        <x-mary-icon name="s-envelope" class="text-green-500 text-2xl mr-2" />
        <h2 class="text-xl font-bold text-gray-800">ENVIAR PAQUETES</h2>
    </div>

    <x-mary-form wire:submit.prevent="sendPaquetes">
        <div class="p-4 border-2 border-green-500 rounded-lg shadow-md">
            <!-- Información del envío -->
            <div class="mb-4">
                <x-mary-card title="{{ $numElementos ?? 0 }}" subtitle="Encomiendas seleccionados" shadow separator class="bg-green-50">
                    <div class="flex items-center mt-2">
                        <span class="font-semibold mr-2">Sucursal de destino:</span>
                        <span class="text-blue-600 font-medium">{{ $sucursal_dest->name ?? 'Sucursal destino' }}</span>
                    </div>
                </x-mary-card>
            </div>

            <!-- Formulario de envío -->
            <div class="space-y-4 sm:space-y-5">
                <div class="w-full">
                    <x-mary-datetime
                        label="Fecha y hora de traslado"
                        wire:model="date_traslado"
                        icon="o-calendar"
                        type="datetime-local"
                        class="w-full" />
                </div>

                <div class="w-full">
                    <x-mary-select
                        label="Transportista"
                        icon="o-user"
                        :options="$transportistas"
                        wire:model="transportista_id"
                        class="w-full" />
                </div>

                <div class="w-full">
                    <x-mary-select
                        label="Vehículo"
                        icon="o-truck"
                        :options="$vehiculos"
                        wire:model="vehiculo_id"
                        class="w-full" />
                </div>
            </div>

            <!-- Botones de acción -->
            <x-slot:actions>
                <div class="flex justify-end space-x-3 mt-5">
                    <x-mary-button
                        label="Cancelar"
                        wire:click="openModal()"
                        class="bg-red-500 hover:bg-red-600 text-white" />
                    <x-mary-button
                        type="submit"
                        spinner="sendPaquetes"
                        label="Guardar"
                        class="bg-blue-500 hover:bg-blue-600 text-white" />
                </div>
            </x-slot:actions>
        </div>
    </x-mary-form>
</x-mary-modal>