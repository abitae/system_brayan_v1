<x-web-layout>
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Título de la sección -->
            <div class="text-center mb-12" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)" x-show="shown"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform -translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0">
                <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Contáctanos</h1>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Estamos aquí para responder tus preguntas y ayudarte en lo que necesites.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Formulario de contacto -->
                <div class="bg-white rounded-lg shadow-lg p-8" x-intersect:enter="transition ease-out duration-500"
                    x-intersect:enter-start="opacity-0 transform -translate-x-4"
                    x-intersect:enter-end="opacity-100 transform translate-x-0">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Envíanos un mensaje</h2>

                    <form action="{{ route('contacto.enviar') }}" method="POST" class="space-y-6">
                        @csrf
                        <!-- ... resto del formulario ... -->
                    </form>
                </div>

                <!-- Información de contacto -->
                <div class="space-y-8" x-intersect:enter="transition ease-out duration-500"
                    x-intersect:enter-start="opacity-0 transform translate-x-4"
                    x-intersect:enter-end="opacity-100 transform translate-x-0">
                    <!-- Tarjetas de información -->
                    <div
                        class="bg-white rounded-lg shadow-lg p-6 transform hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Teléfono</h3>
                                <p class="mt-1 text-gray-600">
                                    <a href="tel:+51912345678" class="hover:text-blue-600 transition-colors">
                                        +51 912 345 678
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg shadow-lg p-6 transform hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Correo electrónico</h3>
                                <p class="mt-1 text-gray-600">
                                    <a href="mailto:contacto@empresa.com" class="hover:text-blue-600 transition-colors">
                                        contacto@empresa.com
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg shadow-lg p-6 transform hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Dirección</h3>
                                <p class="mt-1 text-gray-600">
                                    Av. Principal 123, Piso 4<br>
                                    Lima, Perú
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Mapa -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="h-64">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.964560177885!2d-77.03196068561798!3d-12.046654545143056!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c8b5d35662c7%3A0x45c5b25d0dccfb05!2sLima%2C%20Peru!5e0!3m2!1sen!2s!4v1625836825554!5m2!1sen!2s"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                    </div>

                    <!-- Redes sociales -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Síguenos en redes sociales</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors duration-300">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <!-- Añadir más redes sociales aquí -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web-layout>
