@if($encomienda)
    <x-mary-modal wire:model="modalConfimation" persistent class="backdrop-blur"
        box-class="max-w-full max-h-full bg-purple-50">
        <div class="grid grid-cols-8 gap-2 p-2 border roundedlg border-sky-500">
            <div class="grid col-span-4">
                <div class="grid grid-cols-8 border rounded-lg border-sky-500">
                    <div class="grid col-span-8">
                        <x-mary-card shadow>
                            <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="REMITENTE" />
                            <div class="grid grid-cols-5 grid-rows-3 gap-1 bg-green-200 rounded">
                                <div class="col-span-3">{{ $encomienda->remitente->name ?? 'name' }}
                                </div>
                                <div class="row-start-2">
                                    {{ $encomienda->remitente->type_code ? 'DNI' : 'RUC' }}
                                </div>
                                <div class="row-start-2">{{ $encomienda->remitente->code ?? 'code' }}
                                </div>
                                <div class="row-start-2">{{ $encomienda->remitente->phone ?? 'phone' }}
                                </div>
                                <div class="col-span-3">{{ $encomienda->sucursal_remitente->name ??
            'sucursal' }}
                                </div>
                            </div>
                            <x-mary-icon name="s-envelope" class="text-red-500 text-md" label="DESTINATARIO" />
                            <div class="grid grid-cols-5 grid-rows-3 gap-1 bg-red-100 rounded">
                                <div class="col-span-3">{{ $encomienda->destinatario->name ?? 'name' }}
                                </div>
                                <div class="row-start-2">
                                    {{ $encomienda->destinatario->type_code ? 'DNI' : 'RUC' }}
                                </div>
                                <div class="row-start-2">{{ $encomienda->destinatario->code ?? 'code' }}
                                </div>
                                <div class="row-start-2">{{ $encomienda->destinatario->phone ?? 'phone'
                                                }}</div>
                                <div class="col-span-3">{{ $encomienda->sucursal_destino->name ??
            'sucursal' }}</div>
                            </div>
                            <x-mary-icon name="s-envelope" class="text-sky-500 text-md" label="DETALLE PAQUETES" />
                            @php
                                $headers_paquets = [
                                    ['key' => 'cantidad', 'label' => 'Cantidad', 'class' => ''],
                                    ['key' => 'description', 'label' => 'Descripción', 'class' => ''],
                                    ['key' => 'peso', 'label' => 'Peso', 'class' => ''],
                                    ['key' => 'amount', 'label' => 'P.UNIT', 'class' => ''],
                                    ['key' => 'sub_total', 'label' => 'MONTO', 'class' => ''],
                                ];
                            @endphp
                            <x-mary-table :headers="$headers_paquets" :rows="$encomienda->paquetes" striped>
                            </x-mary-table>
                            <x-mary-card shadow>
                                <div class="grid grid-cols-2 gap-2 border rounded-lg border-sky-500">
                                    <div class="text-xl text-right">Resumen</div>
                                    <div></div>
                                    <div class="text-right">Sub Total</div>
                                    <div class="text-right border-t">
                                        S/{{ number_format($encomienda->monto, 2) }}
                                    </div>
                                    <div class="text-right">Descuento</div>
                                    <div class="text-right border-t">
                                        S/{{ number_format($encomienda->monto_descuento ?? 0, 2) }}
                                    </div>
                                    <div class="text-right">Total</div>
                                    <div class="text-xl text-right text-blue-500 border-t">
                                        S/{{ number_format($encomienda->monto -
            $encomienda->monto_descuento ?? 0, 2) }}
                                    </div>
                                </div>
                            </x-mary-card>
                        </x-mary-card>
                    </div>
                </div>
            </div>
            <div class="grid col-span-4 space-x-2">
                <div class="grid grid-cols-8 border rounded-lg border-sky-500">
                    <div class="grid col-span-8 space-y-2">
                        <x-mary-card shadow>
                            <x-mary-icon name="s-envelope" class="text-blue-500 text-md" label="DETALLE PAGO" />
                            <x-mary-radio class="w-full max-w-full py-0 text-xs" :options="$pagos" option-value="id"
                                option-label="name" wire:model.live="estado_pago" disabled />
                            @if ($estado_pago == 'CONTRA ENTREGA')
                                            <x-mary-icon name="s-envelope" class="text-red-500 text-md" label="TIPO COMPROBANTE" />
                                            <x-mary-radio class="w-full max-w-full py-0 text-xs" :options="$comprobantes" option-value="id"
                                                option-label="name" wire:model.live="tipo_comprobante" />
                                            @if ($tipo_comprobante != 'TICKET')
                                                            <x-mary-icon name="s-envelope" class="text-green-500 text-md" label="DETALLE COMPROBANTE" />
                                                            <div class="grid grid-cols-4 gap-2 p-2 border rounded-lg border-sky-500">
                                                                <div class="grid col-span-4 pt-2">
                                                                    <x-mary-input label="Numero de documento" wire:model.live='customerFact.code'>
                                                                        <x-slot:prepend>
                                                                            @php
                                                                                if ($tipo_comprobante != 'FACTURA') {
                                                                                    $docsfact = [
                                                                                        ['id' => '1', 'name' => 'DNI'],
                                                                                        ['id' => '6', 'name' => 'RUC'],
                                                                                    ];
                                                                                } else {
                                                                                    $docsfact = [['6' => 'ruc', 'name' => 'RUC']];
                                                                                }
                                                                            @endphp
                                                                            <x-mary-select wire:model.live='customerFact.type_code' icon="o-user"
                                                                                :options="$docsfact" class="rounded-e-none" />
                                                                        </x-slot:prepend>
                                                                        <x-slot:append>
                                                                            <x-mary-button wire:click='searchFacturacion' icon="o-magnifying-glass"
                                                                                class="btn-primary rounded-s-none" />
                                                                        </x-slot:append>
                                                                    </x-mary-input>
                                                                </div>
                                                                <div class="grid col-span-2 pt-2">
                                                                    <x-mary-input label="Nombre/Raz. Social" wire:model.live='customerFact.name'>
                                                                    </x-mary-input>
                                                                </div>
                                                                <div class="grid col-span-2 pt-2">
                                                                    <x-mary-input label="Direccion" wire:model.live='customerFact.address'>
                                                                    </x-mary-input>
                                                                </div>
                                                            </div>
                                            @endif
                            @endif
                            @include('livewire.package.descuento')
                        </x-mary-card>
                    </div>
                </div>
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.modalConfimation = false" />
                <x-mary-button wire:click='confirmEncomienda' label="Entregar" class="btn-primary" />
            </x-slot:actions>
        </div>
    </x-mary-modal>
    <x-mary-modal wire:model.live="modalFinal" persistent class="backdrop-blur" box-class="w-full">
        <x-mary-card shadow>
            <div class="grid grid-cols-4 gap-0 border-sky-500">
                <div>
                    @if ($this->encomienda->ticket)
                        <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="TICKET"
                            link="/ticket/80mm/{{ $this->encomienda->ticket->id }}" spinner
                            class="text-white bg-green-500 btn-xl" />
                    @endif
                </div>
                <div>
                    @if ($this->encomienda->invoice)
                        <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="RECIBO"
                            link="/invoice/80mm/{{ $this->encomienda->invoice->id }}" spinner
                            class="text-white bg-cyan-500 btn-xl" />
                    @endif
                </div>
                <div>
                    @if ($this->encomienda->despatche)
                        <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="GUIA T"
                            link="/despache/80mm/{{ $this->encomienda->despatche->id }}" spinner
                            class="text-white bg-blue-500 btn-xl" />
                    @endif
                </div>
                <div>
                </div>
                <div>
                    <x-mary-button icon="o-clipboard" link="{{ route('package.register') }}" spinner label="NUEVO"
                        class="text-white bg-blue-500 btn-xl" />
                </div>
                <div>
                    <x-mary-button icon="s-list-bullet" link="{{ route('package.send') }}" spinner label="LISTA E"
                        class="text-white bg-blue-500 btn-xl" />
                </div>
                <div>
                    <x-mary-button icon="o-cursor-arrow-ripple" link="{{ route('package.deliver') }}" no-wire-navigate
                        label="ENTREGAR" spinner class="text-white bg-blue-500 btn-xl" />
                </div>
                <div>
                    <x-mary-button icon="o-banknotes" link="{{ route('caja.index') }}" no-wire-navigate label="VER CAJA"
                        spinner class="text-white bg-blue-500 btn-xl" />
                </div>
            </div>
        </x-mary-card>
    </x-mary-modal>
@endif