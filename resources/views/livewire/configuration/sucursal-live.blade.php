<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-button wire:click='openModal' responsive icon="o-plus" label="Nuevo sucursal"
                class="text-white bg-sky-500" />
        </x-slot:menu>

    </x-mary-card>
    <div class="grid grid-cols-4 space-x-2">
        <div class="grid col-span-4 pt-2">
            <x-mary-card shadow separator>
                @php
                    $headers = [
                        ['key' => 'id', 'label' => '#', 'class' => 'bg-blue-500 w-1'],
                        ['key' => 'code', 'label' => 'Code', 'class' => ''],
                        ['key' => 'name', 'label' => 'Name', 'class' => ''],
                        ['key' => 'codeSunat', 'label' => 'Codigo Sunat', 'class' => ''],
                        ['key' => 'series', 'label' => 'Serie', 'class' => ''],
                        ['key' => 'color', 'label' => 'Color', 'class' => ''],
                        ['key' => 'isActive', 'label' => 'isActive', 'class' => ''],
                    ];
                    $row_decoration = [
                        'bg-red-50' => fn(App\Models\Configuration\Sucursal $sucursal) => !$sucursal->isActive,
                    ];
                @endphp
                <x-mary-table :headers="$headers" :rows="$sucursales" with-pagination per-page="perPage" :row-decoration="$row_decoration"
                    :per-page-values="[5, 20, 10, 50]">
                    @scope('cell_codeSunat', $sucursal)
                        <span class="text-xs text-gray-500">{{ $sucursal->codeSunat }}</span>
                    @endscope
                    @scope('cell_series', $sucursal)
                        <div class="grid grid-cols-2">
                            <span class="text-xs text-gray-500">Factura</span>
                            <span class="text-xs text-gray-500">{{ $sucursal->serieFactura }}</span>
                            <span class="text-xs text-gray-500">Boleta</span>
                            <span class="text-xs text-gray-500">{{ $sucursal->serieBoleta }}</span>
                            <span class="text-xs text-gray-500">Guia Remision Transporte</span>
                            <span class="text-xs text-gray-500">{{ $sucursal->serieGuiaRemision }}</span>
                            <span class="text-xs text-gray-500">NotaCreditoFactura</span>
                            <span class="text-xs text-gray-500">{{ $sucursal->serieNotaCreditoFactura }}</span>
                            <span class="text-xs text-gray-500">NotaCreditoBoleta</span>
                            <span class="text-xs text-gray-500">{{ $sucursal->serieNotaCreditoBoleta }}</span>
                            <span class="text-xs text-gray-500">NotaDebitoFactura</span>
                            <span class="text-xs text-gray-500">{{ $sucursal->serieNotaDebitoFactura }}</span>
                            <span class="text-xs text-gray-500">NotaDebitoBoleta</span>
                            <span class="text-xs text-gray-500">{{ $sucursal->serieNotaDebitoBoleta }}</span>
                        </div>
                    @endscope
                    @scope('cell_isActive', $stuff)
                        <button wire:click='estado({{ $stuff->id }})'
                            wire:confirm.prompt="Estas seguro de eliminar registro?\n\nEscriba 'SI' para confirmar!|SI"
                            class="flex items-center">
                            <div
                                class="h-2.5 w-2.5 rounded-full {{ $stuff->isActive ? 'bg-green-400' : 'bg-red-600' }} mr-2">
                            </div>
                            {{ $stuff->isActive ? 'Active' : 'Disabled' }}
                        </button>
                    @endscope
                    @scope('actions', $sucursal)
                        <nobr>
                            <x-mary-button icon="s-pencil-square" wire:click="update({{ $sucursal->id }})" spinner
                                class="btn-sm" />
                            <x-mary-button icon="o-trash" wire:click="delete({{ $sucursal->id }})"
                                wire:confirm.prompt="Estas seguro?\n\nEscribe DELETE para confirmar|DELETE" spinner
                                class="btn-sm" />
                        </nobr>
                    @endscope
                </x-mary-table>
            </x-mary-card>
        </div>
    </div>
    <x-mary-modal wire:model="modalSucursal" persistent class="backdrop-blur"
        box-class="max-w-6xl max-h-full overflow-y-auto">
        <x-mary-icon name="s-envelope" class="text-green-500 text-md"
            label="{{ !isset($sucursalForm->sucursal) ? 'CREAR SUCURSAL' : 'EDITAR SUCURSAL' }}" />
        <x-mary-form wire:submit.prevent="{{ !isset($sucursalForm->sucursal) ? 'create' : 'edit' }}">
            <div class="border border-green-500 rounded-lg">
                <div class="grid grid-cols-3 gap-2 p-2">
                    <x-mary-input label="Codigo" inline wire:model='sucursalForm.code' />
                    <x-mary-input label="Codigo Sunat" inline wire:model='sucursalForm.codeSunat' />
                    <x-mary-input label="IGV" inline wire:model='sucursalForm.igv' number />
                    <x-mary-colorpicker label="Color" inline wire:model='sucursalForm.color' />
                    <x-mary-input label="Nombre" inline wire:model='sucursalForm.name' />
                    <x-mary-input label="Departamento" inline wire:model='sucursalForm.departamento' />
                    <x-mary-input label="Provincia" inline wire:model='sucursalForm.provincia' />
                    <x-mary-input label="Distrito" inline wire:model='sucursalForm.distrito' />
                    <x-mary-input label="Urbanizacion" inline wire:model='sucursalForm.urbanizacion' />
                    <x-mary-input label="Direccion" inline wire:model='sucursalForm.address' />
                    <x-mary-input label="Telefono" inline wire:model='sucursalForm.phone' />
                    <x-mary-input label="Email" inline wire:model='sucursalForm.email' />
                    <x-mary-select label="Ubigeo" option-value="ubigeo2" option-label="texto_ubigeo"
                        placeholder="Select ubigeo" wire:model.live='sucursalForm.ubigeo' :options="$ubigeos"
                        class="max-w-sm" inline />
                </div>
                <div class="grid grid-cols-4 gap-2 p-2 bg-gray-100 border-t border-green-500">
                    <div class="col-span-4 text-center">Ingrese series a utilizar en los documentos electronicos</div>
                    <x-mary-input label="Serie Factura" inline wire:model='sucursalForm.serieFactura' />
                    <x-mary-input label="Serie Boleta" inline wire:model='sucursalForm.serieBoleta' />
                    <x-mary-input label="Serie Guia Remision" inline wire:model='sucursalForm.serieGuiaRemision' />
                    <x-mary-input label="Serie NotaCreditoFactura" inline
                        wire:model='sucursalForm.serieNotaCreditoFactura' />
                    <x-mary-input label="Serie NotaCreditoBoleta" inline
                        wire:model='sucursalForm.serieNotaCreditoBoleta' />
                    <x-mary-input label="Serie NotaDebitoFactura" inline
                        wire:model='sucursalForm.serieNotaDebitoFactura' />
                    <x-mary-input label="Serie NotaDebitoBoleta" inline
                        wire:model='sucursalForm.serieNotaDebitoBoleta' />
                </div>

            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.modalSucursal = false" class="bg-red-500" />
                <x-mary-button type="submit" spinner="{{ !isset($sucursalForm->sucursal) ? 'create' : 'edit' }}"
                    label="Save" class="bg-blue-500" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>
