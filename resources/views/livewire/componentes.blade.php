<div>
    <x-mary-header title="Users" subtitle="Check this on mobile">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-bolt" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-funnel" />
            <x-mary-button icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-mary-header>
    {{-- You can use any `$wire.METHOD` on `@row-click` --}}
    <x-mary-table :headers="$headers" :rows="$users" striped @row-click="alert($event.detail.name)">
        <x-slot:empty>
            <x-mary-icon name="o-cube" label="It is empty." />
        </x-slot:empty>

        {{-- You can name the injected object as you wish  --}}
        @scope('cell_name', $stuff)
            <x-mary-badge :value="$stuff->name" class="badge-info" />
        @endscope
        {{-- Special `actions` slot --}}
        @scope('actions', $user)
            <x-mary-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm" />
        @endscope
    </x-mary-table>
    <x-mary-button label="Default" class="btn-success" wire:click="save" spinner />

    <x-mary-button label="Quick" class="btn-error" wire:click="save2" spinner />

    <x-mary-button label="Save and redirect" class="btn-warning" wire:click="save3" spinner />
    <x-mary-button label="Like" wire:click="save4" icon="o-heart" spinner />

    {{-- Left --}}
    <x-mary-drawer wire:model="showDrawer1" class="w-11/12 lg:w-1/3">
        <div>...</div>
        <x-mary-button label="Close" @click="$wire.showDrawer1 = false" />
    </x-mary-drawer>

    {{-- Right --}}
    <x-mary-drawer wire:model="showDrawer2" class="w-11/12 lg:w-1/3" right>
        <div>...</div>
        <x-mary-button label="Close" @click="$wire.showDrawer2 = false" />
    </x-mary-drawer>
    <x-mary-drawer wire:model="showDrawer3" title="Hello" subtitle="Livewire" separator with-close-button
        close-on-escape class="w-11/12 lg:w-1/3">
        <div>Hey!</div>
        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.showDrawer3 = false" />
            <x-mary-button label="Confirm" class="btn-primary" icon="o-check" />
        </x-slot:actions>
    </x-mary-drawer>
    <x-mary-button label="Open Left" wire:click="$toggle('showDrawer1')" />
    <x-mary-button label="Open Right" wire:click="$toggle('showDrawer2')" />
    <x-mary-button label="Open" @click="$wire.showDrawer3 = true" />

    <x-mary-modal wire:model="myModal1" class="backdrop-blur">
        <div class="mb-5">Press `ESC`, click outside or click `CANCEL` to close.</div>
        <x-mary-button label="Cancel" @click="$wire.myModal1 = false" />
    </x-mary-modal>
    <x-mary-modal wire:model="myModal2" title="Hello" subtitle="Livewire example" separator>
        <div>Hey!</div>

        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.myModal2 = false" />
            <x-mary-button label="Confirm" class="btn-primary" />
        </x-slot:actions>
    </x-mary-modal>


    <x-mary-button label="Modal1" @click="$wire.myModal1 = true" />
    <x-mary-button label="Modal2" @click="$wire.myModal2 = true" />

    <x-mary-loading class="loading-bars" />

    <div class="flex gap-5">
        <x-mary-input placeholder="Name ..." wire:model.live.debounce="name" />
        <x-mary-button label="Save" wire:click="save5" />
    </div>

    {{-- Always --}}
    <x-mary-hr />

    <div>
        The above HR always triggers. The bellow only on target action.
    </div>

    {{-- Only on `save` action --}}
    <x-mary-hr target="save5" />

    <x-mary-stat title="Messages" value="44" icon="o-envelope" tooltip="Hello" />

    <x-mary-stat title="Sales" description="This month" value="22.124" icon="o-arrow-trending-up"
        tooltip-bottom="There" />

    <x-mary-stat title="Lost" description="This month" value="34" icon="o-arrow-trending-down"
        tooltip-left="Ops!" />

    <x-mary-stat title="Sales" description="This month" value="22.124" icon="o-arrow-trending-down"
        class="text-orange-500" color="text-pink-500" tooltip-right="Gosh!" />

    <x-mary-steps wire:model="step" class="p-5 my-5 border">
        <x-mary-step step="1" text="Register">
            Register step
        </x-mary-step>
        <x-mary-step step="2" text="Payment">
            Payment step
        </x-mary-step>
        <x-mary-step step="3" text="Receive Product" class="bg-orange-500/20">
            Receive Product
        </x-mary-step>
    </x-mary-steps>

    {{-- Create some methods to increase/decrease the model to match the step number --}}
    {{-- You could use Alpine with `$wire` here --}}
    <x-mary-button label="Previous" wire:click="prev" />
    <x-mary-button label="Next" wire:click="next" />

    <x-mary-timeline-item title="Order placed" first icon="o-map-pin" />

    <x-mary-timeline-item title="Payment confirmed" icon="o-credit-card" />

    <x-mary-timeline-item title="Shipped" icon="o-paper-airplane" />
    <x-mary-timeline-item title="Delivered" pending last icon="o-gift" />


    <x-mary-tabs wire:model="selectedTab">
        <x-mary-tab name="users-tab" label="Users" icon="o-users">
            <div>Users</div>
        </x-mary-tab>
        <x-mary-tab name="tricks-tab" label="Tricks" icon="o-sparkles">
            <div>Tricks</div>
        </x-mary-tab>
        <x-mary-tab name="musics-tab" label="Musics" icon="o-musical-note">
            <div>Musics</div>
        </x-mary-tab>
    </x-mary-tabs>

    <hr class="my-5">

    <x-mary-button label="Change to Musics" @click="$wire.selectedTab = 'musics-tab'" />
    <div class="w-44">
        <x-mary-signature wire:model="signature3" clear-text="Delete it!" height="100" class="border-4" />
    </div>

    <x-mary-choices label="Searchable + Multiple" wire:model="users_multi_searchable_ids" :options="$usersSearchable"
        search-function="search" single no-result-text="Ops! Nothing here ..." searchable />

</div>
