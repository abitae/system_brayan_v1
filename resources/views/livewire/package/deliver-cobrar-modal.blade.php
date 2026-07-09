@if($encomienda)
    <x-mary-modal wire:model="modalCobrar" class="backdrop-blur" box-class="max-w-6xl max-h-full bg-gray-200" separator
        progress-indicator>
        <div class="p-2 space-y-4 ">
            <!-- Información de clientes -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 ">
                <!-- Remitente -->
                <div class="bg-white rounded-lg shadow-sm p-3 border-l-4 border-green-500">
                    <div class="flex items-center mb-2">
                        <x-mary-icon name="s-user" class="text-green-500 mr-2" />
                        <h3 class="font-bold text-green-700">REMITENTE</h3>
                    </div>
                    <div class="space-y-1 text-sm">
                        <p class="font-medium">{{ $encomienda->remitente->name ?? 'name' }}</p>
                        <p>{{ $encomienda->remitente->type_code == 1 ? 'DNI:' : 'RUC:' }}
                            {{ $encomienda->remitente->code ?? 'code' }}
                        </p>
                        @if ($encomienda->remitente->phone)
                            <p class="flex items-center"><x-mary-icon name="s-phone" class="text-gray-500 mr-1 h-4 w-4" />
                                {{ $encomienda->remitente->phone }}</p>
                        @endif
                    </div>
                </div>

                <!-- Destinatario -->
                <div class="bg-white rounded-lg shadow-sm p-3 border-l-4 border-blue-500">
                    <div class="flex items-center mb-2">
                        <x-mary-icon name="s-user" class="text-blue-500 mr-2" />
                        <h3 class="font-bold text-blue-700">DESTINATARIO</h3>
                    </div>
                    <div class="space-y-1 text-sm">
                        <p class="font-medium">{{ $encomienda->destinatario->name ?? 'name' }}</p>
                        <p>{{ $encomienda->destinatario->type_code == 1 ? 'DNI:' : 'RUC:' }}
                            {{ $encomienda->destinatario->code ?? 'code' }}
                        </p>
                        @if ($encomienda->destinatario->phone)
                            <p class="flex items-center"><x-mary-icon name="s-phone" class="text-gray-500 mr-1 h-4 w-4" />
                                {{ $encomienda->destinatario->phone }}</p>
                        @endif
                    </div>
                </div>


                <div class="bg-white rounded-lg shadow-sm p-3 border-l-4 border-purple-500">
                    <div class="flex items-center mb-2">
                        <x-mary-icon name="s-document-text" class="text-purple-500 mr-2" />
                        <h3 class="font-bold text-purple-700">DETALLE DE PAGO</h3>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Monto Original:</span>
                            <span class="font-medium">PEN {{ number_format($encomienda->monto, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-red-600">
                            <span>Descuento:</span>
                            @if ($monto_descuento && $monto_descuento < $encomienda->monto)
                                @if (is_numeric($monto_descuento))
                                    <span>- PEN {{ number_format($monto_descuento, 2) }}</span>
                                @else
                                    <span>NO VALIDO</span>
                                @endif
                            @else
                                <span>0.00</span>
                            @endif

                        </div>
                        <div class="border-t pt-2 flex justify-between items-center font-bold text-green-700">
                            <span>Monto Final:</span>
                            @if ($monto_descuento && $monto_descuento < $encomienda->monto)
                                @if (is_numeric($monto_descuento))
                                    <span>PEN {{ number_format($encomienda->monto - $monto_descuento, 2) }}</span>
                                @else
                                    <span>NO VALIDO</span>
                                @endif
                            @else
                                <span>PEN {{ number_format($encomienda->monto, 2) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalles de pago -->
            <div class="bg-white rounded-lg shadow-sm p-3">
                <div class="flex items-center mb-3">
                    <x-mary-icon name="s-credit-card" class="text-indigo-500 mr-2" />
                    <h3 class="font-bold text-indigo-700">DETALLE PAGO</h3>
                </div>
                @if ($cobroCredito ?? false)
                    <x-mary-alert icon="o-information-circle" class="alert-info mb-3"
                        title="Cobro de crédito"
                        description="Se registrará el pago en caja y la deuda quedará cancelada." />
                @endif
                @php
                    $tipo_pagos = [
                        ['id' => 'Contado', 'name' => 'Contado'],
                        ['id' => 'Credito', 'name' => 'Credito'],
                    ];
                    $comprobantes = [
                        ['id' => 'TICKET', 'name' => 'TICKET'],
                        ['id' => 'BOLETA', 'name' => 'BOLETA'],
                        ['id' => 'FACTURA', 'name' => 'FACTURA'],
                    ];
                    $metodoPagos = [
                        ['id' => 'Efectivo', 'name' => 'Efectivo'],
                        ['id' => 'Yape', 'name' => 'Yape'],
                        ['id' => 'Transferencia', 'name' => 'Transferencia'],
                        ['id' => 'Deposito', 'name' => 'Deposito'],
                    ];
                    $tipoDocuments = [
                        ['codigo' => '0', 'sigla' => 'OTRO DOCUMENTO cod(0)'],
                        ['codigo' => '1', 'sigla' => 'DNI cod(1)'],
                        ['codigo' => '6', 'sigla' => 'RUC cod(6)'],
                    ];
                @endphp
                <div class="w-full">
                    <div class="grid grid-cols-4 gap-1">
                        <div>
                            <x-mary-select label="Tipo de comprobante" icon="o-user" :options="$comprobantes"
                                wire:model.live="tipo_comprobante" class="rounded-r-lg" />
                        </div>
                        @if ($cobroCredito ?? false)
                            <div>
                                <x-mary-input label="Tipo pago" value="Contado (cobro de crédito)" readonly />
                            </div>
                            <div>
                                <x-mary-select label="Metodo de pago" icon="o-user" :options="$metodoPagos"
                                    wire:model.live="metodo_pago" class="rounded-r-lg" />
                            </div>
                        @else
                            <div>
                                <x-mary-select label="Tipo pago" icon="o-user" :options="$tipo_pagos"
                                    wire:model.live="tipo_pago" class="rounded-r-lg" />
                            </div>
                            @if ($tipo_pago == 'Contado')
                                <div>
                                    <x-mary-select label="Metodo de pago" icon="o-user" :options="$metodoPagos"
                                        wire:model.live="metodo_pago" class="rounded-r-lg" />
                                </div>
                            @endif
                        @endif
                        @if ($tipo_comprobante == 'TICKET')
                            <div>
                                <x-mary-input wire:model.live='monto_descuento' prefix="PEN" numeric label="Generar descuento"
                                    placeholder="Monto descuento" />
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            @if ($tipo_comprobante != 'TICKET')
                <div class="bg-white rounded-lg shadow-sm p-3">
                    <div class="flex items-center mb-3">
                        <x-mary-icon name="s-credit-card" class="text-indigo-500 mr-2" />
                        <h3 class="font-bold text-indigo-700">DETALLE FACTURACION</h3>
                    </div>
                    <div class="w-full">
                        <div class="grid grid-cols-4 gap-1">
                            <div class="grid col-span-4 md:col-span-2">
                                <x-mary-input label="Numero de documento" wire:model='cliFacturacion_code'>
                                    <x-slot:prepend>
                                        <x-mary-select wire:model.live='cliFacturacion_type_code' icon="o-user"
                                            option-value="codigo" option-label="sigla" :options="$tipoDocuments"
                                            class="rounded-e-none" />
                                    </x-slot:prepend>
                                    <x-slot:append>
                                        <x-mary-button wire:click='searchFacturacion' icon="o-magnifying-glass"
                                            class="btn-primary rounded-s-none" />
                                    </x-slot:append>
                                </x-mary-input>
                            </div>
                            <div class="grid col-span-4 md:col-span-2">
                                <x-mary-input label="Nombre/Raz. Social" wire:model='cliFacturacion_name' />
                            </div>
                            <div class="grid col-span-4 md:col-span-3">
                                <x-mary-input label="Direccion" wire:model='cliFacturacion_address' />
                            </div>
                            <div class="grid col-span-4 md:col-span-1">
                                <x-mary-input label="Celular" wire:model='cliFacturacion_phone' />
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <x-slot:actions>
            <div class="flex space-x-2">
                <x-mary-button label="Cancelar" @click="$wire.modalCobrar = false"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700" />
                <x-mary-button wire:click='cobrarEncomienda' label="Cobrar"
                    class="bg-orange-500 hover:bg-orange-700 text-white" spinner />
            </div>
        </x-slot:actions>
    </x-mary-modal>
@endif