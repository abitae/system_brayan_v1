@if ($encomienda)
    <x-mary-modal wire:model="editEncomiendaModal" box-class="max-h-full max-w-4xl" title="Editar Encomienda"  separator>
        {{-- Información de restricciones --}}
        <div class="p-4 mb-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center gap-2">
                <x-mary-icon name="o-information-circle" class="text-blue-500" />
                <div class="text-sm text-blue-700">
                    <p class="font-semibold">Restricciones de Edición:</p>
                    <ul class="mt-1 space-y-1">
                        <li>• Solo se pueden editar encomiendas con tipo de comprobante <strong>TICKET</strong></li>
                        <li>• Solo se pueden editar encomiendas en estado <strong>REGISTRADO</strong> o <strong>RETORNADO</strong></li>
                        <li>• Los cambios se aplicarán inmediatamente al guardar</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Información de la Encomienda --}}
        <div class="p-4 mb-4 bg-gray-50 border border-gray-200 rounded-lg">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <span class="font-semibold text-gray-600">Código:</span>
                    <p class="text-gray-800">{{ $encomienda->code }}</p>
                </div>
                <div>
                    <span class="font-semibold text-gray-600">Estado:</span>
                    <p class="text-gray-800">{{ $encomienda->estado_encomienda }}</p>
                </div>
                <div>
                    <span class="font-semibold text-gray-600">Tipo Comprobante:</span>
                    <p class="text-gray-800">{{ $encomienda->tipo_comprobante }}</p>
                </div>
                <div>
                    <span class="font-semibold text-gray-600">Fecha Registro:</span>
                    <p class="text-gray-800">{{ $encomienda->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            {{-- Sección de Destinatario --}}
            <div class="p-4 border border-green-500 rounded-lg">
                @php
                    $tipoDocuments = [
                        ['codigo' => '0', 'sigla' => 'OTRO cod(0)'],
                        ['codigo' => '1', 'sigla' => 'DNI cod(1)'],
                        ['codigo' => '6', 'sigla' => 'RUC cod(6)'],
                    ];
                @endphp
                <div class="grid grid-cols-4 gap-3 p-4 bg-white rounded-lg shadow-sm">
                    <div class="col-span-4 md:col-span-2">
                        <x-mary-input label="Número de documento" wire:model='destinatario_code'
                            wire:keydown.enter="searchDestinatario" wire:keydown.ctrl.enter="next"
                            placeholder="Ingrese documento">
                            <x-slot:prepend>
                                <x-mary-select wire:model='destinatario_type_code' icon="o-user" option-value="codigo"
                                    option-label="sigla" :options="$tipoDocuments" class="rounded-e-none" />
                            </x-slot:prepend>
                            <x-slot:append>
                                <x-mary-button wire:click.prevent='searchDestinatario' icon="o-magnifying-glass"
                                    class="btn-primary rounded-s-none hover:bg-blue-600"
                                    tooltip="Buscar destinatario" />
                            </x-slot:append>
                        </x-mary-input>
                    </div>
                    <div class="col-span-4 md:col-span-2">
                        <x-mary-input label="Nombre/Razón Social" wire:model='destinatario_name'
                            placeholder="Nombre completo" />
                    </div>
                    <div class="col-span-4 md:col-span-2">
                        <div class="p-2 my-2 border rounded-lg border-sky-200 bg-sky-50">
                            <x-mary-toggle label="Reparto a domicilio" wire:model.live="isHome"
                                hint="Active para reparto a domicilio" />
                        </div>
                    </div>
                    @if ($isHome)
                        <div class="col-span-4 md:col-span-3">
                            <x-mary-input label="Dirección" wire:model='destinatario_address'
                                placeholder="Dirección completa" icon="o-home" />
                        </div>
                        <div class="col-span-4 md:col-span-1">
                            <x-mary-input label="Celular" wire:model='destinatario_phone' placeholder="999999999"
                                icon="o-device-phone-mobile" />
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 gap-3 p-2 bg-white rounded-lg shadow-sm md:grid-cols-4">
                @if($editingPaqueteId)
                    <div class="col-span-4 mb-2">
                        <x-mary-badge value="Editando paquete #{{ $editingPaqueteId }}" class="bg-blue-500 text-white" />
                    </div>
                @endif
                <div class="col-span-1 md:col-span-1">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-mary-input label="CANTIDAD" wire:model="cantidad" class="text-xs font-medium"
                                placeholder="0" />
                        </div>
                        <div>
                            <x-mary-select label="UNIDAD" :options="$unidadMedidas" wire:model="und_medida"
                                option-value="codigo" option-label="descripcion" placeholder="Seleccione" />
                        </div>
                    </div>
                </div>
                <div class="col-span-1 md:col-span-2">
                    <x-mary-input label="DESCRIPCIÓN" wire:model="description" placeholder="Descripción del paquete"
                        icon="o-clipboard-document-list" />
                </div>
                <div class="col-span-1 md:col-span-1">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-mary-input label="PESO" wire:model="peso" suffix="KG" locale="es-PE"
                                placeholder="0.00" />
                        </div>
                        <div>
                            <div class="flex flex-col">
                                <x-mary-input label="MONTO" wire:model="amount" suffix="S/"
                                    wire:keydown.enter="addPaquete" wire:keydown.ctrl.enter="addPaquete"
                                    placeholder="0.00" />
                                <div class="flex justify-end gap-2 mt-2">
                                                                        <x-mary-button icon="{{ $editingPaqueteId ? 'o-pencil' : 'o-plus' }}"
                                        wire:click='addPaquete'
                                        class="text-white rounded-lg {{ $editingPaqueteId ? 'bg-blue-500 hover:bg-blue-600' : 'bg-sky-500 hover:bg-sky-600' }}"
                                        tooltip="{{ $editingPaqueteId ? 'Actualizar paquete' : 'Agregar paquete' }}" />
                                    <x-mary-button icon="o-trash" wire:click='resetPaquete'
                                        wire:confirm="¿Está seguro de eliminar todos los paquetes?"
                                        class="text-white bg-red-500 hover:bg-red-600 rounded-lg"
                                        tooltip="Eliminar todos los paquetes" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-0">
                <x-mary-card shadow separator>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">Paquetes de la Encomienda</h3>
                        <div class="flex gap-2">
                            <x-mary-badge :value="'Total: ' . count($paquetes) . ' paquetes'" class="bg-blue-500" />
                            <x-mary-badge :value="'Monto: S/ ' . number_format($paquetes->sum('sub_total'), 2)" class="bg-green-500" />
                        </div>
                    </div>
                    <x-mary-table :headers="$headers_paquetes" :rows="$paquetes" striped hover
                        @row-click="$wire.restPaquete($event.detail.id)">
                        <x-slot:empty>
                            <div class="flex flex-col items-center justify-center py-6 space-y-2 text-gray-500">
                                <x-mary-icon name="o-cube" class="w-12 h-12" />
                                <p>No hay paquetes registrados</p>
                                <p class="text-sm">Agregue paquetes utilizando el formulario superior</p>
                            </div>
                        </x-slot:empty>
                                                @scope('actions', $paquete)
                            <div class="flex gap-1">
                                <x-mary-button icon="o-pencil" wire:click="editPaquete({{ $paquete->id }})"
                                    class="btn-sm text-white bg-blue-500 hover:bg-blue-600"
                                    tooltip="Editar paquete" />
                                <x-mary-button icon="o-trash" wire:click="restPaquete({{ $paquete->id }})"
                                    wire:confirm="¿Está seguro de eliminar este paquete?"
                                    class="btn-sm text-white bg-red-500 hover:bg-red-600"
                                    tooltip="Eliminar paquete" />
                            </div>
                        @endscope
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>

        {{-- Botones de Acción --}}
        <x-slot:actions>
            <div class="flex justify-end space-x-3">
                <x-mary-button label="Cancelar" @click="$wire.editEncomiendaModal = false"
                    class="bg-red-500 hover:bg-red-600" />
                <x-mary-button type="submit" wire:click="updateEncomienda" spinner="updateEncomienda"
                    label="Guardar Cambios" class="bg-blue-500 hover:bg-blue-600" />
            </div>
        </x-slot:actions>
    </x-mary-modal>
@endif
