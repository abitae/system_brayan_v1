<x-mary-modal wire:model="modalUser" persistent class="backdrop-blur-sm transition-all duration-300"
    box-class="max-h-full max-w-lg md:max-w-xl lg:max-w-2xl rounded-lg shadow-xl">
    <div class="flex items-center space-x-3 mb-6">
        <x-mary-icon name="s-envelope" class="text-green-500 text-xl"
            label="{{ !isset($userForm->user) ? 'CREAR USUARIO' : 'EDITAR USUARIO' }}" />
    </div>

    <x-mary-form wire:submit.prevent="{{ !isset($userForm->user) ? 'create' : 'update' }}" class="space-y-4">
        <div class="border border-green-500 rounded-lg bg-white/50 backdrop-blur-sm p-6">
            <div class="grid gap-6 md:gap-8">
                <div class="space-y-4">
                    <x-mary-input label="Nombre" inline wire:model='userForm.name'
                        class="w-full focus:ring-green-500" />

                    <x-mary-input label="Email" inline wire:model='userForm.email' class="w-full focus:ring-green-500"
                        type="email" />

                    <x-mary-select label="Sucursal" :options="$sucursals" option-value="id" option-label="name"
                        placeholder="Seleccione una sucursal" placeholder-value="0" hint="Seleccione una sucursal."
                        wire:model="userForm.sucursal_id" class="w-full focus:ring-green-500" />

                    <x-mary-select label="Rol" :options="$roles" option-value="name" option-label="name"
                        placeholder="Seleccione un rol" placeholder-value="0" hint="Seleccione un rol."
                        wire:model="userForm.role" class="w-full focus:ring-green-500" />
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8">
                <x-mary-button label="Cancelar" wire:click="openModal()"
                    class="bg-red-500 hover:bg-red-600 transition-colors duration-200" />
                <x-mary-button type="submit" spinner="{{ !isset($userForm->sucursal) ? 'create' : 'edit' }}"
                    label="Guardar" class="bg-blue-500 hover:bg-blue-600 transition-colors duration-200" />
            </div>
        </div>
    </x-mary-form>
</x-mary-modal>