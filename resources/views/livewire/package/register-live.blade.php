<div>
    @php
        $totalPaquetes = $paquetes->sum('sub_total');
        $cantidadPaquetes = $paquetes->sum('cantidad');
    @endphp

    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator progress-indicator>
        @if ($paquetes->isNotEmpty())
            <div class="mb-4 flex items-center justify-end gap-4 rounded-lg bg-warning/10 border border-warning/20 px-4 py-2">
                <div class="text-right">
                    <p class="text-[10px] uppercase font-semibold text-base-content/50">Bultos</p>
                    <p class="text-sm font-bold text-warning">{{ $cantidadPaquetes }}</p>
                </div>
                <div class="h-8 w-px bg-base-300/60"></div>
                <div class="text-right">
                    <p class="text-[10px] uppercase font-semibold text-base-content/50">Total</p>
                    <p class="text-sm font-bold text-primary">S/ {{ number_format($totalPaquetes, 2) }}</p>
                </div>
            </div>
        @endif

        <x-mary-steps wire:model="step" steps-color="step-primary"
            class="p-3 my-4 border rounded-xl border-base-300/60 bg-base-100 shadow-sm">
            {{-- PASO 1: REMITENTE --}}
            <x-mary-step step="1" text="Remitente">
                <div class="rounded-xl border border-base-300/60 bg-base-100 overflow-hidden">
                    <div class="flex items-center gap-3 px-4 py-3 bg-primary/5 border-b border-base-300/50">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/15">
                            <x-mary-icon name="o-user" class="w-5 h-5 text-primary" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-base-content">Datos del remitente</h3>
                            <p class="text-xs text-base-content/60">Busque por documento o complete manualmente</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 gap-4 p-4 md:p-5">
                        <div class="col-span-4 md:col-span-2">
                            <x-mary-input label="Número de documento" wire:model='remitente_code' wire:keydown.enter="searchRemitente" wire:keydown.ctrl.enter="next"
                                placeholder="Ingrese documento">
                                <x-slot:prepend>
                                    <x-mary-select wire:model='remitente_type_code' icon="o-user" :options="$tipoDocuments"
                                        option-value="codigo" option-label="sigla" class="rounded-e-none" />
                                </x-slot:prepend>
                                <x-slot:append>
                                    <x-mary-button wire:click='searchRemitente' icon="o-magnifying-glass"
                                        class="btn-primary rounded-s-none" tooltip="Buscar remitente" />
                                </x-slot:append>
                            </x-mary-input>
                        </div>
                        <div class="col-span-4 md:col-span-2">
                            <x-mary-input label="Nombre/Razón Social" wire:model='remitente_name'
                                placeholder="Nombre completo" />
                        </div>
                        <div class="col-span-4 md:col-span-3">
                            <x-mary-input label="Dirección" wire:model='remitente_address' placeholder="Dirección completa"
                                icon="o-home" />
                        </div>
                        <div class="col-span-4 md:col-span-1">
                            <x-mary-input label="Celular" wire:model='remitente_phone' placeholder="999999999"
                                icon="o-device-phone-mobile" />
                        </div>
                    </div>
                </div>
            </x-mary-step>

            {{-- PASO 2: DESTINATARIO --}}
            <x-mary-step step="2" text="Destinatario">
                <div class="rounded-xl border border-base-300/60 bg-base-100 overflow-hidden">
                    <div class="flex items-center gap-3 px-4 py-3 bg-info/5 border-b border-base-300/50">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-info/15">
                            <x-mary-icon name="o-map-pin" class="w-5 h-5 text-info" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-base-content">Datos del destinatario</h3>
                            <p class="text-xs text-base-content/60">Indique si el envío es a domicilio o agencia</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 gap-4 p-4 md:p-5">
                        <div class="col-span-4 md:col-span-2">
                            <x-mary-input label="Número de documento" wire:model='destinatario_code' wire:keydown.enter="searchDestinatario" wire:keydown.ctrl.enter="next"
                                placeholder="Ingrese documento">
                                <x-slot:prepend>
                                    <x-mary-select wire:model='destinatario_type_code' icon="o-user" option-value="codigo"
                                        option-label="sigla" :options="$tipoDocuments" class="rounded-e-none" />
                                </x-slot:prepend>
                                <x-slot:append>
                                    <x-mary-button wire:click.prevent='searchDestinatario' icon="o-magnifying-glass"
                                        class="btn-primary rounded-s-none" tooltip="Buscar destinatario" />
                                </x-slot:append>
                            </x-mary-input>
                        </div>
                        <div class="col-span-4 md:col-span-2">
                            <x-mary-input label="Nombre/Razón Social" wire:model='destinatario_name'
                                placeholder="Nombre completo" />
                        </div>
                        <div class="col-span-4">
                            <div class="flex items-center justify-between rounded-lg border border-info/20 bg-info/5 px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <x-mary-icon name="o-truck" class="w-5 h-5 text-info" />
                                    <div>
                                        <p class="text-sm font-medium">Reparto a domicilio</p>
                                        <p class="text-xs text-base-content/60">Active para entrega en la dirección del destinatario</p>
                                    </div>
                                </div>
                                <x-mary-toggle wire:model.live="isHome" />
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
            </x-mary-step>

            {{-- PASO 3: PAQUETES --}}
            <x-mary-step step="3" text="Paquetes">
                <div class="space-y-4">
                    <div class="rounded-xl border border-base-300/60 bg-base-100 overflow-hidden">
                        <div class="flex items-center justify-between gap-3 px-4 py-3 bg-warning/5 border-b border-base-300/50">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-warning/15">
                                    <x-mary-icon name="o-cube" class="w-5 h-5 text-warning" />
                                </div>
                                <div>
                                    <h3 class="font-semibold text-base-content">Agregar paquete</h3>
                                    <p class="text-xs text-base-content/60">Complete los datos y presione Enter o el botón +</p>
                                </div>
                            </div>
                            @if ($paquetes->isNotEmpty())
                                <div class="rounded-lg bg-warning/10 border border-warning/20 px-3 py-1.5 text-right">
                                    <p class="text-[10px] uppercase font-semibold text-base-content/50">Total acumulado</p>
                                    <p class="text-lg font-bold text-warning">S/ {{ number_format($totalPaquetes, 2) }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="grid grid-cols-12 items-end gap-2 p-4 md:p-5">
                            <div class="col-span-1">
                                <x-mary-input label="Cant." wire:model="cantidad" placeholder="0" />
                            </div>
                            <div class="col-span-2">
                                <x-mary-select label="Unidad" :options="$unidadMedidas" wire:model="und_medida"
                                    option-value="codigo" option-label="descripcion" placeholder="Seleccione" />
                            </div>
                            <div class="col-span-3">
                                <x-mary-input label="Descripción" wire:model="description" placeholder="Descripción"
                                    icon="o-clipboard-document-list" />
                            </div>
                            <div class="col-span-2">
                                <x-mary-input label="Peso" wire:model="peso" suffix="KG" locale="es-PE" placeholder="0.00" />
                            </div>
                            <div class="col-span-2">
                                <x-mary-input label="Monto" wire:model="amount" suffix="S/" wire:keydown.enter="addPaquete" wire:keydown.ctrl.enter="addPaquete"
                                    placeholder="0.00" />
                            </div>
                            <div class="col-span-2 flex items-center justify-end gap-1 pb-1">
                                <x-mary-button icon="o-plus" wire:click='addPaquete'
                                    class="btn-warning text-warning-content" tooltip="Agregar paquete" />
                                <x-mary-button icon="o-trash" wire:click='resetPaquete'
                                    class="btn-outline btn-error btn-sm" tooltip="Limpiar lista" />
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-base-300/60 bg-base-100 overflow-hidden">
                        <div class="flex items-center justify-between px-4 py-3 bg-base-200/40 border-b border-base-300/50">
                            <div class="flex items-center gap-2">
                                <x-mary-icon name="o-list-bullet" class="w-5 h-5 text-base-content/70" />
                                <div>
                                    <p class="font-semibold">Paquetes registrados</p>
                                    <p class="text-xs text-base-content/50">{{ $paquetes->count() }} ítem(s) en la lista</p>
                                </div>
                            </div>
                            @if ($paquetes->isNotEmpty())
                                <span class="badge badge-warning badge-lg font-bold">S/ {{ number_format($totalPaquetes, 2) }}</span>
                            @endif
                        </div>
                        <div class="p-2">
                            <x-mary-table :headers="$headers_paquetes" :rows="$paquetes" striped hover
                                @row-click="$wire.restPaquete($event.detail.id)">
                                <x-slot:empty>
                                    <div class="flex flex-col items-center justify-center py-10 space-y-3 text-base-content/50">
                                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-base-200">
                                            <x-mary-icon name="o-cube" class="w-8 h-8" />
                                        </div>
                                        <p class="font-medium">No hay paquetes registrados</p>
                                        <p class="text-sm">Agregue paquetes utilizando el formulario superior</p>
                                    </div>
                                </x-slot:empty>
                            </x-mary-table>
                        </div>
                    </div>
                </div>
            </x-mary-step>

            {{-- PASO 4: FACTURACIÓN --}}
            <x-mary-step step="4" text="Facturacion">
                <div class="rounded-xl border border-base-300/60 bg-base-100 overflow-hidden">
                    <div class="flex items-center gap-3 px-4 py-3 bg-secondary/5 border-b border-base-300/50">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-secondary/15">
                            <x-mary-icon name="o-credit-card" class="w-5 h-5 text-secondary" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-base-content">Datos de facturación</h3>
                            <p class="text-xs text-base-content/60">Configure el tipo de pago y comprobante</p>
                        </div>
                    </div>
                    <div class="p-4 md:p-5 space-y-4">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <x-mary-select label="Tipo de pago" icon="o-credit-card" :options="$pagos"
                                wire:model.live="estado_pago" class="w-full" />
                            @if ($estado_pago == 'PAGADO')
                                <x-mary-select label="Tipo de comprobante" icon="o-document-text" :options="$comprobantes"
                                    wire:model.live="tipo_comprobante" class="w-full" />
                                <x-mary-select label="Método de pago" icon="o-banknotes" :options="$metodoPagos"
                                    wire:model="metodo_pago" class="w-full" />
                            @endif
                        </div>

                        @if ($estado_pago == 'CONTRA ENTREGA')
                            <div class="flex items-center gap-2 rounded-lg border border-info/20 bg-info/5 px-4 py-3 text-sm text-info">
                                <x-mary-icon name="o-information-circle" class="w-5 h-5 shrink-0" />
                                <span>Contra entrega: se generará ticket y el pago queda pendiente al destinatario.</span>
                            </div>
                        @endif

                        @if ($tipo_comprobante != 'TICKET' && $estado_pago == 'PAGADO')
                            <div class="rounded-lg border border-base-300/50 bg-base-200/30 p-4 space-y-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-base-content/50">Cliente de facturación</p>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <x-mary-input label="Número de documento" wire:model='cliFacturacion_code' wire:keydown.enter="searchFacturacion"
                                        class="w-full">
                                        <x-slot:prepend>
                                            <x-mary-select wire:model.live='cliFacturacion_type_code'
                                                icon="o-identification" option-value="codigo" option-label="sigla"
                                                :options="$tipoDocuments" class="rounded-e-none" />
                                        </x-slot:prepend>
                                        <x-slot:append>
                                            <x-mary-button wire:click='searchFacturacion' icon="o-magnifying-glass"
                                                class="btn-primary rounded-s-none" />
                                        </x-slot:append>
                                    </x-mary-input>
                                    <x-mary-input label="Nombre/Razón Social" wire:model='cliFacturacion_name'
                                        icon="o-user" class="w-full" />
                                </div>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    <div class="md:col-span-2">
                                        <x-mary-input label="Dirección" wire:model='cliFacturacion_address' icon="o-map-pin"
                                            class="w-full" />
                                    </div>
                                    <div class="md:col-span-1">
                                        <x-mary-input label="Celular" wire:model='cliFacturacion_phone'
                                            icon="o-device-phone-mobile" class="w-full" />
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </x-mary-step>

            {{-- PASO 5: DESTINO --}}
            <x-mary-step step="5" text="Destino" data-content="✓" step-classes="!step-success">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="rounded-xl border border-base-300/60 bg-base-100 overflow-hidden">
                        <div class="flex items-center gap-3 px-4 py-3 bg-success/5 border-b border-base-300/50">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-success/15">
                                <x-mary-icon name="o-building-storefront" class="w-5 h-5 text-success" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-base-content">Sucursal destino</h3>
                                <p class="text-xs text-base-content/60">Seleccione agencia y confirme el PIN</p>
                            </div>
                        </div>
                        <div class="space-y-4 p-4 md:p-5">
                            <x-mary-select label="Sucursal Destino" icon="o-home-modern" :options="$sucursales"
                                wire:model.live="sucursal_dest_id" class="w-full" />
                            @if (!$isHome)
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="rounded-lg border border-base-300/50 bg-base-200/30 p-4">
                                        <x-mary-icon name="o-hashtag" label="PIN" class="mb-3" />
                                        <x-mary-pin ida="pin1" wire:model="pin1" size="3" hide hide-type="circle" />
                                    </div>
                                    <div class="rounded-lg border border-base-300/50 bg-base-200/30 p-4">
                                        <x-mary-icon name="o-hashtag" label="Confirmación" class="mb-3" />
                                        <x-mary-pin ida="pin2" wire:model="pin2" size="3" hide hide-type="circle" />
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-2 rounded-lg border border-success/20 bg-success/5 px-4 py-3 text-sm text-success">
                                    <x-mary-icon name="o-home" class="w-5 h-5 shrink-0" />
                                    <span>Envío a domicilio — no requiere PIN de agencia.</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-xl border border-base-300/60 bg-base-100 overflow-hidden">
                        <div class="flex items-center gap-3 px-4 py-3 bg-base-200/40 border-b border-base-300/50">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-base-300/50">
                                <x-mary-icon name="o-document-duplicate" class="w-5 h-5 text-base-content/70" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-base-content">Documentos de traslado</h3>
                                <p class="text-xs text-base-content/60">Opciones adicionales del envío</p>
                            </div>
                        </div>
                        <div class="space-y-3 p-4 md:p-5">
                            <div class="flex items-center justify-between rounded-lg border border-base-300/50 bg-base-200/30 px-4 py-3">
                                <div>
                                    <p class="text-sm font-medium">Retorno de guía</p>
                                    <p class="text-xs text-base-content/60">Active para retorno de guía</p>
                                </div>
                                <x-mary-toggle wire:model="isReturn" />
                            </div>
                            <div class="flex items-center justify-between rounded-lg border border-base-300/50 bg-base-200/30 px-4 py-3">
                                <div>
                                    <p class="text-sm font-medium">Documentos de traslado</p>
                                    <p class="text-xs text-base-content/60">Guías, facturas o boletas asociadas</p>
                                </div>
                                <x-mary-toggle wire:model.live="showDocTraslado" wire:change="$set('showDocTraslado', !$showDocTraslado)" />
                            </div>

                            @if($showDocTraslado)
                                <div class="rounded-lg border border-primary/20 bg-primary/5 p-4 space-y-3">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <x-mary-input label="Documento" wire:model="docTraslado" placeholder="Ej. F001-123"
                                            class="w-full" />
                                        <x-mary-input label="RUC del emisor" placeholder="20XXXXXXXXX"
                                            wire:model.live="emisorDocTraslado" class="w-full" />
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <x-mary-button icon="o-plus" label="Agregar" wire:click='addDocTraslado'
                                            class="btn-primary btn-sm text-primary-content" />
                                        <x-mary-button icon="o-no-symbol" label="Limpiar" wire:click='resetDocTraslado'
                                            class="btn-outline btn-error btn-sm" />
                                    </div>
                                    @php
                                        $headers_docsTraslado = [
                                            ['key' => 'tipoDoc', 'label' => 'Tipo'],
                                            ['key' => 'documento', 'label' => 'Documento'],
                                            ['key' => 'ruc', 'label' => 'RUC'],
                                        ];
                                    @endphp
                                    <x-mary-table :headers="$headers_docsTraslado" :rows="$docsTraslado" striped
                                        @row-click="$wire.deleteDocTraslado($event.detail.id)">
                                        <x-slot:empty>
                                            <p class="text-center text-sm text-base-content/50 py-4">Sin documentos agregados</p>
                                        </x-slot:empty>
                                    </x-mary-table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="rounded-xl border border-base-300/60 bg-base-100 overflow-hidden">
                            <div class="flex items-center gap-2 px-4 py-3 bg-base-200/40 border-b border-base-300/50">
                                <x-mary-icon name="o-chat-bubble-left-ellipsis" class="w-5 h-5 text-base-content/70" />
                                <h3 class="font-semibold text-sm">Observaciones</h3>
                            </div>
                            <div class="p-4">
                                <x-mary-textarea wire:model="observation"
                                    placeholder="Observaciones adicionales" hint="Máx. 1000 caracteres" rows="3"
                                    class="w-full" />
                            </div>
                        </div>

                        <div class="rounded-xl border border-base-300/60 bg-base-100 overflow-hidden">
                            <div class="flex items-center gap-2 px-4 py-3 bg-base-200/40 border-b border-base-300/50">
                                <x-mary-icon name="o-truck" class="w-5 h-5 text-base-content/70" />
                                <h3 class="font-semibold text-sm">Transporte</h3>
                            </div>
                            <div class="grid grid-cols-1 gap-3 p-4">
                                <x-mary-select label="Transportista" icon="o-user" :options="$transportistas"
                                    wire:model="transportista_id" />
                                <x-mary-select label="Vehículo" icon="o-truck" :options="$vehiculos"
                                    wire:model="vehiculo_id" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hidden">
                    <x-mary-textarea label="Glosa" wire:model="glosa" placeholder="Escribe una glosa"
                        hint="Max 1000 caracteres" rows="4" class="w-full" />
                </div>
            </x-mary-step>
        </x-mary-steps>

        <x-slot:actions>
            <div class="flex w-full items-center justify-between gap-3">
                <p class="hidden sm:block text-xs text-base-content/50">
                    <kbd class="kbd kbd-xs">Ctrl</kbd> + <kbd class="kbd kbd-xs">Enter</kbd> para avanzar en pasos con búsqueda
                </p>
                <div class="flex gap-2 ml-auto">
                    @if ($step != 1)
                        <x-mary-button label="Anterior" wire:click="prev" icon="o-arrow-left" class="btn-outline" />
                    @endif
                    @if ($step == 5)
                        <x-mary-button label="Confirmar registro" wire:click="finish" icon="o-check-circle"
                            class="btn-success text-success-content" />
                    @else
                        <x-mary-button label="Siguiente" wire:click="next" icon="o-arrow-right"
                            class="btn-primary text-primary-content" />
                    @endif
                </div>
            </div>
        </x-slot:actions>
    </x-mary-card>

    @include('livewire.package.register-modal')
    @include('livewire.package.register-final-modal')
</div>
