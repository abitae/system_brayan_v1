<x-web-layout>
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative bg-blue-600">
            <div class="absolute inset-0">
                <img class="object-cover w-full h-full" src="{{ asset('img/services/almacen-hero.jpg') }}"
                    alt="Servicio de Almacenaje">
                <div class="absolute inset-0 bg-blue-600 mix-blend-multiply"></div>
            </div>
            <div class="relative px-4 py-24 mx-auto max-w-7xl sm:py-32 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Almacenaje y
                    Distribución</h1>
                <p class="max-w-3xl mt-6 text-xl text-blue-100">
                    Soluciones integrales de almacenaje con sistemas de gestión avanzados.
                </p>
            </div>
        </div>

        <!-- Características principales -->
        <div class="py-16 bg-white sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Nuestras Instalaciones
                    </h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Almacenaje seguro y eficiente
                    </p>
                </div>

                <div class="mt-10">
                    <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Almacenaje Seguro</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Instalaciones monitoreadas 24/7 con control de temperatura y humedad.
                            </dd>
                        </div>

                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Gestión de Inventario</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Sistema WMS para control preciso de inventario en tiempo real.
                            </dd>
                        </div>

                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Distribución Eficiente</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Red de distribución optimizada para entregas rápidas y precisas.
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Servicios específicos -->
        <div class="bg-gray-50 py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Servicios</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Soluciones a tu medida
                    </p>
                </div>

                <!-- Lista de servicios específicos -->
                <div class="mt-10">
                    <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <li class="p-6 bg-white rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-900">Almacenaje a corto plazo</h3>
                            <p class="mt-2 text-base text-gray-500">Soluciones flexibles para necesidades temporales.
                            </p>
                        </li>
                        <li class="p-6 bg-white rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-900">Almacenaje a largo plazo</h3>
                            <p class="mt-2 text-base text-gray-500">Espacio dedicado para almacenamiento prolongado.</p>
                        </li>
                        <li class="p-6 bg-white rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-900">Cross-docking</h3>
                            <p class="mt-2 text-base text-gray-500">Minimiza el tiempo de almacenamiento con
                                distribución
                                directa.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-blue-600">
            <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">¿Necesitas espacio de almacenaje?</span>
                </h2>
                <p class="mt-4 text-lg leading-6 text-blue-100">
                    Contáctanos para conocer nuestras soluciones personalizadas.
                </p>
                <a href="{{ route('contacto.enviar') }}"
                    class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 sm:w-auto">
                    Solicitar información
                </a>
            </div>
        </div>
    </div>
</x-web-layout>
