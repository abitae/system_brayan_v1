<div>
@if ($show)
    <x-mary-modal wire:model="show" :persistent="$isClose" class="backdrop-blur" box-class="max-w-md">
        <div class="text-center py-2">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-warning/15">
                <x-mary-icon name="o-exclamation-triangle" class="w-10 h-10 text-warning" />
            </div>

            <h2 class="text-xl font-bold mb-2">Aviso de fin de suscripción</h2>

            <p class="text-base-content/70 mb-4">
                Su suscripción del sistema está por vencer o ha vencido.
                @if ($fechaVencimiento)
                    La fecha de vencimiento es
                    <span class="font-semibold text-base-content">{{ $fechaVencimiento }}</span>.
                @endif
                Contacte al administrador para renovar el servicio.
            </p>

            @unless ($isClose)
                <x-mary-button label="Entendido" wire:click="close" class="btn-primary" />
            @endunless
        </div>
    </x-mary-modal>
@endif
</div>
