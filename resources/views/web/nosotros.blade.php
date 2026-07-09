<x-web-layout>
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative bg-blue-600" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">
            <div class="absolute inset-0">
                <img class="w-full h-full object-cover" src="{{ asset('img/about-hero.jpg') }}" alt="Sobre Nosotros">
                <div class="absolute inset-0 bg-blue-600 mix-blend-multiply"></div>
            </div>
            <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
                <div x-show="shown"
                     x-transition:enter="transition ease-out duration-1000"
                     x-transition:enter-start="opacity-0 transform translate-y-10"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                        Sobre Nosotros
                    </h1>
                    <p class="mt-6 max-w-3xl text-xl text-blue-100">
                        Más de 15 años conectando destinos y entregando confianza en todo el Perú.
                    </p>
                </div>
            </div>
        </div>

        <!-- Historia y Misión -->
        <div class="relative py-16 bg-white overflow-hidden">
            <div class="relative px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div class="prose prose-lg text-gray-500 lg:max-w-none"
                             x-intersect:enter="transition ease-out duration-500"
                             x-intersect:enter-start="opacity-0 transform -translate-x-8"
                             x-intersect:enter-end="opacity-100 transform translate-x-0">
                            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Nuestra Historia</h2>
                            <p>
                                Fundada en 2008, nuestra empresa nació con la visión de transformar la industria del 
                                transporte y la logística en el Perú. Desde entonces, hemos crecido constantemente, 
                                innovando y adaptándonos a las necesidades cambiantes del mercado.
                            </p>
                            <p>
                                Hoy, somos líderes en soluciones logísticas integrales, ofreciendo servicios de 
                                primera calidad a empresas de todos los tamaños.
                            </p>
                        </div>
                        <div class="relative"
                             x-intersect:enter="transition ease-out duration-500"
                             x-intersect:enter-start="opacity-0 transform translate-x-8"
                             x-intersect:enter-end="opacity-100 transform translate-x-0">
                            <img src="{{ asset('img/about-history.jpg') }}" 
                                 alt="Nuestra Historia" 
                                 class="rounded-lg shadow-xl">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Valores -->
        <div class="bg-gray-50 py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Nuestros Valores</h2>
                    <p class="mt-4 text-lg text-gray-500">Los principios que guían nuestro trabajo diario</p>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                             x-intersect:enter="transition ease-out duration-500 delay-100"
                             x-intersect:enter-start="opacity-0 transform translate-y-8"
                             x-intersect:enter-end="opacity-100 transform translate-y-0">
                            <div class="text-blue-600">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Confianza</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Construimos relaciones duraderas basadas en la confianza y la transparencia.
                            </p>
                        </div>

                        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                             x-intersect:enter="transition ease-out duration-500 delay-200"
                             x-intersect:enter-start="opacity-0 transform translate-y-8"
                             x-intersect:enter-end="opacity-100 transform translate-y-0">
                            <div class="text-blue-600">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Eficiencia</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Optimizamos cada proceso para garantizar la mejor experiencia.
                            </p>
                        </div>

                        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                             x-intersect:enter="transition ease-out duration-500 delay-300"
                             x-intersect:enter-start="opacity-0 transform translate-y-8"
                             x-intersect:enter-end="opacity-100 transform translate-y-0">
                            <div class="text-blue-600">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Compromiso</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Dedicados a superar las expectativas de nuestros clientes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipo -->
        <div class="bg-white py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Nuestro Equipo
                    </h2>
                    <p class="mt-4 max-w-3xl mx-auto text-xl text-gray-500">
                        Profesionales comprometidos con la excelencia en el servicio
                    </p>
                </div>

                <div class="mt-16 grid grid-cols-1 gap-12 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Miembros del equipo -->
                    <template x-for="(member, index) in [
                        {
                            name: 'Juan Pérez',
                            position: 'CEO',
                            image: '/img/team/ceo.jpg'
                        },
                        {
                            name: 'María García',
                            position: 'Gerente de Operaciones',
                            image: '/img/team/operations.jpg'
                        },
                        {
                            name: 'Carlos López',
                            position: 'Director Comercial',
                            image: '/img/team/commercial.jpg'
                        }
                    ]">
                        <div class="text-center"
                             x-intersect:enter="transition ease-out duration-500"
                             x-intersect:enter-start="opacity-0 transform translate-y-8"
                             x-intersect:enter-end="opacity-100 transform translate-y-0">
                            <div class="space-y-4">
                                <img class="mx-auto h-40 w-40 rounded-full" :src="member.image" :alt="member.name">
                                <div class="space-y-2">
                                    <div class="text-lg leading-6 font-medium space-y-1">
                                        <h3 x-text="member.name" class="text-gray-900"></h3>
                                        <p x-text="member.position" class="text-blue-600"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-blue-600">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    <span class="block">¿Listo para trabajar con nosotros?</span>
                    <span class="block text-blue-200">Contáctanos hoy mismo.</span>
                </h2>
                <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                    <div class="inline-flex rounded-md shadow">
                        <a href="{{ route('contacto.enviar') }}"
                           class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 transform hover:scale-105 transition-all duration-300">
                            Contactar ahora
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web-layout>
