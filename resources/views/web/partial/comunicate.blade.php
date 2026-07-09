<x-web-layout>
    <div class="container px-4 py-12 mx-auto">
        <h1 class="mb-8 text-4xl font-bold text-center text-gray-800">Comunícate con Nosotros</h1>

        <div class="max-w-5xl mx-auto">
            <div class="grid md:grid-cols-2 gap-8">
                {{-- Formulario de Contacto --}}
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Envíanos un Mensaje</h2>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                            <input type="text"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                            <input type="email"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Asunto</label>
                            <input type="text"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje</label>
                            <textarea rows="4" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full py-3 px-6 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200">
                            Enviar Mensaje
                        </button>
                    </form>
                </div>

                {{-- Información de Contacto --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Información de Contacto</h3>
                        <div class="space-y-3">
                            <p class="flex items-center text-gray-600">
                                <i class="fas fa-phone text-blue-600 mr-3"></i>
                                (01) 123-4567
                            </p>
                            <p class="flex items-center text-gray-600">
                                <i class="fas fa-envelope text-blue-600 mr-3"></i>
                                contacto@empresa.com
                            </p>
                            <p class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt text-blue-600 mr-3"></i>
                                Av. Principal 123, Lima
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Horario de Atención</h3>
                        <div class="space-y-2 text-gray-600">
                            <p>Lunes a Viernes: 8:00 AM - 6:00 PM</p>
                            <p>Sábados: 9:00 AM - 1:00 PM</p>
                            <p>Domingos: Cerrado</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Redes Sociales</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-blue-600 hover:text-blue-700">
                                <i class="fab fa-facebook text-2xl"></i>
                            </a>
                            <a href="#" class="text-blue-400 hover:text-blue-500">
                                <i class="fab fa-twitter text-2xl"></i>
                            </a>
                            <a href="#" class="text-pink-600 hover:text-pink-700">
                                <i class="fab fa-instagram text-2xl"></i>
                            </a>
                            <a href="#" class="text-blue-700 hover:text-blue-800">
                                <i class="fab fa-linkedin text-2xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web-layout>
