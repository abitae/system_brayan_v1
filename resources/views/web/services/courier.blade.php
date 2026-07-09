<x-web-layout>
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative bg-blue-600">
            <div class="absolute inset-0">
                <img class="object-cover w-full h-full" src="{{ asset('img/services/courier-hero.jpg') }}"
                    alt="Servicio de Courier">
                <div class="absolute inset-0 bg-blue-600 mix-blend-multiply"></div>
            </div>
            <div class="relative px-4 py-24 mx-auto max-w-7xl sm:py-32 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Servicio de Courier
                </h1>
                <p class="max-w-3xl mt-6 text-xl text-blue-100">
                    Entrega rápida y segura de documentos y paquetes pequeños a nivel nacional e internacional.
                </p>
            </div>
        </div>

        <!-- Características del servicio -->
        <div class="py-16 bg-white sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Nuestro Servicio</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Envíos rápidos y confiables
                    </p>
                </div>

                <div class="mt-10">
                    <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                    <!-- Heroicon name: outline/clock -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Entrega Express</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Entregas en 24 horas para envíos locales y tiempos optimizados para envíos nacionales.
                            </dd>
                        </div>

                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                    <!-- Heroicon name: outline/shield-check -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Seguridad Garantizada</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Seguimiento en tiempo real y seguro para sus envíos más importantes.
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Tarifas -->
        <div class="bg-gray-50 py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Tarifas</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Precios competitivos
                    </p>
                </div>

                <!-- Tabla de precios o información de tarifas -->
                <div class="mt-10">
                    <!-- Agregar tabla o información de tarifas -->
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-blue-600">
            <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">¿Listo para enviar?</span>
                </h2>
                <p class="mt-4 text-lg leading-6 text-blue-100">
                    Contacta con nosotros para obtener una cotización personalizada.
                </p>
                <a href="{{ route('contacto.enviar') }}"
                    class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 sm:w-auto">
                    Contactar ahora
                </a>
            </div>
        </div>
    </div>
</x-web-layout>
