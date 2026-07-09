<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator>
        <x-slot:menu>
            <x-mary-swap wire:model.live="production">
                <x-slot:true class="p-2 rounded bg-warning">
                    Production
                </x-slot:true>
                <x-slot:false class="p-2 text-white bg-secondary">
                    Demo
                </x-slot:false>
            </x-mary-swap>
        </x-slot:menu>
        <x-mary-form wire:submit.prevent="save" separator>
            <div class="grid grid-cols-6 gap-1">

                <x-mary-input label="Documento" wire:model='companyForm.ruc' />

                <div class="col-span-3">
                    <x-mary-input label="Razon Social" wire:model='companyForm.razonSocial' />
                </div>

                <div class="col-span-2">
                    <x-mary-input label="Direccion" wire:model='companyForm.address' />
                </div>
                <x-mary-input label="Email" wire:model='companyForm.email' />
                <x-mary-input label="Telefono" wire:model='companyForm.telephone' />
                <x-mary-input type='password' label="PIN" wire:model='companyForm.pin' />
                <x-mary-input label="Cuenta Bancaria" wire:model='companyForm.ctaBanco' />
                <x-mary-select label="Ubigeo" option-value="ubigeo2" option-label="texto_ubigeo"
                    placeholder="Select ubigeo" wire:model='companyForm.ubigeo' :options="$ubigeos" class="max-w-sm" />
            </div>
            <div class="grid grid-cols-6 gap-1">
                <x-mary-input label="sol_user" wire:model='companyForm.sol_user' />
                <x-mary-input type='password' label="sol_pass" wire:model='companyForm.sol_pass' />
                <x-mary-input label="client_id" wire:model='companyForm.client_id' />
                <x-mary-input type='password' label="client_secret" wire:model='companyForm.client_secret' />
            </div>
            <x-slot:actions>
                <x-mary-button label="Guardar" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
        <div class="grid grid-cols-2 gap-1 p-2 border border-gray-300 rounded-lg">
            <div>
                @if ($company->cert_path)
                    <textarea class="w-full h-24 p-2 text-sm font-mono bg-gray-100 border border-gray-300 rounded-lg" readonly>{{ Storage::get($company->cert_path) }}</textarea>
                @endif
            </div>
            <div>
                @if ($company->logo_path)
                    <img src="{{ 'storage/' . $company->logo_path ?? '/empty-user.jpg' }}" class="h-24 rounded-lg" />
                @endif

            </div>
        </div>
        <x-mary-form wire:submit.prevent="saveArchive" separator>
            <div class="grid grid-cols-1 gap-1 p-2 border border-gray-300 rounded-lg md:grid-cols-2">
                <div>
                    <x-mary-file wire:model="certificado" label="Certificado" />
                </div>
                <div>
                    <x-mary-file wire:model="logo" label="Logo" />
                </div>
            </div>
            <x-slot:actions>
                <x-mary-button label="Guardar" class="btn-primary" type="submit" spinner="saveArchive" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-card>
</div>
