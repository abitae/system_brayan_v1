<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brayan - Servicio de Envíos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'abitae-green': '#00ac3d',
                        'abitae-yellow': '#ffcc00',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans bg-gray-100">
    <!-- filepath: /c:/Proyectos/transportes/resources/views/web2/index3.blade.php -->
    <div class="bg-abitae-green px-5 py-2.5 flex flex-wrap justify-between items-center">
        <div class="flex items-center pl-4 md:pl-80">
            <img src="{{ asset('img/logo.png') }}" alt="Brayan Brush Logo" class="h-24 text-white">
        </div>
        <div class="flex md:hidden">
            <button id="menu-toggle" class="text-white focus:outline-none">
                <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
        <div id="menu" class="flex-wrap justify-center hidden w-full gap-10 md:flex md:w-auto">
            <a href="#"
                class="flex flex-col items-center font-bold text-white no-underline transition-colors duration-300 text-md hover:text-abitae-yellow">
                <span class="text-md text-white mb-1.5">
                    <x-mary-icon name="o-home" class="text-white w-9 h-9" />
                </span>
                INICIO
            </a>
            <a href="{{ route('tracking') }}"
                class="flex flex-col items-center font-bold text-white no-underline transition-colors duration-300 text-md hover:text-abitae-yellow">
                <span class="text-md text-white mb-1.5">
                    <x-mary-icon name="o-eye" class="text-white w-9 h-9" />
                </span>
                RASTREA
            </a>
            <a href="#"
                class="flex flex-col items-center font-bold text-white no-underline transition-colors duration-300 text-md hover:text-abitae-yellow">
                <span class="text-md mb-1.5">
                    <x-mary-icon name="o-currency-dollar" class="text-white w-9 h-9" />
                </span>
                PAGALO
            </a>
            <a href="#"
                class="flex flex-col items-center font-bold text-white no-underline transition-colors duration-300 text-md hover:text-abitae-yellow">
                <span class="text-md mb-1.5">
                    <x-mary-icon name="o-map-pin" class="text-white w-9 h-9" />
                </span>
                AGENCIAS
            </a>
            <a href="#"
                class="flex flex-col items-center font-bold text-white no-underline transition-colors duration-300 text-md hover:text-abitae-yellow">
                <span class="text-md mb-1.5">
                    <x-mary-icon name="m-banknotes" class="text-white w-9 h-9" />
                </span>
                TARIFAS
            </a>
        </div>
        <div class="flex flex-wrap justify-center gap-5">
            <a href="#"
                class="flex flex-col items-center text-sm text-white no-underline transition-colors duration-300 hover:text-abitae-yellow">
                <span class="text-xl mb-1.5">
                    <x-mary-icon name="s-shopping-cart" class="w-10 h-10 text-white" />
                </span>
            </a>
            <div class="relative">
                <button id="user-menu-toggle"
                    class="flex flex-col items-center text-sm text-white no-underline transition-colors duration-300 hover:text-abitae-yellow">
                    <span class="text-xl mb-1.5">
                        <x-mary-icon name="s-user" class="w-10 h-10 text-white" />
                    </span>
                </button>
                <div id="user-menu" class="absolute right-0 z-20 hidden w-48 py-1 mt-2 bg-white rounded-md shadow-lg">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>
    <!-- filepath: /c:/Proyectos/transportes/resources/views/web2/index3.blade.php -->
    <div class="flex flex-col p-5 mx-auto md:flex-row max-w-7xl">
        <div class="w-full mb-5 mr-0 md:w-72 md:mr-5 md:mb-0">
            <div class="py-2 px-2.5 flex items-center border-b border-gray-200">

                <div  class="text-2xl">
                    Flota Brayan
                    <span
                        class="bg-abitae-green text-white text-xs px-2 py-0.5 rounded-full ml-2.5 inline-block">NUEVO</span>
                </div>
            </div>
            <div class="menu-item">
                <div class="py-2 px-2.5 flex items-center border-b border-gray-200 cursor-pointer">
                    <span class="mr-2.5 text-abitae-green">🔧</span>
                    <div class="text-xl">Servicios</div>
                    <span class="ml-auto text-xl transition-transform">+</span>
                </div>
                <div class="hidden py-2 pl-8 submenu bg-gray-50">
                    <div class="py-1.5"><a href="#" class="text-gray-600 hover:text-abitae-green">Servicio Nacional</a>
                    </div>
                    <div class="py-1.5"><a href="#" class="text-gray-600 hover:text-abitae-green">Servicio
                            Internacional</a></div>
                    <div class="py-1.5"><a href="#" class="text-gray-600 hover:text-abitae-green">Servicio Express</a>
                    </div>
                </div>
            </div>
            <div class="menu-item">
                <div class="py-2 px-2.5 flex items-center border-b border-gray-200 cursor-pointer">
                    <span class="mr-2.5 text-abitae-green">📦</span>
                    <div class="text-xl">Envía</div>
                    <span class="ml-auto text-xl transition-transform">+</span>
                </div>
                <div class="hidden py-2 pl-8 submenu bg-gray-50">
                    <div class="py-1.5"><a href="#" class="text-gray-600 hover:text-abitae-green">Crear Envío</a></div>
                    <div class="py-1.5"><a href="#" class="text-gray-600 hover:text-abitae-green">Rastrear Envío</a>
                    </div>
                    <div class="py-1.5"><a href="#" class="text-gray-600 hover:text-abitae-green">Cotizar</a></div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full md:w-[1024px] mx-auto">
            {{ $slot }}
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-10 text-white bg-gray-800">
        <div class="px-5 mx-auto max-w-7xl">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <div>
                    <h3 class="mb-4 text-xl font-bold">Brayan</h3>
                    <p class="mb-4 text-gray-400">Tu mejor opción para envíos seguros y confiables en todo el país.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 transition-colors duration-300 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 transition-colors duration-300 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.054 10.054 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 transition-colors duration-300 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-semibold">Enlaces rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 transition-colors duration-300 hover:text-white">Inicio</a>
                        </li>
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-white">Servicios</a></li>
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-white">Tarifas</a></li>
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-white">Agencias</a></li>
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-white">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-semibold">Servicios</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 transition-colors duration-300 hover:text-white">Envíos
                                nacionales</a></li>
                        <li><a href="#" class="text-gray-400 transition-colors duration-300 hover:text-white">Envíos
                                internacionales</a></li>
                        <li><a href="#"
                                class="text-gray-400 transition-colors duration-300 hover:text-white">Paquetería</a>
                        </li>
                        <li><a href="#" class="text-gray-400 transition-colors duration-300 hover:text-white">Carga
                                pesada</a></li>
                        <li><a href="#" class="text-gray-400 transition-colors duration-300 hover:text-white">Logística
                                integral</a></li>
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
                                    d="M17.924 2.617a.997.997 0 00-.215-.322l-.004-.004A.997.997 0 0017 2h-4a1 1 0 100 2h1.586l-3.293 3.293a1 1 0 001.414 1.414L16 5.414V7a1 1 0 102 0V3a.997.997 0 00-.076-.383z" />
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
                            <span>contacto@Brayan.pe</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 mt-8 text-center text-gray-400 border-t border-gray-700">
                <p>&copy; 2023 Brayan. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    <!-- Add this script before closing body tag -->
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const menu = document.getElementById('menu');
            const menuIcon = document.getElementById('menu-icon');
            menu.classList.toggle('hidden');

            // Toggle icon
            if (menu.classList.contains('hidden')) {
                menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>';
            } else {
                menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
            }
        });

        document.getElementById('user-menu-toggle').addEventListener('click', function () {
            document.getElementById('user-menu').classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            const userMenu = document.getElementById('user-menu');
            const userMenuToggle = document.getElementById('user-menu-toggle');
            if (!userMenu.contains(event.target) && !userMenuToggle.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuItems = document.querySelectorAll('.menu-item');

            menuItems.forEach(item => {
                const trigger = item.querySelector('.cursor-pointer');
                const submenu = item.querySelector('.submenu');
                const icon = trigger.querySelector('.ml-auto');

                trigger.addEventListener('click', () => {
                    // Toggle submenu visibility
                    submenu.classList.toggle('hidden');

                    // Rotate icon when menu is open
                    if (!submenu.classList.contains('hidden')) {
                        icon.style.transform = 'rotate(45deg)';
                    } else {
                        icon.style.transform = 'rotate(0)';
                    }

                    // Close other submenus
                    menuItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            const otherSubmenu = otherItem.querySelector('.submenu');
                            const otherIcon = otherItem.querySelector('.ml-auto');
                            otherSubmenu.classList.add('hidden');
                            otherIcon.style.transform = 'rotate(0)';
                        }
                    });
                });
            });
        });
    </script>

    <!-- Add this script before closing body tag -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const track = document.getElementById('carouselTrack');
        const items = track.querySelectorAll('.carousel-item');
        const itemWidth = 122; // 112px (w-28) + 10px spacing
        const visibleItems = 5;
        let currentIndex = 0;

        // Clone first 5 items and append them to the end
        for (let i = 0; i < visibleItems; i++) {
            const clone = items[i].cloneNode(true);
            track.appendChild(clone);
        }

        window.moveCarousel = function (direction) {
            currentIndex += direction;
            track.style.transition = 'transform 500ms ease-in-out';
            track.style.transform = `translateX(-${currentIndex * itemWidth}px)`;

            // Reset position when reaching the end
            if (currentIndex >= items.length || currentIndex < 0) {
                setTimeout(() => {
                    track.style.transition = 'none';
                    currentIndex = direction > 0 ? 0 : items.length - 1;
                    track.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
                }, 500);
            }
        }

        // Auto-play functionality
        let autoPlayInterval = setInterval(() => moveCarousel(1), 3000);

        // Pause on hover
        track.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
        track.addEventListener('mouseleave', () => {
            autoPlayInterval = setInterval(() => moveCarousel(1), 3000);
        });

        // Touch support
        let touchStartX = 0;
        let touchEndX = 0;

        track.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
            clearInterval(autoPlayInterval);
        });

        track.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            const swipeDistance = touchEndX - touchStartX;

            if (Math.abs(swipeDistance) > 50) {
                moveCarousel(swipeDistance > 0 ? -1 : 1);
            }

            autoPlayInterval = setInterval(() => moveCarousel(1), 3000);
        });
    });
    </script>
</body>

</html>
