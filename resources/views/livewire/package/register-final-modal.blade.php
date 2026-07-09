@if ($this->encomienda)
    <x-mary-modal wire:model.live="modalFinal" persistent class="backdrop-blur" box-class="max-w-4xl">
        <div class="text-center mb-6">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-success/15">
                <x-mary-icon name="o-check-circle" class="w-10 h-10 text-success" />
            </div>
            <h2 class="text-2xl font-bold text-success mb-1">¡Encomienda registrada!</h2>
            <p class="text-base-content/60">Código: <span class="font-mono font-semibold text-primary">{{ $this->encomienda->code }}</span></p>
            <div class="mt-3 mx-auto h-1 w-24 rounded-full bg-success/30"></div>
        </div>

        <div class="space-y-4">
            <div class="rounded-xl border border-base-300/60 bg-base-100 p-4">
                <h3 class="text-sm font-semibold uppercase tracking-wide text-base-content/70 mb-3 flex items-center gap-2">
                    <x-mary-icon name="o-printer" class="w-5 h-5 text-primary" />
                    Documentos para imprimir
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @if ($this->encomienda->ticket)
                        <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="Ticket"
                            link="/ticket/80mm/{{ $this->encomienda->ticket->id }}" spinner
                            class="w-full btn-info text-info-content" />
                    @endif
                    @if ($this->encomienda->invoice)
                        <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="Recibo"
                            link="/invoice/80mm/{{ $this->encomienda->invoice->id }}" spinner
                            class="w-full btn-secondary text-secondary-content" />
                    @endif
                    @if ($this->encomienda->despatche)
                        <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="Guía T"
                            link="/despache/80mm/{{ $this->encomienda->despatche->id }}" spinner
                            class="w-full btn-success text-success-content" />
                    @endif
                    <x-mary-button icon="o-printer" target="_blank" no-wire-navigate label="Sticker"
                        link="/sticker/a5/{{ $this->encomienda->id }}" spinner
                        class="w-full btn-primary text-primary-content" />
                </div>
            </div>

            <div class="rounded-xl border border-base-300/60 bg-base-100 p-4">
                <h3 class="text-sm font-semibold uppercase tracking-wide text-base-content/70 mb-3 flex items-center gap-2">
                    <x-mary-icon name="o-arrow-right-circle" class="w-5 h-5 text-primary" />
                    Acciones disponibles
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <x-mary-button icon="o-plus-circle" link="{{ route('package.register') }}" spinner
                        label="Nueva encomienda" class="w-full btn-primary text-primary-content" />
                    <x-mary-button icon="s-list-bullet" link="{{ route('package.send') }}" spinner
                        label="Lista encomiendas" class="w-full btn-secondary text-secondary-content" />
                    <x-mary-button icon="o-cursor-arrow-ripple" link="{{ route('package.deliver') }}" no-wire-navigate
                        label="Entregar" spinner class="w-full btn-info text-info-content" />
                    <x-mary-button icon="o-arrow-down-on-square" link="/declaracion/{{ $this->encomienda->id }}" target="_blank" no-wire-navigate
                        label="Declaración jurada" class="w-full btn-outline" />
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            <x-mary-button link="{{ route('package.register') }}" label="Cerrar" icon="o-x-mark"
                class="btn-ghost" />
        </div>
    </x-mary-modal>
@endif
