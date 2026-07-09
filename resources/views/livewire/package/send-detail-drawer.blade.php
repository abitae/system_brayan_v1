@if($encomienda)
    <x-mary-drawer wire:model="showDrawer" title="Detalle de encomienda" subtitle="Code {{ $encomienda->code }}" separator
        with-close-button close-on-escape class="w-11/12 lg:w-2/3" right>
        <x-mary-card shadow class="p-4">
            <div class="mb-6 transition-all duration-300 hover:translate-x-1">
                <x-mary-icon name="s-user" class="text-green-600 text-xl mb-2" label="REMITENTE" />
                <div
                    class="grid grid-cols-1 sm:grid-cols-5 grid-rows-auto sm:grid-rows-3 gap-2 bg-gradient-to-r from-green-100 to-green-200 rounded-lg p-3 shadow-sm border border-green-300">
                    <div class="col-span-full sm:col-span-3 font-medium text-lg">
                        {{ $encomienda->remitente->name ?? 'name' }}
                    </div>

                    <div class="flex items-center gap-1 sm:row-start-2">
                        <span
                            class="text-gray-600 text-sm">{{ $encomienda->remitente->type_code == 1 ? 'DNI' : 'RUC'}}:</span>
                        {{ $encomienda->remitente->code ?? 'code' }}
                    </div>
                    <div class="flex items-center gap-1 sm:row-start-2">
                        <x-mary-icon name="s-phone" class="text-gray-500 h-4 w-4" />
                        {{ $encomienda->remitente->phone ?? 'phone' }}
                    </div>
                    <div class="col-span-full sm:col-span-3 flex items-center gap-1">
                        <x-mary-icon name="o-map-pin" class="text-gray-500 h-4 w-4" />
                        {{ $encomienda->sucursal_remitente->name ?? 'sucursal' }}
                    </div>
                </div>
            </div>
            <div class="mb-6 transition-all duration-300 hover:translate-x-1">
                <x-mary-icon name="s-user" class="text-red-600 text-xl mb-2" label="DESTINATARIO" />
                <div
                    class="grid grid-cols-1 sm:grid-cols-5 grid-rows-auto sm:grid-rows-3 gap-2 bg-gradient-to-r from-red-50 to-red-100 rounded-lg p-3 shadow-sm border border-red-200">
                    <div class="col-span-full sm:col-span-3 font-medium text-lg">
                        {{ $encomienda->destinatario->name ?? 'name' }}
                    </div>
                    <div class="flex items-center gap-1 sm:row-start-2">
                        <span
                            class="text-gray-600 text-sm">{{ $encomienda->destinatario->type_code == 1 ? 'DNI' : 'RUC' }}:</span>
                        {{ $encomienda->destinatario->code ?? 'code' }}
                    </div>
                    <div class="flex items-center gap-1 sm:row-start-2">
                        <x-mary-icon name="s-phone" class="text-gray-500 h-4 w-4" />
                        {{ $encomienda->destinatario->phone ?? 'phone' }}
                    </div>
                    <div class="col-span-full sm:col-span-3 flex items-center gap-1">
                        <x-mary-icon name="o-map-pin" class="text-gray-500 h-4 w-4" />
                        {{ $encomienda->sucursal_destinatario->name ?? 'sucursal' }}
                    </div>
                </div>
            </div>

            <div class="transition-all duration-300 hover:translate-y-1">
                <x-mary-icon name="s-cube" class="text-blue-600 text-xl mb-2" label="DETALLE PAQUETES" />
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
        </x-mary-card>
    </x-mary-drawer>
@endif