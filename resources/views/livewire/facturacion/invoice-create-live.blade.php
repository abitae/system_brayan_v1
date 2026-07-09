<div>
    <x-mary-card title="{{ $title }} - {{ $tipoDoc == '03' ? 'BOLETA' : 'FACTURA' }}" subtitle="{{ $sub_title }}" separator class="max-w-6xl">
        <x-slot:menu>
            <p class="text-green-500 text-4xl font-bold">{{ $tipoDoc == '03' ? 'BOLETA' : 'FACTURA' }}</p>
            <x-mary-button @click="$wire.showHistory = true" icon="s-eye" label="Historial"
                class="text-white bg-purple-500" responsive />
        </x-slot:menu>
        @if ($errors->any())
        <x-mary-alert title="Error!" description="{{ $errors->first() }}" icon="o-exclamation-triangle"
            class="text-white bg-red-500" dismissible />
        @endif
        <div class="grid grid-cols-5 grid-rows-1 gap-4 p-2 mt-4 border border-green-500 rounded-lg">
            <div>
                <x-mary-select label="Tipo Doc." :options="$tipoDocs" option-value="codigo" option-label="descripcion"
                    wire:model.live="tipoDoc" class="max-w-sm" />
            </div>
            <div>
                <x-mary-select label="Tipo Oper." :options="$tipoOperaciones" option-value="codigo"
                    option-label="descripcion" wire:model.live="tipoOperacion" class="max-w-sm" />
            </div>
            <div>
                <x-mary-select label="Moneda" :options="$monedas" option-value="codigo" option-label="descripcion"
                    wire:model.live="moneda" class="max-w-sm" />
            </div>
            <div class="col-span-1">
                @if ($tipoOperacion == '1001')
                <x-mary-select label="Tipo Detraccion" :options="$tipoDetracciones" option-value="codigo"
                    option-label="descripcion" wire:model.live="tipoDetraccion" class="max-w-sm" />
                @endif
            </div>
            <div>
                <x-mary-input label="Guia Adjunta" wire:model.live="docAdjunto" class="max-w-sm" />
            </div>
        </div>
        <div class="grid grid-cols-3 grid-rows-2 gap-1 p-2 mt-4 border border-green-500 rounded-lg">
            <div>
                <x-mary-select label="Tipo Doc.Ident." icon="o-user" option-value="codigo" option-label="sigla"
                    :options="$tipoDocuments" wire:model.live="tipoDocumento" class="max-w-sm" />
            </div>
            <div>
                <x-mary-input label="Documento" wire:model.live="numDocumento" class="max-w-sm">
                    <x-slot:append>
                        <x-mary-button wire:click='buscarDocumento' icon="o-magnifying-glass"
                            class="btn-primary rounded-s-none" />
                    </x-slot:append>
                </x-mary-input>
            </div>
            <div>
                <x-mary-input label="Razon Social" wire:model.live='razonSocial' class="h-12 max-w-sm" />
            </div>
            <div class="row-start-2">
                <x-mary-input label="Direccion" wire:model.live='direccion' class="h-12 max-w-sm" />
            </div>
            <div class="row-start-2">
                <x-mary-select label="Ubigeo" option-value="ubigeo2" option-label="texto_ubigeo"
                    placeholder="Select ubigeo" wire:model.live='ubigeo' :options="$ubigeos" wire:model="selectedUser"
                    class="max-w-sm" />
            </div>
            <div class="row-start-2">
                <x-mary-input label="Telefono" wire:model.live='telefono' class="h-12 max-w-sm" />
            </div>
        </div>
        <div class="flex justify-end p-2 pt-4 pb-2 mt-2 border border-t border-green-500 rounded-lg">
            <div class="grid grid-cols-8 grid-rows-1 gap-1">
                <div>
                    <x-mary-input label="CANT." wire:model="cantidad" class="text-xs rounded-r-lg" />
                </div>
                <div>
                    <x-mary-select label="MEDIDA" :options="$unidadMedidas" wire:model="und_medida"
                        option-value="codigo" option-label="descripcion" />
                </div>
                <div class="col-span-3">
                    <x-mary-input label="DESCRIPCION" wire:model="description" class="rounded-r-lg" />
                </div>
                <div class="col-start-6">
                    <x-mary-input label="PESO (KG)" wire:model="peso" suffix="KG" locale="es-PE" />
                </div>
                <div class="col-start-7">
                    <x-mary-input label="MONTO" wire:model="amount" suffix="S/" />
                </div>
                <div class="flex items-end col-start-8">
                    <x-mary-button icon="o-plus" wire:click='addPaquete' class="text-white rounded-lg bg-sky-500" />
                    <x-mary-button icon="o-no-symbol" wire:click='resetPaquete'
                        class="text-white bg-red-500 rounded-lg" />
                </div>
            </div>
            <div class="grid grid-cols-8 gap-1">
                <div class="col-span-8">

                </div>
            </div>
        </div>
        <div class="p-2 pt-4 mt-2 mb-2 border border-t border-green-500 rounded-lg">
            <x-mary-table :headers="$headers_paquetes" :rows="$paquetes" striped
                @row-click="$wire.restPaquete($event.detail.id)">
                <x-slot:empty>
                    <x-mary-icon name="o-cube" label="No se encontro registros." />
                </x-slot:empty>
            </x-mary-table>
        </div>

        <div class="grid grid-cols-3 grid-rows-2 gap-1 p-2 border border-t border-green-500 rounded-lg">
            <div class="col-span-2">
                <x-mary-textarea label="Observación" wire:model="observacion" class="h-16 max-w-sm" />
            </div>

            <div class="col-start-3 row-span-3 row-start-1">
                <div class="grid grid-cols-2 gap-1 gap-y-2">
                    <div>Resumen</div>
                    <div></div>
                    <div class="border-t">Sub Total</div>
                    <div class="text-right border-t">S/ {{ $sub_total ? $sub_total : 0 }}</div>
                    <div class="border-t">IGV</div>
                    <div class="text-right border-t">S/ {{ $igv ? $igv : 0 }}</div>
                    <div class="border-t border-b"><strong>Total</strong></div>
                    <div class="text-xl text-right text-blue-500 border-t">S/ {{ $total ? $total : 0 }}</div>
                </div>
            </div>
        </div>
        <div class="flex justify-end">
            <x-mary-button wire:click='emitFactura' label="Guardar" icon="o-plus" class="btn-primary" />
        </div>
    </x-mary-card>
    @include('livewire.facturacion.print-invoice-modal')
</div>
