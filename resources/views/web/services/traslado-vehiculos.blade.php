<x-web-layout>
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative bg-blue-600">
            <div class="absolute inset-0">
                <img class="object-cover w-full h-full" src="{{ asset('img/services/traslado-vehiculos-hero.jpg') }}"
                    alt="Traslado de Vehículos">
                <div class="absolute inset-0 bg-blue-600 mix-blend-multiply"></div>
            </div>
            <div class="relative px-4 py-24 mx-auto max-w-7xl sm:py-32 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Traslado de
                    Vehículos
                </h1>
                <p class="max-w-3xl mt-6 text-xl text-blue-100">
                    Transporte seguro y profesional de vehículos a nivel nacional.
                </p>
            </div>
        </div>

        <!-- Características del servicio -->
        <div class="py-16 bg-white sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Nuestro Servicio</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Transporte especializado
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
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Seguridad garantizada</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Vehículos asegurados durante todo el trayecto.
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
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Equipos especializados</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Camiones porta-vehículos y personal capacitado.
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
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Documentación completa</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Gestión de todos los documentos necesarios.
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Tipos de vehículos -->
        <div class="bg-gray-50 py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Tipos de vehículos</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Transportamos todo tipo de vehículos
                    </p>
                </div>

                <div class="mt-10">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="pt-6">
                            <div class="flow-root bg-white rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Automóviles</h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        Sedanes, hatchbacks, SUVs y vehículos familiares.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <div class="flow-root bg-white rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Vehículos
                                        comerciales
                                    </h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        Camionetas, furgonetas y vehículos de carga ligera.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <div class="flow-root bg-white rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Vehículos
                                        especiales
                                    </h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        Vehículos de colección, deportivos y de lujo.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-blue-600">
            <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">¿Necesitas trasladar un vehículo?</span>
                </h2>
                <p class="mt-4 text-lg leading-6 text-blue-100">
                    Contáctanos para una cotización personalizada.
                </p>
                <a href="{{ route('contacto.enviar') }}"
                    class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 sm:w-auto">
                    Solicitar cotización
                </a>
            </div>
        </div>
    </div>
</x-web-layout>
