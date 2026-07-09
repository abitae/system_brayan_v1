@if($encomienda)
    <x-mary-modal without-trap-focus title="Editar Encomienda" wire:model="editModal">
        <div class="space-y-4">
            {{-- Sección de Destinatario --}}
            <div class="p-4 border border-green-500 rounded-lg">
                <x-mary-icon name="s-user" class="text-green-500 text-md" label="INFORMACIÓN DEL DESTINATARIO" />

                <div class="grid grid-cols-4 gap-3 mt-3">
                    {{-- Documento Destinatario --}}
                    <div class="col-span-4">
                        <x-mary-input label="Número de documento" wire:model='customerFormDest.code'>
                            <x-slot:prepend>
                                <x-mary-select
                                    wire:model='customerFormDest.type_code'
                                    icon="o-user"
                                    :options="[
                                        ['id' => 'dni', 'name' => 'DNI'],
                                        ['id' => 'ruc', 'name' => 'RUC'],
                                        ['id' => 'ce', 'name' => 'CE'],
                                        ['id' => 'pas', 'name' => 'PAS']
                                    ]"
                                    class="rounded-e-none"
                                />
                            </x-slot:prepend>
                            <x-slot:append>
                                <x-mary-button
                                    wire:click='searchDestinatario'
                                    icon="o-magnifying-glass"
                                    class="btn-primary rounded-s-none"
                                />
                            </x-slot:append>
                        </x-mary-input>
                    </div>

                    {{-- Datos Personales --}}
                    <div class="col-span-3">
                        <x-mary-input label="Nombre/Razón Social" wire:model='customerFormDest.name' required />
                    </div>
                    <div class="col-span-1">
                        <x-mary-input label="Teléfono" wire:model='customerFormDest.phone' type="tel" />
                    </div>
                </div>

                {{-- Opciones de Entrega --}}
                <div class="mt-4 space-y-4">
                    <x-mary-toggle
                        label="Reparto a domicilio"
                        wire:model.live="isHome"
                        hint="Active para reparto a domicilio"
                    />

                    @if ($isHome)
                        <div class="grid grid-cols-4 gap-3">
                            <div class="col-span-3">
                                <x-mary-input label="Dirección de entrega" wire:model='customerFormDest.address' required />
                            </div>
                            <div class="col-span-1">
                                <x-mary-input label="Referencia" wire:model='customerFormDest.reference' />
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sección de Envío --}}
            <div class="p-4 border border-blue-500 rounded-lg">
                <x-mary-icon name="s-truck" class="text-blue-500 text-md" label="DETALLES DEL ENVÍO" />

                <div class="grid grid-cols-4 gap-3 mt-3">
                    <div class="col-span-2">
                        @php
                            $sucursales = \App\Models\Configuration\Sucursal::all();
                        @endphp
                        <x-mary-select
                            label="Sucursal de Origen"
                            wire:model="sucursal_origen_id"
                            :options="$sucursales"
                            option-label="name"
                            option-value="id"
                            required
                        />
                    </div>
                    <div class="col-span-2">
                        <x-mary-select
                            label="Sucursal de Destino"
                            wire:model="sucursal_destino_id"
                            :options="$sucursales"
                            option-label="name"
                            option-value="id"
                            required
                        />
                    </div>

                    {{-- Estado del Envío --}}
                    <div class="col-span-2">
                        <x-mary-select
                            label="Estado del Envío"
                            wire:model="estado"
                            :options="[
                                ['id' => 'PENDIENTE', 'name' => 'Pendiente'],
                                ['id' => 'EN_TRANSITO', 'name' => 'En Tránsito'],
                                ['id' => 'ENTREGADO', 'name' => 'Entregado'],
                                ['id' => 'CANCELADO', 'name' => 'Cancelado']
                            ]"
                            required
                        />
                    </div>
                    <div class="col-span-2">
                        <x-mary-input
                            type="datetime-local"
                            label="Fecha Estimada de Entrega"
                            wire:model="fecha_entrega_estimada"
                        />
                    </div>

                    {{-- Observaciones --}}
                    <div class="col-span-4">
                        <x-mary-textarea
                            label="Observaciones"
                            wire:model="observaciones"
                            rows="3"
                            placeholder="Ingrese cualquier observación relevante sobre el envío..."
                        />
                    </div>
                </div>
            </div>
        </div>

        {{-- Botones de Acción --}}
        <x-slot:actions>
            <div class="flex justify-end space-x-3">
                <x-mary-button
                    label="Cancelar"
                    @click="$wire.editModal = false"
                    class="bg-red-500 hover:bg-red-600"
                />
                <x-mary-button
                    type="submit"
                    wire:click="updateEncomienda"
                    spinner="updateEncomienda"
                    label="Guardar Cambios"
                    class="bg-blue-500 hover:bg-blue-600"
                />
            </div>
        </x-slot:actions>
    </x-mary-modal>
@endif