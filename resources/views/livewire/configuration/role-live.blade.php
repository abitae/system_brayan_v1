<div class="min-h-screen bg-gray-50">
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}"
        class="transition-all duration-300 hover:shadow-lg" shadow separator>
        <x-slot:menu>
            <x-mary-button wire:click='openModal' responsive icon="o-plus" label="Nuevo rol" class="text-white bg-sky-500 hover:bg-sky-600 transition-colors duration-200 
                       focus:ring-2 focus:ring-sky-400 focus:ring-offset-2" />
        </x-slot:menu>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mt-4">
                <x-mary-card shadow separator class="overflow-hidden rounded-lg">
                    @php
                        $headers = [
                            ['key' => 'id', 'label' => '#', 'class' => 'bg-purple-500 w-12 text-white font-semibold'],
                            ['key' => 'name', 'label' => 'Name', 'class' => 'font-semibold'],
                            ['key' => 'permission', 'label' => 'Permissions', 'class' => 'font-semibold'],
                        ];
                    @endphp

                    <x-mary-table :headers="$headers" :rows="$roles" with-pagination per-page="perPage1"
                        :per-page-values="[5, 10, 20, 50]" class="w-full">
                        @scope('cell_permission', $rol)
                        <div class="flex flex-wrap gap-2">
                            @forelse($rol->permissions as $permission)
                                <x-mary-badge :value="$permission->name" class="text-white bg-gradient-to-r from-green-500 to-green-600 
                                       hover:from-green-600 hover:to-green-700
                                       shadow-sm transition-all duration-200 
                                       transform hover:scale-105
                                       px-3 py-1.5 rounded-full
                                       font-medium text-sm">
                                    <span class="flex items-center gap-1">
                                        <x-mary-icon name="o-key" class="w-4 h-4" />
                                        {{ $permission->name }}
                                    </span>
                                </x-mary-badge>
                            @empty
                                <span class="flex items-center gap-2 px-4 py-2 text-sm text-white 
                                     bg-gradient-to-r from-red-500 to-red-600
                                     rounded-full shadow-sm">
                                    <x-mary-icon name="o-exclamation-triangle" class="w-4 h-4" />
                                    No permissions assigned
                                </span>
                            @endforelse
                        </div>
                        @endscope

                        @scope('actions', $role)
                        <div class="flex items-center space-x-2">
                            <x-mary-button icon="s-pencil-square" wire:click="update({{ $role->id }})" spinner
                                class="btn-sm hover:bg-gray-100 focus:ring-2 focus:ring-gray-200" />
                            <x-mary-button icon="o-trash" wire:click="delete({{ $role->id }})"
                                wire:confirm.prompt="Estas seguro?\n\nEscribe DELETE para confirmar|DELETE" spinner
                                class="btn-sm hover:bg-red-50 focus:ring-2 focus:ring-red-200" />
                        </div>
                        @endscope
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>
    </x-mary-card>
    @include('livewire.configuration.role-modal')
</div>