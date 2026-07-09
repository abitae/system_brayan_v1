<x-web-layout>
    <div class="container px-4 py-12 mx-auto">
        <h1 class="mb-8 text-4xl font-bold text-center text-gray-800">Artículos Prohibidos para Transporte</h1>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            {{-- Artículos Prohibidos --}}
            <div class="p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center mb-4">
                    <i class="text-3xl text-red-500 fas fa-ban mr-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800">Materiales Peligrosos</h3>
                </div>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-2"></i>
                        <span>Explosivos y materiales inflamables</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-2"></i>
                        <span>Sustancias tóxicas o corrosivas</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-2"></i>
                        <span>Gases comprimidos</span>
                    </li>
                </ul>
            </div>

            <div class="p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center mb-4">
                    <i class="text-3xl text-red-500 fas fa-skull-crossbones mr-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800">Artículos Ilegales</h3>
                </div>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-2"></i>
                        <span>Drogas y estupefacientes</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-2"></i>
                        <span>Armas y municiones</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-2"></i>
                        <span>Mercancía de contrabando</span>
                    </li>
                </ul>
            </div>

            <div class="p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center mb-4">
                    <i class="text-3xl text-red-500 fas fa-exclamation-triangle mr-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800">Restricciones Especiales</h3>
                </div>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-2"></i>
                        <span>Dinero en efectivo</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-2"></i>
                        <span>Joyas y valores</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-times text-red-500 mt-1 mr-2"></i>
                        <span>Documentos confidenciales</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Advertencia Legal --}}
        <div class="mt-12 p-6 bg-red-50 rounded-xl border border-red-200">
            <h2 class="text-2xl font-semibold text-red-800 mb-4">Aviso Importante</h2>
            <p class="text-red-700 mb-4">
                El envío de artículos prohibidos está sujeto a sanciones legales y puede resultar en la cancelación del
                servicio sin derecho a reembolso.
            </p>
            <p class="text-red-700">
                Si tiene dudas sobre algún artículo específico, por favor contáctenos antes de realizar el envío.
            </p>
        </div>
    </div>
</x-web-layout>
