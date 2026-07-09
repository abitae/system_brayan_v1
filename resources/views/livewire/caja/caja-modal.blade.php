{{-- Modal abrir / cerrar caja --}}
<x-mary-modal wire:model="modalCaja" persistent class="backdrop-blur" box-class="max-w-md">
    <div class="flex items-center gap-3 mb-4">
        <div class="flex h-10 w-10 items-center justify-center rounded-full {{ $openCaja ? 'bg-error/15 text-error' : 'bg-success/15 text-success' }}">
            <x-mary-icon name="{{ $openCaja ? 'o-lock-closed' : 'o-lock-open' }}" class="w-5 h-5" />
        </div>
        <div>
            <h3 class="font-bold text-lg">{{ $openCaja ? 'Cerrar caja' : 'Abrir caja' }}</h3>
            <p class="text-sm text-base-content/60">
                {{ $openCaja ? 'Confirma el monto en efectivo para cerrar la sesión' : 'Ingresa el monto inicial en efectivo' }}
            </p>
        </div>
    </div>

    @if ($openCaja && $caja)
        <x-mary-alert icon="o-information-circle" class="alert-info mb-4"
            description="Saldo efectivo calculado: S/. {{ number_format($caja->monto_apertura + $caja->entries->where('metodo_pago', 'Efectivo')->sum('monto_entry') - $caja->exits->where('metodo_pago', 'Efectivo')->sum('monto_exit'), 2) }}" />
    @endif

    <x-mary-form wire:submit.prevent="save">
        <x-mary-input label="Monto {{ $openCaja ? 'de cierre' : 'de apertura' }}"
            wire:model.live="cajaForm.monto_{{ $openCaja ? 'cierre' : 'apertura' }}"
            prefix="S/." type="number" step="0.01" min="0" />

        <x-slot:actions>
            <x-mary-button label="Cancelar" @click="$wire.modalCaja = false" class="btn-ghost" />
            <x-mary-button type="submit" spinner="save"
                label="{{ $openCaja ? 'Cerrar caja' : 'Abrir caja' }}"
                class="{{ $openCaja ? 'btn-error' : 'btn-success' }} text-white" />
        </x-slot:actions>
    </x-mary-form>
</x-mary-modal>

{{-- Modal ingreso --}}
<x-mary-modal wire:model="modalEntry" persistent class="backdrop-blur" box-class="max-w-md">
    <div class="flex items-center gap-3 mb-4">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-success/15 text-success">
            <x-mary-icon name="o-arrow-down-circle" class="w-5 h-5" />
        </div>
        <div>
            <h3 class="font-bold text-lg">Registrar ingreso</h3>
            <p class="text-sm text-base-content/60">Entrada de dinero a la caja</p>
        </div>
    </div>

    <x-mary-form wire:submit="entryCaja">
        <div class="space-y-3">
            <x-mary-select label="Tipo" :options="$tipos" wire:model="entryForm.tipo_entry" />
            <x-mary-input label="Monto" wire:model="entryForm.monto_entry" prefix="S/." type="number" step="0.01" min="0" />
            <x-mary-input label="Descripción" wire:model="entryForm.description" placeholder="Concepto del ingreso" />
            <x-mary-select label="Método de pago" icon="o-credit-card" :options="$metodoPagos" wire:model="entryForm.metodo_pago" />
        </div>
        <x-slot:actions>
            <x-mary-button label="Cancelar" @click="$wire.modalEntry = false" class="btn-ghost" />
            <x-mary-button type="submit" spinner="entryCaja" label="Registrar ingreso" class="btn-success text-white" />
        </x-slot:actions>
    </x-mary-form>
</x-mary-modal>

{{-- Modal egreso --}}
<x-mary-modal wire:model="modalExit" persistent class="backdrop-blur" box-class="max-w-md">
    <div class="flex items-center gap-3 mb-4">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-error/15 text-error">
            <x-mary-icon name="o-arrow-up-circle" class="w-5 h-5" />
        </div>
        <div>
            <h3 class="font-bold text-lg">Registrar egreso</h3>
            <p class="text-sm text-base-content/60">Salida de dinero de la caja</p>
        </div>
    </div>

    <x-mary-form wire:submit="exitCaja">
        <div class="space-y-3">
            <x-mary-select label="Tipo" :options="$tipos2" wire:model="exitForm.tipo_exit" />
            <x-mary-input label="Monto" wire:model="exitForm.monto_exit" prefix="S/." type="number" step="0.01" min="0" />
            <x-mary-input label="Descripción" wire:model="exitForm.description" placeholder="Concepto del egreso" />
            <x-mary-select label="Método de pago" icon="o-credit-card" :options="$metodoPagos" wire:model="exitForm.metodo_pago" />
        </div>
        <x-slot:actions>
            <x-mary-button label="Cancelar" @click="$wire.modalExit = false" class="btn-ghost" />
            <x-mary-button type="submit" spinner="exitCaja" label="Registrar egreso" class="btn-error text-white" />
        </x-slot:actions>
    </x-mary-form>
</x-mary-modal>
