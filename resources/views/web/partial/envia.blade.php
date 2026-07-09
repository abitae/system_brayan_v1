<x-web-layout>
    <div class="container px-4 py-12 mx-auto" x-data="{ showForm: false, showInfo: false }"
         x-init="setTimeout(() => showForm = true, 300); setTimeout(() => showInfo = true, 600)">
        <h1 class="mb-8 text-4xl font-bold text-center text-gray-800 transform transition-all duration-700 hover:scale-105">
            Envía tu Paquete
        </h1>

        <div class="max-w-4xl mx-auto">
            {{-- Formulario de Envío --}}
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 transition-all duration-500"
                 x-show="showForm"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                <form class="space-y-6" x-data="{ tipo: '', showPeso: false }">
                    {{-- Origen y Destino --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div class="transform transition-all duration-300 hover:scale-102">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad de Origen</label>
                            <select class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200">
                                <option value="">Seleccionar ciudad</option>
                                <option value="lima">Lima</option>
                                <option value="huancayo">Huancayo</option>
                                <option value="huancavelica">Huancavelica</option>
                            </select>
                        </div>
                        <div class="transform transition-all duration-300 hover:scale-102">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad de Destino</label>
                            <select class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200">
                                <option value="">Seleccionar ciudad</option>
                                <option value="lima">Lima</option>
                                <option value="huancayo">Huancayo</option>
                                <option value="huancavelica">Huancavelica</option>
                            </select>
                        </div>
                    </div>

                    {{-- Detalles del Paquete --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div class="transform transition-all duration-300 hover:scale-102">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Envío</label>
                            <select x-model="tipo"
                                    @change="showPeso = ['paquetes', 'carga_pesada'].includes(tipo)"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200">
                                <option value="">Seleccionar tipo</option>
                                <option value="documentos">Documentos</option>
                                <option value="paquetes">Paquetes</option>
                                <option value="carga_pesada">Carga Pesada</option>
                                <option value="mudanza">Mudanza</option>
                                <option value="vehiculos">Traslado de Vehículos</option>
                            </select>
                        </div>
                        <div x-show="showPeso"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             class="transform transition-all duration-300 hover:scale-102">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Peso (kg)</label>
                            <input type="number" min="0" step="0.1"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 px-6 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all duration-300 transform hover:scale-102 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <span class="flex items-center justify-center">
                            <i class="fas fa-calculator mr-2"></i>
                            Calcular Envío
                        </span>
                    </button>
                </form>
            </div>

            {{-- Información Adicional --}}
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6"
                 x-show="showInfo"
                 x-transition:enter="transition ease-out duration-500 delay-300"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                <div class="p-6 bg-blue-50 rounded-xl transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-truck text-3xl text-blue-600 mb-4 transform transition-all duration-300 hover:rotate-12"></i>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Envío Rápido</h3>
                    <p class="text-gray-600">Entrega en 24-48 horas a principales ciudades</p>
                </div>

                <div class="p-6 bg-blue-50 rounded-xl transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-shield-alt text-3xl text-blue-600 mb-4 transform transition-all duration-300 hover:rotate-12"></i>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Envío Seguro</h3>
                    <p class="text-gray-600">Seguimiento en tiempo real de tu envío</p>
                </div>

                <div class="p-6 bg-blue-50 rounded-xl transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-hand-holding-usd text-3xl text-blue-600 mb-4 transform transition-all duration-300 hover:rotate-12"></i>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Mejor Precio</h3>
                    <p class="text-gray-600">Tarifas competitivas garantizadas</p>
                </div>
            </div>

            {{-- Banner Promocional --}}
            <div class="mt-12 p-6 bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl shadow-xl text-white transform transition-all duration-500 hover:scale-102"
                 x-show="showInfo"
                 x-transition:enter="transition ease-out duration-500 delay-500"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-4 md:mb-0">
                        <h3 class="text-xl font-bold mb-2">¿Envíos frecuentes?</h3>
                        <p class="text-blue-100">Regístrate y obtén descuentos especiales</p>
                    </div>
                    <button class="px-6 py-2 bg-white text-blue-600 rounded-lg transform transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600">
                        Crear Cuenta
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-web-layout>
