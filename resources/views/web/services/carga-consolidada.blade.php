<x-web-layout>
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative bg-blue-600">
            <div class="absolute inset-0">
                <img class="object-cover w-full h-full" src="{{ asset('img/services/carga-consolidada-hero.jpg') }}" alt="Carga Consolidada">
                <div class="absolute inset-0 bg-blue-600 mix-blend-multiply"></div>
            </div>
            <div class="relative px-4 py-24 mx-auto max-w-7xl sm:py-32 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Carga Consolidada</h1>
                <p class="max-w-3xl mt-6 text-xl text-blue-100">
                    Optimiza tus costos de envío consolidando tu carga con otros clientes.
                </p>
            </div>
        </div>

        <!-- Ventajas -->
        <div class="py-16 bg-white sm:py-24">
            <!-- ... contenido existente ... -->
        </div>

        <!-- Proceso -->
        <div class="bg-gray-50 py-16 sm:py-24">
            <!-- ... contenido existente ... -->
        </div>

        <!-- CTA -->
        <div class="bg-blue-600">
            <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">¿Interesado en consolidar tu carga?</span>
                </h2>
                <p class="mt-4 text-lg leading-6 text-blue-100">
                    Contáctanos para conocer más sobre nuestro servicio de carga consolidada.
                </p>
                <a href="{{ route('contacto.enviar') }}"
                    class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 sm:w-auto">
                    Solicitar información
                </a>
            </div>
        </div>
    </div>
</x-web-layout>
