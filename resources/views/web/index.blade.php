<x-web-layout>
    <!-- Promotional Cards -->
    <div class="container px-4 mx-auto">
        <div class="grid grid-cols-1 gap-4 mb-8 lg:grid-cols-8">
            <div class="lg:col-span-6">
                <!-- Carousel structure -->
                <div class="flex gap-4">
                    <!-- Responsive Carousel Container -->
                    <div class="relative w-full mx-auto">
                        <div class="overflow-hidden carousel-container">
                            <div class="carousel-track flex space-x-[10px] transition-transform duration-500"
                                id="carouselTrack">
                                <!-- Card 1 -->
                                <div class="flex-none carousel-item w-28 sm:w-32 md:w-36">
                                    <div
                                        class="h-48 overflow-hidden transition-shadow duration-300 bg-white rounded-lg shadow sm:h-56 md:h-60 hover:shadow-lg">
                                        <img src="{{ asset('img/web/carrusel/carrusel1.jpg') }}" alt="Registrar envío"
                                            class="object-cover w-full h-full transition-transform duration-300 cursor-pointer hover:scale-110"
                                            onclick="openFullImage(this.src, 'Registrar envío')">
                                    </div>
                                </div>
                                <!-- Card 2 -->
                                <div class="flex-none carousel-item w-28 sm:w-32 md:w-36">
                                    <div
                                        class="h-48 overflow-hidden transition-shadow duration-300 bg-white rounded-lg shadow sm:h-56 md:h-60 hover:shadow-lg">
                                        <img src="{{ asset('img/web/carrusel/carrusel2.jpg') }}" alt="Autogestiones"
                                            class="object-cover w-full h-full transition-transform duration-300 cursor-pointer hover:scale-110"
                                            onclick="openFullImage(this.src, 'Autogestiones')">
                                    </div>
                                </div>
                                <!-- Card 3 -->
                                <div class="flex-none carousel-item w-28 sm:w-32 md:w-36">
                                    <div
                                        class="h-48 overflow-hidden transition-shadow duration-300 bg-white rounded-lg shadow sm:h-56 md:h-60 hover:shadow-lg">
                                        <img src="{{ asset('img/web/carrusel/carrusel3.jpg') }}" alt="Tips para envíos"
                                            class="object-cover w-full h-full transition-transform duration-300 cursor-pointer hover:scale-110"
                                            onclick="openFullImage(this.src, 'Tips para envíos')">
                                    </div>
                                </div>
                                <!-- Card 4 -->
                                <div class="flex-none carousel-item w-28 sm:w-32 md:w-36">
                                    <div
                                        class="h-48 overflow-hidden transition-shadow duration-300 bg-white rounded-lg shadow sm:h-56 md:h-60 hover:shadow-lg">
                                        <img src="{{ asset('img/web/carrusel/carrusel4.jpg') }}" alt="Fraudes"
                                            class="object-cover w-full h-full transition-transform duration-300 cursor-pointer hover:scale-110"
                                            onclick="openFullImage(this.src, 'Fraudes')">
                                    </div>
                                </div>
                                <!-- Card 5 -->
                                <div class="flex-none carousel-item w-28 sm:w-32 md:w-36">
                                    <div
                                        class="h-48 overflow-hidden transition-shadow duration-300 bg-white rounded-lg shadow sm:h-56 md:h-60 hover:shadow-lg">
                                        <img src="{{ asset('img/web/carrusel/carrusel5.jpg') }}" alt="Envíos"
                                            class="object-cover w-full h-full transition-transform duration-300 cursor-pointer hover:scale-110"
                                            onclick="openFullImage(this.src, 'Envíos')">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Navigation Buttons -->
                        <button
                            class="absolute left-0 z-10 hidden p-2 transform -translate-y-1/2 bg-white rounded-full shadow-lg top-1/2 hover:bg-gray-100 focus:outline-none sm:block"
                            onclick="moveCarousel(-1)">
                            <svg class="w-4 h-4 md:w-6 md:h-6 text-abitae-green" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button
                            class="absolute right-0 z-10 hidden p-2 transform -translate-y-1/2 bg-white rounded-full shadow-lg top-1/2 hover:bg-gray-100 focus:outline-none sm:block"
                            onclick="moveCarousel(1)">
                            <svg class="w-4 h-4 md:w-6 md:h-6 text-abitae-green" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="w-full h-48 overflow-hidden bg-white rounded-lg shadow sm:h-56 md:h-60">
                    <img src="{{ asset('img/web/imagen_banner.jpg') }}" alt="Banner"
                        class="object-cover w-full h-full">
                </div>
            </div>
        </div>
    </div>


    <div class="flex flex-col gap-5 mb-2 md:flex-row">
        <div
            class="flex-1 relative overflow-hidden rounded-lg min-h-[300px] animate__animated animate__fadeInLeft hover:transform hover:scale-105 transition-transform duration-500">
            <img src="{{ asset('img/web/mapa_peru.jpg') }}" alt="Tarifas"
                class="absolute inset-0 object-cover w-full h-full animate__animated animate__pulse animate__infinite animate__slow">
        </div>
        <div
            class="flex-1 relative overflow-hidden rounded-lg min-h-[300px] animate__animated animate__fadeInRight hover:transform hover:scale-105 transition-transform duration-500">
            <img src="{{ asset('img/web/fotografia.jpg') }}" alt="Tarifas"
                class="absolute inset-0 object-cover w-full h-full animate__animated animate__pulse animate__infinite animate__slow">
        </div>
    </div>

    <!-- Features Section -->
    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
        <div class="p-6 bg-white rounded-lg shadow">
            <div class="mb-4 text-4xl text-abitae-green">📊</div>
            <h3 class="mb-2 text-xl font-semibold text-gray-800">Seguimiento en tiempo real</h3>
            <p class="text-gray-600">Monitorea tus envíos en cualquier momento desde nuestra plataforma web o
                aplicación móvil.</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <div class="mb-4 text-4xl text-abitae-green">🚚</div>
            <h3 class="mb-2 text-xl font-semibold text-gray-800">Entregas programadas</h3>
            <p class="text-gray-600">Programa tus envíos con anticipación y recibe notificaciones sobre su
                estado.</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <div class="mb-4 text-4xl text-abitae-green">💰</div>
            <h3 class="mb-2 text-xl font-semibold text-gray-800">Tarifas competitivas</h3>
            <p class="text-gray-600">Ofrecemos las mejores tarifas del mercado para tus envíos nacionales e
                internacionales.</p>
        </div>
    </div>

</x-web-layout>
