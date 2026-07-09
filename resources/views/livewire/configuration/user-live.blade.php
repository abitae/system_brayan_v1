<div>
    <x-mary-card title="{{ $title ?? 'title' }}" subtitle="{{ $sub_title ?? 'title' }}" shadow separator class="w-full">
        <x-slot:menu>
            <x-mary-button wire:click='openModal' responsive icon="o-plus" label="Nuevo usuario"
                class="text-white bg-sky-500 hover:bg-sky-600 transition-colors duration-200" />
        </x-slot:menu>

        <div class="w-full px-4 py-2">
            <div class="w-full">
                <x-mary-card shadow separator class="overflow-x-auto">
                    @php
                        $headers = [
                            ['key' => 'id', 'label' => '#', 'class' => 'bg-purple-500 w-12 whitespace-nowrap'],
                            ['key' => 'name', 'label' => 'Name', 'class' => 'whitespace-nowrap'],
                            ['key' => 'role', 'label' => 'Rol', 'class' => 'whitespace-nowrap'],
                            ['key' => 'email', 'label' => 'Email', 'class' => 'whitespace-nowrap'],
                            ['key' => 'isActive', 'label' => 'Estado', 'class' => 'whitespace-nowrap'],
                        ];
                        $row_decoration = [
                            'bg-red-50/80' => fn(App\Models\User $user) => !$user->isActive,
                        ];
                    @endphp
                    <x-mary-table :headers="$headers" :rows="$users" with-pagination per-page="perPage"
                        :row-decoration="$row_decoration" :per-page-values="[5, 10, 20, 50]" striped class="min-w-full">
                        @scope('cell_role', $stuff)
                        <span class="text-sm font-medium">{{ $stuff->getRoleNames()->first() }}</span>
                        @endscope

                        @scope('cell_isActive', $stuff)
                        <button wire:click='estado({{ $stuff->id }})'
                            wire:confirm.prompt="Estas seguro de eliminar registro?\n\nEscriba 'SI' para confirmar!|SI"
                            class="flex items-center space-x-2 px-3 py-1 rounded-full {{ $stuff->isActive ? 'bg-green-100' : 'bg-red-100' }}">
                            <div
                                class="h-2.5 w-2.5 rounded-full {{ $stuff->isActive ? 'bg-green-500' : 'bg-red-500' }}">
                            </div>
                            <span class="text-sm {{ $stuff->isActive ? 'text-green-700' : 'text-red-700' }}">
                                {{ $stuff->isActive ? 'Active' : 'Disabled' }}
                            </span>
                        </button>
                        @endscope

                        @scope('actions', $user)
                        <div class="flex items-center space-x-2">
                            <x-mary-button icon="s-pencil-square" wire:click="edit({{ $user->id }})" spinner
                                class="btn-sm bg-amber-500 hover:bg-amber-600 text-white transition-colors duration-200" />
                            <x-mary-button icon="o-trash" wire:click="edit({{ $user->id }})"
                                wire:confirm.prompt="Estas seguro?\n\nEscribe DELETE para confirmar|DELETE" spinner
                                class="btn-sm bg-red-500 hover:bg-red-600 text-white transition-colors duration-200" />
                        </div>
                        @endscope
                    </x-mary-table>
                </x-mary-card>
            </div>
        </div>
    </x-mary-card>
    @include('livewire.configuration.user-modal')
</div>