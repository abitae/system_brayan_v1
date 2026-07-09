@if ($this->destinatario && $this->remitente && $this->cliFacturacion && $this->paquetes)
    <x-mary-modal wire:model="modalConfimation" class="backdrop-blur" box-class="max-w-6xl max-h-full" separator progress-indicator>
        <div class="flex items-center gap-3 mb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-warning/15">
                <x-mary-icon name="o-clipboard-document-check" class="w-5 h-5 text-warning" />
            </div>
            <div>
                <p class="font-bold text-lg">Confirmar encomienda</p>
                <p class="text-xs text-base-content/60">Revise los datos antes de registrar</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="rounded-xl border border-success/30 bg-success/5 p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <x-mary-icon name="s-user" class="text-success w-5 h-5" />
                        <h3 class="font-bold text-success text-sm uppercase tracking-wide">Remitente</h3>
                    </div>
                    <div class="space-y-1 text-sm">
                        <p class="font-semibold">{{ $this->remitente->name ?? 'name' }}</p>
                        <p class="text-base-content/70">{{ $this->remitente->type_code == 1 ? 'DNI' : 'RUC' }}: {{ $this->remitente->code ?? 'code' }}</p>
                        @if ($this->remitente->phone)
                            <p class="flex items-center gap-1 text-base-content/60">
                                <x-mary-icon name="s-phone" class="h-4 w-4" /> {{ $this->remitente->phone }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="rounded-xl border border-info/30 bg-info/5 p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <x-mary-icon name="s-user" class="text-info w-5 h-5" />
                        <h3 class="font-bold text-info text-sm uppercase tracking-wide">Destinatario</h3>
                    </div>
                    <div class="space-y-1 text-sm">
                        <p class="font-semibold">{{ $this->destinatario->name ?? 'name' }}</p>
                        <p class="text-base-content/70">{{ $this->destinatario->type_code == 1 ? 'DNI' : 'RUC' }}: {{ $this->destinatario->code ?? 'code' }}</p>
                        @if ($this->destinatario->phone)
                            <p class="flex items-center gap-1 text-base-content/60">
                                <x-mary-icon name="s-phone" class="h-4 w-4" /> {{ $this->destinatario->phone }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="rounded-xl border border-secondary/30 bg-secondary/5 p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <x-mary-icon name="s-document-text" class="text-secondary w-5 h-5" />
                        <h3 class="font-bold text-secondary text-sm uppercase tracking-wide">Facturación</h3>
                    </div>
                    <div class="space-y-1 text-sm">
                        <p class="font-semibold">{{ $this->cliFacturacion->name ?? 'name' }}</p>
                        <p class="text-base-content/70">{{ $this->cliFacturacion->type_code == 1 ? 'DNI' : 'RUC' }}: {{ $this->cliFacturacion->code ?? 'code' }}</p>
                        @if ($this->cliFacturacion->phone)
                            <p class="flex items-center gap-1 text-base-content/60">
                                <x-mary-icon name="s-phone" class="h-4 w-4" /> {{ $this->cliFacturacion->phone }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-base-300/60 bg-base-100 p-4">
                <div class="flex items-center gap-2 mb-4">
                    <x-mary-icon name="s-credit-card" class="text-primary w-5 h-5" />
                    <h3 class="font-bold text-sm uppercase tracking-wide">Detalle de pago</h3>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div class="rounded-lg bg-base-200/50 p-3">
                        <x-mary-stat title="Estado pago" value="{{ $this->estado_pago }}" icon="s-banknotes"
                            tooltip="Pagado o Contra entrega" />
                    </div>
                    <div class="rounded-lg bg-base-200/50 p-3">
                        <x-mary-stat title="Tipo comprobante" value="{{ $this->tipo_comprobante }}" icon="s-document"
                            tooltip="Ticket, Boleta, Factura" />
                    </div>
                    <div class="rounded-lg bg-base-200/50 p-3">
                        <x-mary-stat title="Método de pago" value="{{ strtoupper($this->metodo_pago) }}" icon="s-currency-dollar"
                            tooltip="Método de pago" />
                    </div>
                    <div class="rounded-lg bg-base-200/50 p-3">
                        @if ($isHome)
                            @if ($isReturn)
                                <x-mary-stat title="Entrega" value="RETORNO" icon="s-arrow-path" tooltip="Retorno de encomienda" />
                            @else
                                <x-mary-stat title="Entrega" value="DOMICILIO" icon="s-home" tooltip="Reparto a domicilio" />
                            @endif
                        @else
                            <x-mary-stat title="Entrega" value="AGENCIA" icon="o-building-storefront" tooltip="Reparto a agencia" />
                        @endif
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-base-300/60 bg-base-100 overflow-hidden">
                <div class="flex items-center justify-between px-4 py-3 bg-warning/5 border-b border-base-300/50">
                    <div class="flex items-center gap-2">
                        <x-mary-icon name="s-cube" class="text-warning w-5 h-5" />
                        <h3 class="font-bold text-sm uppercase tracking-wide">Detalle de paquetes</h3>
                    </div>
                    <span class="badge badge-warning badge-lg font-bold">
                        Total: S/ {{ number_format($paquetes->sum('sub_total'), 2) }}
                    </span>
                </div>
                <div class="p-2 overflow-x-auto">
                    <x-mary-table :headers="$headers_paquetes" :rows="$paquetes" striped hover />
                </div>
            </div>
        </div>

        <x-slot:actions>
            <x-mary-button label="Cancelar" @click="$wire.modalConfimation = false"
                class="btn-outline" icon="o-x-mark" />
            <x-mary-button wire:click='confirmEncomienda' label="Confirmar registro"
                class="btn-success text-success-content" icon="o-check" spinner />
        </x-slot:actions>
    </x-mary-modal>
@endif
