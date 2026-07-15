@php
    $user = auth()->user();
    $sucursal = $user?->sucursal;
    $invoiceAlertStart = \Carbon\Carbon::now('America/Lima')->startOfMonth();
    $invoiceAlertEnd = \Carbon\Carbon::now('America/Lima')->endOfMonth();
    $invoiceAlertQuery = \App\Models\Facturacion\Invoice::query()
        ->whereIn('tipoDoc', ['01', '03'])
        ->whereBetween('fechaEmision', [$invoiceAlertStart, $invoiceAlertEnd])
        ->where(fn ($query) => $query->whereNull('estado')->orWhere('estado', '!=', 'ANULADO'));
    $pendingInvoices = (clone $invoiceAlertQuery)
        ->whereNull('cdr_code')
        ->whereNull('errorCode')
        ->count();
    $errorInvoices = (clone $invoiceAlertQuery)
        ->whereNotNull('errorCode')
        ->count();
    $notifications = $pendingInvoices + $errorInvoices;
    $initials = collect(explode(' ', $user?->name ?? 'U'))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->implode('');
@endphp

<x-mary-nav sticky full-width class="app-header border-b border-base-300/80 bg-base-100/90 backdrop-blur-md shadow-sm">
    <x-slot:brand>
        <div class="flex items-center gap-2 min-w-0">
            <label for="main-drawer" class="btn btn-ghost btn-sm btn-square lg:hidden shrink-0">
                <x-mary-icon name="o-bars-3" class="w-5 h-5" />
            </label>
            <x-partials.brand-logo size="md" :show-sucursal="true" class="min-w-0" />
        </div>
    </x-slot:brand>

    <x-slot:actions>
        @if ($sucursal)
            <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary/10 border border-primary/20">
                <x-mary-icon name="o-building-storefront" class="w-4 h-4 text-primary" />
                <div class="leading-tight">
                    <p class="text-[10px] uppercase tracking-wide text-primary/70 font-semibold">Sucursal</p>
                    <p class="text-xs font-semibold text-base-content">{{ $sucursal->code }} · {{ $sucursal->name }}</p>
                </div>
            </div>
        @endif

        <x-mary-theme-toggle darkTheme="business" lightTheme="light" class="btn-sm" />

        @can('facturacion.invoice')
            <x-mary-dropdown class="hidden sm:block">
                <x-slot:trigger>
                    <button type="button" class="btn btn-ghost btn-sm btn-square relative">
                        <x-mary-icon name="o-bell" class="w-5 h-5" />
                        @if ($notifications > 0)
                            <span class="absolute -top-0.5 -right-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-error px-1 text-[10px] font-bold text-error-content">
                                {{ $notifications > 99 ? '99+' : $notifications }}
                            </span>
                        @endif
                    </button>
                </x-slot:trigger>
                <x-mary-menu-item icon="o-clock" title="Pendientes de envío ({{ $pendingInvoices }})" link="{{ route('facturacion.invoice') }}" />
                <x-mary-menu-item icon="o-exclamation-triangle" title="Con error ({{ $errorInvoices }})" link="{{ route('facturacion.invoice') }}" />
            </x-mary-dropdown>
        @endcan

        <div class="hidden lg:block w-px h-8 bg-base-300/80"></div>

        <x-mary-dropdown>
            <x-slot:trigger>
                <button type="button" class="flex items-center gap-2.5 pl-1 pr-2 py-1 rounded-full hover:bg-base-200/80 transition-colors">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-primary to-primary/70 text-primary-content text-sm font-bold shadow-sm">
                        {{ $initials }}
                    </div>
                    <div class="hidden lg:block text-left leading-tight max-w-[140px]">
                        <p class="text-sm font-semibold truncate">{{ $user?->name }}</p>
                        <p class="text-[11px] text-base-content/50 truncate">{{ $user?->email }}</p>
                    </div>
                    <x-mary-icon name="o-chevron-down" class="w-4 h-4 text-base-content/40 hidden lg:block" />
                </button>
            </x-slot:trigger>
            <x-mary-menu-item icon="o-user-circle" title="Mi perfil" link="{{ route('profile.edit') }}" />
            @can('tutorial.video')
                <x-mary-menu-item icon="o-academic-cap" title="Tutoriales" link="{{ route('tutorial.video') }}" />
            @endcan
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex w-full items-center gap-3 px-4 py-2.5 text-sm hover:bg-base-200 rounded-lg transition-colors cursor-pointer">
                    <x-mary-icon name="o-arrow-right-on-rectangle" class="w-5 h-5 shrink-0 opacity-70" />
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </x-mary-dropdown>
    </x-slot:actions>
</x-mary-nav>
