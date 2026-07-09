<div class="max-w-7xl mx-auto">
    <x-mary-card title="{{ $title }}" subtitle="{{ $sub_title }}" separator class="shadow-lg">
        <x-slot:menu>
            <x-mary-button wire:click='test' icon="s-eye" label="Historial"
                class="text-white bg-purple-500 hover:bg-purple-600 transition-colors" responsive />
        </x-slot:menu>

        @if ($errors->any())
            <x-mary-alert title="Error!" description="{{ $errors->first() }}" icon="o-exclamation-triangle"
                class="text-white bg-red-500 mb-4" dismissible />
        @endif

        {{-- Sección de Documento Afectado --}}
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Documento Afectado</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <x-mary-select label="Tipo Doc. Afectado" :options="$tipoDocs" option-value="codigo"
                        option-label="descripcion" wire:model.live="tipoDocAfectado" class="w-full" />
                </div>
                <div class="md:col-span-2">
                    <x-mary-choices-offline label="Serie y numero CEP" :options="$docElectronicos" wire:model.live="numDocfectado"
                        single searchable>
                        @scope('item', $numDocfectado)
                            {{ $numDocfectado->serie }} - {{ $numDocfectado->correlativo }}
                        @endscope
                        @scope('selection', $numDocfectado)
                            {{ $numDocfectado->serie }} - {{ $numDocfectado->correlativo }}
                        @endscope
                    </x-mary-choices-offline>
                </div>
                <div class="md:col-span-2">
                    <x-mary-select label="Tipo Doc." :options="$motivos" option-value="codigo" option-label="descripcion"
                        wire:model="motivo" class="w-full" />
                </div>
            </div>
        </div>

        {{-- Sección de Datos del Cliente --}}
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Datos del Cliente</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <x-mary-select label="Tipo Doc.Ident." icon="o-user" option-value="codigo" disabled readonly
                        option-label="sigla" :options="$tipoDocuments" wire:model.live="tipoDocumento" class="w-full" />
                </div>
                <div>
                    <x-mary-input label="Documento" wire:model.live="numDocumento" class="w-full" disabled>
                        <x-slot:append>
                            <x-mary-button wire:click='buscarDocumento' icon="o-magnifying-glass" disabled readonly
                                class="btn-primary rounded-s-none" />
                        </x-slot:append>
                    </x-mary-input>
                </div>
                <div>
                    <x-mary-input label="Razon Social" wire:model.live='razonSocial' class="w-full" disabled readonly />
                </div>
                <div>
                    <x-mary-input label="Direccion" wire:model.live='direccion' class="w-full" disabled readonly />
                </div>
                <div>
                    <x-mary-select label="Ubigeo" option-value="ubigeo2" option-label="texto_ubigeo"
                        placeholder="Seleccione ubigeo" wire:model.live='ubigeo' :options="$ubigeos" class="w-full"
                        disabled readonly />
                </div>
                <div>
                    <x-mary-input label="Telefono" wire:model.live='telefono' class="w-full" disabled readonly />
                </div>
            </div>
        </div>

        {{-- Tabla de Paquetes --}}
        <div wire:ignore.self class="bg-white rounded-lg shadow p-4 mb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Detalle de Paquetes</h3>
            <x-mary-table :headers="$headers_paquetes" :rows="$paquetes" striped hoverable>
                <x-slot:empty>
                    <div class="text-center py-4">
                        <x-mary-icon name="o-cube" class="text-gray-400 text-4xl mb-2" />
                        <p class="text-gray-500">No se encontraron registros</p>
                    </div>
                </x-slot:empty>
            </x-mary-table>
        </div>

        {{-- Resumen y Observaciones --}}
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <x-mary-textarea label="Observación" wire:model="observacion" class="h-32 w-full" />
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold mb-4 text-gray-700">Resumen</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between border-b pb-2">
                            <span>Sub Total</span>
                            <span class="font-medium">S/ {{ number_format($sub_total ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span>IGV</span>
                            <span class="font-medium">S/ {{ number_format($igv ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between pt-2">
                            <span class="font-bold">Total</span>
                            <span class="text-xl font-bold text-blue-600">S/ {{ number_format($total ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <x-mary-button wire:click='emitNote' label="Guardar" icon="o-plus"
                class="btn-primary hover:bg-blue-600 transition-colors" />
        </div>
    </x-mary-card>
    @if ($note)
        <x-mary-modal wire:model="modalPrintNote" title="Nota de Crédito" separator>
            <div class="p-4">
                <div class="text-center mb-4">
                    <x-mary-icon name="o-document-check" class="text-green-500 text-5xl mb-2" />
                    <h3 class="text-xl font-semibold text-gray-700">Nota de Crédito Generada</h3>
                    <p class="text-gray-500">La nota de crédito ha sido generada exitosamente</p>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">Serie:</span>
                        <span>{{ $note->serie ?? '' }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">Correlativo:</span>
                        <span>{{ $note->correlativo ?? '' }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">Total:</span>
                        <span class="font-bold text-blue-600">S/
                            {{ number_format($note->mtoImpVenta ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>

            <x-slot:actions>
                <x-mary-button label="Cerrar" wire:click="closePrintNote" class="btn-ghost" />
                <x-mary-button target="_blank" label="Descargar PDF" icon="o-document-arrow-down"
                    class="btn-primary" link="/note/a4/{{ $note->id }}" no-wire-navigate spinner/>
            </x-slot:actions>
        </x-mary-modal>
    @endif
</div>
