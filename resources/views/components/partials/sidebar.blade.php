<x-mary-main with-nav full-width>
    <x-slot:sidebar drawer="main-drawer" collapsible collapse-text="Contraer" collapse-icon="o-chevron-double-left"
        class="app-sidebar bg-base-100 border-r border-base-300/60">
        <div class="flex flex-col h-full min-h-0">
            <div class="flex-1 overflow-y-auto min-h-0 pt-3">
                <x-mary-menu activate-by-route class="!bg-transparent px-2 pb-3">

                    <x-mary-menu-sub title="General" icon="o-chart-bar-square">
                        <x-mary-menu-item title="Dashboard" icon="o-chart-bar-square" link="{{ route('dashboard') }}" />
                        @can('tutorial.video')
                            <x-mary-menu-item title="Tutoriales" icon="o-academic-cap" link="{{ route('tutorial.video') }}" />
                        @endcan
                    </x-mary-menu-sub>

                    @canany(['caja.index', 'config.ruta', 'package.send', 'package.receive', 'package.manifiesto', 'package.customer'])
                        <x-mary-menu-sub title="Operaciones" icon="o-truck">
                            @can('caja.index')
                                <x-mary-menu-item title="Caja" icon="o-banknotes" link="{{ route('caja.index') }}" />
                            @endcan
                            @can('config.ruta')
                                <x-mary-menu-item title="Rutas" icon="o-map" link="{{ route('config.configuration') }}" />
                            @endcan
                            @can('package.send')
                                <x-mary-menu-item title="Enviar" icon="o-arrow-up-tray" link="{{ route('package.send') }}" />
                            @endcan
                            @can('package.receive')
                                <x-mary-menu-item title="Recibir" icon="o-arrow-down-tray" link="{{ route('package.receive') }}" />
                            @endcan
                            @can('package.manifiesto')
                                <x-mary-menu-item title="Manifiestos" icon="o-document-text" link="{{ route('package.manifiesto') }}" />
                            @endcan
                            @can('package.customer')
                                <x-mary-menu-item title="Clientes" icon="o-user-group" link="{{ route('package.customer') }}" />
                            @endcan
                        </x-mary-menu-sub>
                    @endcanany

                    @canany(['package.register', 'package.deliver', 'package.home', 'package.return', 'package.record'])
                        <x-mary-menu-sub title="Encomiendas" icon="o-cube">
                            @can('package.register')
                                <x-mary-menu-item title="Registrar encomienda" icon="o-plus-circle" link="{{ route('package.register') }}" />
                            @endcan
                            @can('package.deliver')
                                <x-mary-menu-item title="Entregar en agencia" icon="o-building-storefront" link="{{ route('package.deliver') }}" />
                            @endcan
                            @can('package.home')
                                <x-mary-menu-item title="Entregar domicilio" icon="o-home" link="{{ route('package.home') }}" />
                            @endcan
                            @can('package.return')
                                <x-mary-menu-item title="Retorno" icon="o-arrow-uturn-left" link="{{ route('package.return') }}" />
                            @endcan
                            @can('package.record')
                                <x-mary-menu-item title="Historial" icon="o-clock" link="{{ route('package.record') }}" />
                            @endcan
                        </x-mary-menu-sub>
                    @endcanany

                    @can('menu.facturacion')
                        <x-mary-menu-sub title="Facturación" icon="o-receipt-percent">
                            @can('facturacion.create-invoice')
                                <x-mary-menu-item title="Emitir factura" icon="o-document-text"
                                    link="{{ route('facturacion.create-invoice') }}" />
                                <x-mary-menu-item title="Emitir boleta" icon="o-ticket"
                                    link="{{ route('facturacion.create-invoice') }}" />
                            @endcan
                            @can('facturacion.create-note')
                                <x-mary-menu-item title="Nota de crédito" icon="o-document-minus"
                                    link="{{ route('facturacion.create-note') }}" />
                            @endcan
                        </x-mary-menu-sub>
                    @endcan

                    @can('menu.reporte')
                        <x-mary-menu-sub title="Reportes" icon="o-chart-pie">
                            @can('report.encomienda')
                                <x-mary-menu-item title="Encomiendas" icon="o-truck" link="{{ route('report.encomiendas') }}" />
                            @endcan
                            @can('facturacion.invoice')
                                <x-mary-menu-item title="Boletas y facturas" icon="o-document-currency-dollar"
                                    link="{{ route('facturacion.invoice') }}" />
                            @endcan
                            @can('facturacion.ticket')
                                <x-mary-menu-item title="Tickets de envío" icon="o-ticket" link="{{ route('facturacion.ticket') }}" />
                            @endcan
                            @can('facturacion.despache')
                                <x-mary-menu-item title="Guías transportista" icon="o-map-pin"
                                    link="{{ route('facturacion.despache') }}" />
                            @endcan
                            @can('facturacion.note')
                                <x-mary-menu-item title="Notas de crédito" icon="o-document-minus" link="{{ route('facturacion.note') }}" />
                            @endcan
                        </x-mary-menu-sub>
                    @endcan

                    <x-mary-menu-sub title="Finanzas" icon="o-currency-dollar">
                        <x-mary-menu-item title="Cuentas por cobrar" icon="o-currency-dollar" link="{{ route('cobrar.encomiendas') }}" />
                        @can('report.contable')
                            <x-mary-menu-item title="Reporte contable" icon="o-calculator" link="{{ route('report.contable') }}" />
                        @endcan
                        @can('report.ventas')
                            <x-mary-menu-item title="Registro de ventas" icon="o-document-chart-bar" link="{{ route('report.ventas') }}" />
                        @endcan
                    </x-mary-menu-sub>

                    @can('menu.configuracion')
                        <x-mary-menu-sub title="Administración" icon="o-cog-6-tooth">
                            @can('config.company')
                                <x-mary-menu-item title="Empresa" icon="o-building-office" link="{{ route('config.company') }}" />
                            @endcan
                            @can('config.sucursal')
                                <x-mary-menu-item title="Sucursales" icon="o-building-storefront" link="{{ route('config.sucursal') }}" />
                            @endcan
                            @can('config.user')
                                <x-mary-menu-item title="Usuarios" icon="o-users" link="{{ route('config.user') }}" />
                            @endcan
                            @can('config.role')
                                <x-mary-menu-item title="Roles" icon="o-shield-check" link="{{ route('config.role') }}" />
                            @endcan
                            @can('config.vehiculo')
                                <x-mary-menu-item title="Vehículos" icon="o-truck" link="{{ route('config.vehiculo') }}" />
                            @endcan
                            @can('config.transportista')
                                <x-mary-menu-item title="Choferes" icon="o-identification" link="{{ route('config.transportista') }}" />
                            @endcan
                        </x-mary-menu-sub>
                    @endcan

                    @canany(['message.frontend', 'reclamaciones.frontend'])
                        <x-mary-menu-sub title="Sitio web" icon="o-globe-alt">
                            @can('message.frontend')
                                <x-mary-menu-item title="Mensajes" icon="o-envelope" link="{{ route('message.frontend') }}" />
                            @endcan
                            @can('reclamaciones.frontend')
                                <x-mary-menu-item title="Reclamaciones" icon="o-exclamation-circle"
                                    link="{{ route('reclamaciones.frontend') }}" />
                            @endcan
                        </x-mary-menu-sub>
                    @endcanany

                </x-mary-menu>
            </div>

            <div class="mary-hideable mt-auto mx-3 mb-4 p-3 rounded-xl bg-base-200/60 border border-base-300/50 shrink-0">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary text-primary-content text-xs font-bold">
                        {{ collect(explode(' ', auth()->user()->name))->filter()->take(2)->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->implode('') }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-semibold truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-base-content/50 truncate">{{ auth()->user()->sucursal?->code ?? 'Sin sucursal' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:sidebar>

    <x-slot:content>
        {{ $slot }}
    </x-slot:content>
</x-mary-main>
