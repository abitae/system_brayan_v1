<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brayan - Servicio de Envíos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <style>
        /* Optimización de estilos base */
        :root {
            --primary-color: #22c55e;
            --secondary-color: #064e3b;
            --background-color: #fafafa;
            --text-color: #374151;
        }

        /* Reducir especificidad y simplificar selectores */
        .geometric-shape {
            position: absolute;
            pointer-events: none;
            will-change: transform, opacity;
            transform: translateZ(0);
            backface-visibility: hidden;
        }

        .circle {
            border-radius: 50%;
            background: linear-gradient(45deg,
                    rgba(6, 78, 59, 0.15),
                    rgba(30, 58, 138, 0.15));
        }

        .square {
            border-radius: 4px;
            background: linear-gradient(135deg,
                    rgba(20, 83, 45, 0.15),
                    rgba(29, 78, 216, 0.15));
        }

        .triangle {
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            background: linear-gradient(180deg,
                    rgba(6, 78, 59, 0.15),
                    rgba(30, 64, 175, 0.15));
        }

        .animated-background {
            position: fixed;
            inset: 0;
            z-index: -1;
            background-color: var(--background-color);
            overflow: hidden;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
        }

        .nav-link {
            @apply flex flex-col items-center text-green-500 hover:text-yellow-500 transition-colors duration-200;
        }

        .nav-icon {
            @apply w-8 h-8 text-green-500 mb-1;
        }

        .nav-text {
            @apply text-sm font-semibold;
        }

        .user-menu-item {
            @apply block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200;
        }

        .mobile-nav-link {
            @apply block px-3 py-2 text-base font-medium text-green-500 hover:text-yellow-500 transition-colors duration-200;
        }

        /* Nuevas animaciones de fondo */
        .animated-bg {
            background: linear-gradient(45deg, #f3f4f6, #e5e7eb, #d1d5db);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            position: relative;
            overflow: hidden;
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 60%);
            animation: rotate 30s linear infinite;
            pointer-events: none;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%
            }

            50% {
                background-position: 100% 50%
            }

            100% {
                background-position: 0% 50%
            }
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: rgba(74, 222, 128, 0.1);
            border-radius: 50%;
            animation: float 20s infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0) translateX(0);
            }

            25% {
                transform: translateY(-100px) translateX(50px);
            }

            50% {
                transform: translateY(-50px) translateX(-50px);
            }

            75% {
                transform: translateY(-150px) translateX(25px);
            }

            100% {
                transform: translateY(0) translateX(0);
            }
        }

        .hexagon {
            width: 50px;
            height: 28.87px;
            background: #22c55e;
            position: relative;
            transform: rotate(30deg);
        }

        .hexagon:before,
        .hexagon:after {
            content: "";
            position: absolute;
            width: 0;
            border-left: 25px solid transparent;
            border-right: 25px solid transparent;
        }

        .hexagon:before {
            bottom: 100%;
            border-bottom: 14.43px solid #22c55e;
        }

        .hexagon:after {
            top: 100%;
            border-top: 14.43px solid #22c55e;
        }

        .interactive-particle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            mix-blend-mode: screen;
            background: radial-gradient(circle at center, rgba(74, 222, 128, 0.4) 0%, rgba(74, 222, 128, 0) 70%);
        }

        .cursor-trail {
            position: fixed;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            mix-blend-mode: screen;
            background: rgba(74, 222, 128, 0.6);
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%
            }

            50% {
                background-position: 100% 50%
            }

            100% {
                background-position: 0% 50%
            }
        }
    </style>
</head>

<body class="font-sans animated-bg">
    <!-- Fondo animado -->
    <div class="animated-background" id="animated-bg"></div>

    <!-- Envolver todo el contenido existente en un div con backdrop-filter -->
    <div class="content-wrapper">
        <!-- Partículas flotantes -->
        <div class="floating-particles" id="particles"></div>

        <nav
            class="sticky top-0 z-50 border-b border-gray-200 shadow-sm bg-gradient-to-r from-green-50 to-green-100 transition-all duration-300 hover:shadow-md">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-24">
                    <!-- Logo with animation -->
                    <div class="flex-shrink-0 transition-transform duration-300 transform hover:scale-105">
                        <a href="/" class="flex items-center">
                            <img src="{{ asset('img/logo.png') }}" alt="Brayan Brush Logo" class="h-20">
                        </a>
                    </div>

                    <!-- Mobile menu button with animation -->
                    <div class="flex md:hidden">
                        <button id="menu-toggle"
                            class="text-green-600 hover:text-green-800 focus:outline-none transition-colors duration-300 transform hover:scale-110">
                            <svg id="menu-icon" class="w-8 h-8" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Main Navigation with hover effects -->
                    <div id="menu" class="hidden md:flex md:items-center md:space-x-8">
                        <a href="/"
                            class="flex items-center space-x-2 text-green-600 transition-all duration-300 hover:text-green-800 hover:scale-105 group">
                            <x-mary-icon name="o-home"
                                class="w-8 h-8 text-green-600 group-hover:text-green-800 transition-colors duration-300" />
                            <span
                                class="text-xl font-bold relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-green-800 after:transition-all after:duration-300 group-hover:after:w-full">INICIO</span>
                        </a>
                        <a href="/rastrea"
                            class="flex items-center space-x-2 text-green-600 transition-all duration-300 hover:text-green-800 hover:scale-105 group">
                            <x-mary-icon name="o-eye"
                                class="w-8 h-8 text-green-600 group-hover:text-green-800 transition-colors duration-300" />
                            <span
                                class="text-xl font-bold relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-green-800 after:transition-all after:duration-300 group-hover:after:w-full">RASTREA</span>
                        </a>
                        {{--                     <a href="/pay"
                            class="flex items-center space-x-2 text-green-600 transition-all duration-300 hover:text-green-800 hover:scale-105 group">
                            <x-mary-icon name="o-currency-dollar" class="w-8 h-8 text-green-600 group-hover:text-green-800 transition-colors duration-300" />
                            <span class="text-xl font-bold relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-green-800 after:transition-all after:duration-300 group-hover:after:w-full">PAGALO</span>
                        </a> --}}
                        <a href="/agencias"
                            class="flex items-center space-x-2 text-green-600 transition-all duration-300 hover:text-green-800 hover:scale-105 group">
                            <x-mary-icon name="o-map-pin"
                                class="w-8 h-8 text-green-600 group-hover:text-green-800 transition-colors duration-300" />
                            <span
                                class="text-xl font-bold relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-green-800 after:transition-all after:duration-300 group-hover:after:w-full">AGENCIAS</span>
                        </a>
                        {{-- <a href="/rates"
                            class="flex items-center space-x-2 text-green-600 transition-all duration-300 hover:text-green-800 hover:scale-105 group">
                            <x-mary-icon name="m-banknotes" class="w-8 h-8 text-green-600 group-hover:text-green-800 transition-colors duration-300" />
                            <span class="text-xl font-bold relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-green-800 after:transition-all after:duration-300 group-hover:after:w-full">TARIFAS</span>
                        </a> --}}
                    </div>

                    <!-- User Actions with animations -->
                    <div class="flex items-center space-x-4">
                        <a href="#"
                            class="text-green-600 transition-all duration-300 hover:text-green-800 hover:scale-110 relative">
                            <x-mary-icon name="s-shopping-cart" class="w-8 h-8" />
                            <span
                                class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-green-500 text-xs text-white opacity-0 transition-opacity duration-300 hover:opacity-100">0</span>
                        </a>
                        <div class="relative">
                            <a href="/login"
                                class="text-green-600 transition-all duration-300 hover:text-green-800 hover:scale-110">
                                <x-mary-icon name="s-user" class="w-8 h-8" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation with slide animation -->
            <div class="md:hidden">
                <div id="mobile-menu"
                    class="hidden px-2 pt-2 pb-3 space-y-1 bg-green-50 border-t border-green-200 transition-all duration-300">
                    <a href="/"
                        class="block py-2 px-4 text-xl font-bold text-green-600 hover:text-green-800 hover:bg-green-100 rounded-md transition-all duration-300">INICIO</a>
                    <a href="/track"
                        class="block py-2 px-4 text-xl font-bold text-green-600 hover:text-green-800 hover:bg-green-100 rounded-md transition-all duration-300">RASTREA</a>
                    <a href="/pay"
                        class="block py-2 px-4 text-xl font-bold text-green-600 hover:text-green-800 hover:bg-green-100 rounded-md transition-all duration-300">PAGALO</a>
                    <a href="/agencies"
                        class="block py-2 px-4 text-xl font-bold text-green-600 hover:text-green-800 hover:bg-green-100 rounded-md transition-all duration-300">AGENCIAS</a>
                    <a href="/rates"
                        class="block py-2 px-4 text-xl font-bold text-green-600 hover:text-green-800 hover:bg-green-100 rounded-md transition-all duration-300">TARIFAS</a>
                </div>
            </div>
        </nav>

        <main class="min-h-screen relative z-10">
            <div class="container px-4 py-8 mx-auto max-w-7xl">
                <div class="flex flex-col gap-8 lg:flex-row">
                    <!-- Sidebar Navigation -->
                    <aside class="w-full lg:w-64 shrink-0">
                        <div class="overflow-hidden bg-white rounded-lg shadow">
                            <!-- Brand Header -->
                            <div class="p-4 border-b">
                                <h1 class="flex items-center text-xl font-semibold">
                                    <a href="/nosotros"
                                        class="text-green-500 transition-colors duration-200 hover:text-blue-500">
                                        NOSOTROS
                                    </a>
                                </h1>
                            </div>

                            <!-- Navigation Menu -->
                            <nav class="divide-y divide-gray-100">
                                <!-- Services Section -->
                                <div class="menu-section" x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="flex items-center w-full p-4 text-left hover:bg-gray-50 group">
                                        <span class="ml-3 font-medium text-gray-900">Servicios</span>
                                        <svg class="w-5 h-5 ml-auto text-gray-400 transition-transform"
                                            :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                                        x-transition:enter-end="opacity-100 transform translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 transform translate-y-0"
                                        x-transition:leave-end="opacity-0 transform -translate-y-2"
                                        class="px-4 py-2 bg-gray-50">
                                        <a href="/servicios/courier"
                                            class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Courier</a>
                                        <a href="/servicios/mudanza"
                                            class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Mudanza</a>
                                        <a href="/servicios/almacen"
                                            class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Almacén</a>
                                        <a href="/servicios/door-to-door"
                                            class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Door
                                            to
                                            Door</a>
                                        <a href="/servicios/recojo"
                                            class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Recojo</a>
                                        <a href="/servicios/carga-consolidada"
                                            class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Carga
                                            Consolidada</a>
                                        <a href="/servicios/traslados-vehiculos"
                                            class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Traslados
                                            de Vehículos</a>
                                        <a href="/servicios/traslados-contenedores"
                                            class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Traslado
                                            de Contenedores</a>
                                    </div>
                                </div>

                                <!-- Shipping Section -->
                                <div class="menu-section" x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="flex items-center w-full p-4 text-left hover:bg-gray-50 group">
                                        <span class="ml-3 font-medium text-gray-900">Comunicate</span>
                                        <svg class="w-5 h-5 ml-auto text-gray-400 transition-transform"
                                            :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                                        x-transition:enter-end="opacity-100 transform translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 transform translate-y-0"
                                        x-transition:leave-end="opacity-0 transform -translate-y-2"
                                        class="px-4 py-2 bg-gray-50">
                                        <a href="/reclamaciones"
                                            class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Contactanos</a>
                                        <a href="/reclamaciones"
                                            class="block py-2 pl-8 text-sm text-gray-600 hover:text-abitae-green">Libro
                                            de
                                            Reclamaciones</a>
                                    </div>
                                </div>
                                <div class="menu-section">
                                    <a href="/prohibiciones"
                                        class="flex items-center w-full p-4 text-left hover:bg-gray-50 group">
                                        <span class="ml-3 font-medium text-gray-900">Prohibiciones</span>
                                        <svg class="w-5 h-5 ml-auto text-gray-400 -rotate-90" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="menu-section">
                                    <a href="/terminales"
                                        class="flex items-center w-full p-4 text-left hover:bg-gray-50 group">
                                        <span class="ml-3 font-medium text-gray-900">Terminales</span>
                                        <svg class="w-5 h-5 ml-auto text-gray-400 -rotate-90" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </a>
                                </div>

                                <div class="menu-section">
                                    <a href="/envia"
                                        class="flex items-center w-full p-4 text-left hover:bg-gray-50 group">
                                        <span class="ml-3 font-medium text-gray-900">Envía</span>
                                        <svg class="w-5 h-5 ml-auto text-gray-400 -rotate-90" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </a>
                                </div>

                                <div class="menu-section">
                                    <a href="/rastrea"
                                        class="flex items-center w-full p-4 text-left hover:bg-gray-50 group">
                                        <span class="ml-3 font-medium text-gray-900">Rastrea tu Envío</span>
                                        <svg class="w-5 h-5 ml-auto text-gray-400 -rotate-90" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </a>
                                </div>

                                <div class="menu-section">
                                    <a href="/terminales"
                                        class="flex items-center w-full p-4 text-left hover:bg-gray-50 group">
                                        <span class="ml-3 font-medium text-gray-900">Agencias</span>
                                        <svg class="w-5 h-5 ml-auto text-gray-400 -rotate-90" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </a>
                                </div>


                            </nav>
                        </div>
                    </aside>
                    <!-- Main Content Area -->
                    <div class="flex-1">
                        <div class="p-6 bg-white rounded-lg shadow">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-10 text-green-500 bg-gray-800">
            <div class="px-5 mx-auto max-w-7xl">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div>
                        <h3 class="mb-4 text-xl font-bold">CORPORACIÓN LOGÍSTICO BRAYAN BRUSH E.I.R.L.</h3>
                        <p class="mb-4 text-gray-400">Tu mejor opción para envíos seguros y confiables en todo el país.
                        </p>
                        <div class="flex space-x-6">
                            <a href="http://fb.com/BrayanBrushTransporte"
                                class="text-gray-400 transition-colors duration-300 hover:text-green-500"
                                target="_blank">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                                </svg>
                            </a>
                            <a href="https://www.instagram.com/brayan_brush"
                                class="text-gray-400 transition-colors duration-300 hover:text-green-500"
                                target="_blank">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-green-500">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M18.403 5.633A8.919 8.919 0 0 0 12.053 3c-4.948 0-8.976 4.027-8.978 8.977 0 1.582.413 3.126 1.198 4.488L3 21.116l4.759-1.249a8.981 8.981 0 0 0 4.29 1.093h.004c4.947 0 8.975-4.027 8.977-8.977a8.926 8.926 0 0 0-2.627-6.35m-6.35 13.812h-.003a7.446 7.446 0 0 1-3.798-1.041l-.272-.162-2.824.741.753-2.753-.177-.282a7.448 7.448 0 0 1-1.141-3.971c.002-4.114 3.349-7.461 7.465-7.461a7.413 7.413 0 0 1 5.275 2.188 7.42 7.42 0 0 1 2.183 5.279c-.002 4.114-3.349 7.462-7.461 7.462m4.093-5.589c-.225-.113-1.327-.655-1.533-.73-.205-.075-.354-.112-.504.112s-.58.729-.711.879-.262.168-.486.056-.947-.349-1.804-1.113c-.667-.595-1.117-1.329-1.248-1.554s-.014-.346.099-.458c.101-.1.224-.262.336-.393.112-.131.149-.224.224-.374s.038-.281-.019-.393c-.056-.113-.505-1.217-.692-1.666-.181-.435-.366-.377-.504-.383a9.65 9.65 0 0 0-.429-.008.826.826 0 0 0-.599.28c-.206.225-.785.767-.785 1.871s.804 2.171.916 2.321c.112.15 1.582 2.415 3.832 3.387.536.231.954.369 1.279.473.537.171 1.026.146 1.413.089.431-.064 1.327-.542 1.514-1.066.187-.524.187-.973.131-1.067-.056-.094-.207-.151-.43-.263">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h3 class="mb-4 text-lg font-semibold">Enlaces Importantes</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="/prohibiciones"
                                    class="text-gray-400 transition-colors duration-300 hover:text-green-500">
                                    Tipos de embalaje permitidos
                                </a>
                            </li>
                            <li>
                                <a href="/prohibiciones"
                                    class="text-gray-400 transition-colors duration-300 hover:text-green-500">
                                    Protege tus envíos
                                </a>
                            </li>
                            <li>
                                <a href="/terminos"
                                    class="text-gray-400 transition-colors duration-300 hover:text-green-500">
                                    Términos y condiciones
                                </a>
                            </li>
                            <li>
                                <a href="/reclamaciones"
                                    class="text-gray-400 transition-colors duration-300 hover:text-green-500">
                                    Libro de Reclamaciones
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="mb-4 text-lg font-semibold">Contacto</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 0C4.477 0 0 4.477 0 10c0 5.523 4.477 10 10 10s10-4.477 10-10C20 4.477 15.523 0 10 0zm0 18.75c-4.832 0-8.75-3.918-8.75-8.75S5.168 1.25 10 1.25 18.75 5.168 18.75 10 14.832 18.75 10 18.75zm0-15.357c-2.475 0-4.5 2.025-4.5 4.5 0 3.75 4.5 9.107 4.5 9.107s4.5-5.357 4.5-9.107c0-2.475-2.025-4.5-4.5-4.5zm0 6.107c-.966 0-1.75-.784-1.75-1.75s.784-1.75 1.75-1.75 1.75.784 1.75 1.75-.784 1.75-1.75 1.75z" />
                                </svg>
                                <span>Av. Principal 123, Lima, Perú</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                <span>+51 123 456 789</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                <span>contacto@brayan.pe</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="pt-8 mt-8 text-center text-gray-400 border-t border-gray-700">
                    <p>&copy; 2023 Brayan. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Usar RequestAnimationFrame para mejor rendimiento
                let rafId;
                const container = document.querySelector('.animated-background');
                const shapes = ['circle', 'square', 'triangle'];
                const shapeCount = Math.min(30, Math.floor(window.innerWidth /
                    50)); // Ajuste dinámico basado en viewport
                const shapes3D = [];

                // Crear shapes con DocumentFragment para mejor rendimiento
                function createShapes() {
                    const fragment = document.createDocumentFragment();

                    for (let i = 0; i < shapeCount; i++) {
                        const shape = document.createElement('div');
                        const shapeType = shapes[Math.floor(Math.random() * shapes.length)];

                        shape.className = `geometric-shape ${shapeType}`;
                        const size = Math.random() * 30 + 30;

                        Object.assign(shape.style, {
                            width: `${size}px`,
                            height: `${size}px`,
                            transform: 'translate3d(0,0,0)'
                        });

                        shapes3D.push({
                            element: shape,
                            x: Math.random() * window.innerWidth,
                            y: Math.random() * window.innerHeight,
                            size,
                            angle: Math.random() * Math.PI * 2,
                            speed: Math.random() * 0.3 + 0.1,
                            rotation: 0,
                            rotationSpeed: (Math.random() - 0.5) * 0.8,
                            amplitude: Math.random() * 25 + 20,
                            offset: Math.random() * Math.PI * 2
                        });

                        fragment.appendChild(shape);
                    }

                    container.appendChild(fragment);
                }

                // Optimizar función de animación
                function animate() {
                    const time = performance.now() / 2500;

                    shapes3D.forEach(shape => {
                        shape.x += Math.cos(shape.angle) * shape.speed;
                        shape.y += Math.sin(shape.angle) * shape.speed;

                        const wave = Math.sin(time + shape.offset) * shape.amplitude;
                        const adjustedX = shape.x + wave;
                        const adjustedY = shape.y + wave;

                        // Límites de pantalla
                        if (adjustedX < -shape.size) shape.x = window.innerWidth + shape.size;
                        if (adjustedX > window.innerWidth + shape.size) shape.x = -shape.size;
                        if (adjustedY < -shape.size) shape.y = window.innerHeight + shape.size;
                        if (adjustedY > window.innerHeight + shape.size) shape.y = -shape.size;

                        // Usar transform3d para mejor rendimiento
                        shape.element.style.transform =
                            `translate3d(${adjustedX}px, ${adjustedY}px, 0) rotate(${shape.rotation}deg)`;
                        shape.element.style.opacity = 0.2 + Math.sin(time + shape.offset) * 0.1;
                    });

                    rafId = requestAnimationFrame(animate);
                }

                // Optimizar evento resize con throttle
                let resizeTimeout;
                window.addEventListener('resize', () => {
                    if (resizeTimeout) clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(handleResize, 100);
                });

                function handleResize() {
                    const width = window.innerWidth;
                    const height = window.innerHeight;

                    shapes3D.forEach(shape => {
                        shape.x = Math.min(shape.x, width - shape.size);
                        shape.y = Math.min(shape.y, height - shape.size);
                    });
                }

                // Optimizar interacción del mouse con throttle
                let mouseX = 0,
                    mouseY = 0;
                let mouseTimeout;

                document.addEventListener('mousemove', (e) => {
                    if (mouseTimeout) return;
                    mouseTimeout = setTimeout(() => {
                        mouseX = e.clientX;
                        mouseY = e.clientY;
                        mouseTimeout = null;
                    }, 16); // ~60fps
                }, {
                    passive: true
                });

                // Cleanup function
                function cleanup() {
                    cancelAnimationFrame(rafId);
                    container.innerHTML = '';
                    shapes3D.length = 0;
                }

                // Inicializar
                createShapes();
                animate();

                // Limpiar en caso de que el componente se desmonte
                window.addEventListener('unload', cleanup);
            });

            // Agregar partículas flotantes
            document.addEventListener('DOMContentLoaded', function() {
                const particlesContainer = document.getElementById('particles');
                const numberOfParticles = 50;

                for (let i = 0; i < numberOfParticles; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    particle.style.width = Math.random() * 20 + 10 + 'px';
                    particle.style.height = particle.style.width;
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.top = Math.random() * 100 + '%';
                    particle.style.animationDelay = Math.random() * 10 + 's';
                    particlesContainer.appendChild(particle);
                }
            });
        </script>
</body>

</html>
