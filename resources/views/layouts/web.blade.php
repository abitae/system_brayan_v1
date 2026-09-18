<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'LA RANA EXPRESS' }} — Cargas y encomiendas</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}?v=rana">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        rana: {
                            lime: '#8DC63F',
                            dark: '#14351D',
                            mid: '#2F6B32',
                            hover: '#6FA82E',
                            bg: '#F7F8F4',
                        }
                    },
                    fontFamily: {
                        sans: ['Outfit', 'ui-sans-serif', 'system-ui'],
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --rana-lime: #8DC63F;
            --rana-dark: #14351D;
            --rana-mid: #2F6B32;
            --rana-hover: #6FA82E;
            --rana-bg: #F7F8F4;
        }
        body { font-family: Outfit, ui-sans-serif, system-ui, sans-serif; }
        .btn-rana {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: #8DC63F;
            color: #14351D;
            font-weight: 700;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            transition: background-color .15s ease, transform .15s ease;
        }
        .btn-rana:hover { background: #6FA82E; }
        .btn-rana-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: transparent;
            color: #fff;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            border: 2px solid #8DC63F;
            transition: background-color .15s ease, color .15s ease;
        }
        .btn-rana-outline:hover { background: #8DC63F; color: #14351D; }
        .btn-rana-dark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: #14351D;
            color: #fff;
            font-weight: 700;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            transition: background-color .15s ease;
        }
        .btn-rana-dark:hover { background: #2F6B32; }
        .input-rana {
            width: 100%;
            border-radius: 0.75rem;
            border: 1px solid #d1d5db;
            padding: 0.75rem 1rem;
            outline: none;
        }
        .input-rana:focus {
            border-color: #8DC63F;
            box-shadow: 0 0 0 3px rgba(141, 198, 63, 0.25);
        }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-rana-bg text-rana-dark antialiased" x-data="{ mobile: false, services: false }">
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-20">
                <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('img/logo.png') }}?v=rana" alt="LA RANA EXPRESS" class="h-12 w-auto">
                    <span class="hidden sm:flex flex-col leading-tight">
                        <span class="font-extrabold tracking-wide text-rana-dark">LA RANA</span>
                        <span class="text-xs font-bold tracking-[0.2em] text-rana-lime">EXPRESS</span>
                    </span>
                </a>

                <nav class="hidden lg:flex items-center gap-1 text-sm font-semibold">
                    <a href="{{ url('/') }}" class="px-3 py-2 rounded-lg hover:text-rana-mid {{ request()->is('/') ? 'text-rana-mid' : 'text-rana-dark' }}">Inicio</a>
                    <div class="relative" @mouseenter="services = true" @mouseleave="services = false">
                        <a href="{{ url('/servicios') }}" class="px-3 py-2 rounded-lg inline-flex items-center gap-1 hover:text-rana-mid {{ request()->is('servicios*') ? 'text-rana-mid' : 'text-rana-dark' }}">
                            Servicios
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                        <div x-show="services" x-cloak x-transition
                             class="absolute left-0 top-full w-72 bg-white rounded-2xl shadow-xl border border-gray-100 p-3 grid gap-1">
                            <a href="{{ url('/servicios/courier') }}" class="px-3 py-2 rounded-lg hover:bg-rana-bg text-sm">Courier</a>
                            <a href="{{ url('/servicios/recojo') }}" class="px-3 py-2 rounded-lg hover:bg-rana-bg text-sm">Recojo a domicilio</a>
                            <a href="{{ url('/servicios/carga-consolidada') }}" class="px-3 py-2 rounded-lg hover:bg-rana-bg text-sm">Carga consolidada</a>
                            <a href="{{ url('/servicios/door-to-door') }}" class="px-3 py-2 rounded-lg hover:bg-rana-bg text-sm">Puerta a puerta</a>
                            <a href="{{ url('/servicios/almacen') }}" class="px-3 py-2 rounded-lg hover:bg-rana-bg text-sm">Almacén</a>
                            <a href="{{ url('/servicios/mudanza') }}" class="px-3 py-2 rounded-lg hover:bg-rana-bg text-sm">Mudanza</a>
                            <a href="{{ url('/servicios/traslados-vehiculos') }}" class="px-3 py-2 rounded-lg hover:bg-rana-bg text-sm">Traslado de vehículos</a>
                            <a href="{{ url('/servicios/traslados-contenedores') }}" class="px-3 py-2 rounded-lg hover:bg-rana-bg text-sm">Traslado de contenedores</a>
                        </div>
                    </div>
                    <a href="{{ url('/rastrea') }}" class="px-3 py-2 rounded-lg hover:text-rana-mid {{ request()->is('rastrea') ? 'text-rana-mid' : 'text-rana-dark' }}">Rastrea</a>
                    <a href="{{ url('/agencias') }}" class="px-3 py-2 rounded-lg hover:text-rana-mid {{ request()->is('agencias') || request()->is('terminales') ? 'text-rana-mid' : 'text-rana-dark' }}">Agencias</a>
                    <a href="{{ url('/nosotros') }}" class="px-3 py-2 rounded-lg hover:text-rana-mid {{ request()->is('nosotros') ? 'text-rana-mid' : 'text-rana-dark' }}">Nosotros</a>
                    <a href="{{ url('/contacto') }}" class="px-3 py-2 rounded-lg hover:text-rana-mid {{ request()->is('contacto') ? 'text-rana-mid' : 'text-rana-dark' }}">Contacto</a>
                </nav>

                <div class="hidden lg:flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-rana-dark hover:text-rana-mid">Iniciar sesión</a>
                    <a href="{{ url('/rastrea') }}" class="btn-rana text-sm py-2.5 px-4">Rastrear envío</a>
                </div>

                <button type="button" class="lg:hidden p-2 rounded-lg border border-gray-200" @click="mobile = true" aria-label="Abrir menú">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </header>

    <div x-show="mobile" x-cloak class="fixed inset-0 z-[60] lg:hidden" @keydown.escape.window="mobile = false">
        <div class="absolute inset-0 bg-black/40" @click="mobile = false"></div>
        <aside class="absolute right-0 top-0 h-full w-80 max-w-[85vw] bg-white shadow-2xl p-6 overflow-y-auto"
               x-show="mobile" x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0">
            <div class="flex items-center justify-between mb-8">
                <img src="{{ asset('img/logo.png') }}?v=rana" alt="LA RANA EXPRESS" class="h-10">
                <button type="button" @click="mobile = false" class="p-2" aria-label="Cerrar menú">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="flex flex-col gap-1 text-base font-semibold">
                <a href="{{ url('/') }}" class="px-3 py-3 rounded-lg hover:bg-rana-bg">Inicio</a>
                <a href="{{ url('/servicios') }}" class="px-3 py-3 rounded-lg hover:bg-rana-bg">Servicios</a>
                <a href="{{ url('/servicios/courier') }}" class="px-3 py-2 pl-6 text-sm text-gray-600 rounded-lg hover:bg-rana-bg">Courier</a>
                <a href="{{ url('/servicios/recojo') }}" class="px-3 py-2 pl-6 text-sm text-gray-600 rounded-lg hover:bg-rana-bg">Recojo</a>
                <a href="{{ url('/servicios/carga-consolidada') }}" class="px-3 py-2 pl-6 text-sm text-gray-600 rounded-lg hover:bg-rana-bg">Carga</a>
                <a href="{{ url('/rastrea') }}" class="px-3 py-3 rounded-lg hover:bg-rana-bg">Rastrea</a>
                <a href="{{ url('/agencias') }}" class="px-3 py-3 rounded-lg hover:bg-rana-bg">Agencias</a>
                <a href="{{ url('/nosotros') }}" class="px-3 py-3 rounded-lg hover:bg-rana-bg">Nosotros</a>
                <a href="{{ url('/contacto') }}" class="px-3 py-3 rounded-lg hover:bg-rana-bg">Contacto</a>
                <a href="{{ route('login') }}" class="px-3 py-3 rounded-lg hover:bg-rana-bg">Iniciar sesión</a>
            </nav>
        </aside>
    </div>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-rana-dark text-white mt-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-14 grid gap-10 md:grid-cols-3">
            <div>
                <img src="{{ asset('img/logo.png') }}?v=rana" alt="LA RANA EXPRESS" class="h-14 mb-4 bg-white rounded-xl p-1">
                <h3 class="font-extrabold text-lg">LA RANA EXPRESS E.I.R.L.</h3>
                <p class="mt-2 text-sm text-white/70">Cargas y encomiendas a nivel nacional. Envíos seguros, simples y rastreables.</p>
            </div>
            <div>
                <h4 class="font-bold text-rana-lime mb-4">Enlaces</h4>
                <ul class="space-y-2 text-sm text-white/80">
                    <li><a href="{{ url('/terminos') }}" class="hover:text-rana-lime">Términos y condiciones</a></li>
                    <li><a href="{{ url('/prohibiciones') }}" class="hover:text-rana-lime">Artículos prohibidos</a></li>
                    <li><a href="{{ url('/reclamaciones') }}" class="hover:text-rana-lime">Libro de reclamaciones</a></li>
                    <li><a href="{{ url('/cotiza') }}" class="hover:text-rana-lime">Cotiza tu envío</a></li>
                    <li><a href="{{ url('/envia') }}" class="hover:text-rana-lime">Cómo enviar</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-rana-lime mb-4">Contacto</h4>
                <ul class="space-y-2 text-sm text-white/80">
                    <li>Perú</li>
                    <li><a href="tel:+51976790973" class="hover:text-rana-lime">976 790 973</a> / <a href="tel:+51963508032" class="hover:text-rana-lime">963 508 032</a></li>
                    <li><a href="mailto:contacto@ranaexpress.pe" class="hover:text-rana-lime">contacto@ranaexpress.pe</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 py-4 text-center text-xs text-white/50">
            © {{ date('Y') }} LA RANA EXPRESS E.I.R.L. Todos los derechos reservados.
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
