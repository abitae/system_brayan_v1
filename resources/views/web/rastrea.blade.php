<x-web-layout>
    <div class="flex flex-col items-center justify-center gap-8 mb-12 md:flex-row">
        <div class="w-full max-w-lg p-8 bg-gray-100 rounded-lg shadow-md md:w-1/2 animate__animated animate__fadeIn">
            <h2 class="mb-6 text-2xl text-center text-gray-800">Rastrear Encomienda</h2>
            <form action="{{ route('tracking.search') }}" method="POST" class="animate__animated animate__fadeInUp">
                @csrf
                <div class="mb-6">
                    <label for="tracking_number" class="block mb-2 text-gray-700">Codigo de traking</label>
                    <input type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        id="tracking" name="tracking" placeholder="Ingrese su codigo de traking" required>
                </div>

                <div class="mb-6">
                    <label for="security_code" class="block mb-2 text-gray-700">DNI o RUC</label>
                    <input type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        id="code" name="code" placeholder="Ingrese numero de documento" required>
                </div>

                <div class="text-center">
                    <button type="submit"
                        class="px-8 py-3 text-lg bg-blue-600 text-white rounded-md hover:bg-blue-700 transform hover:-translate-y-0.5 transition-all duration-300 hover:shadow-lg animate__animated animate__pulse animate__infinite">
                        <i class="mr-2 fas fa-search"></i>
                        Rastrear
                    </button>
                    <a href="{{ route('rastrea') }}"
                        class="px-8 py-3 text-lg bg-green-600 text-white rounded-md hover:bg-green-700 transform hover:-translate-y-0.5 transition-all duration-300 hover:shadow-lg animate__animated animate__pulse animate__infinite ml-2">
                        <i class="mr-2 fas fa-sync-alt"></i>
                        Nueva Búsqueda
                    </a>
                </div>
            </form>
        </div>
        @if (isset($encomienda))
            <!-- Image Section -->
            <div class="w-full max-w-lg md:w-1/2">
                @switch($encomienda->estado_encomienda)
                    @case('REGISTRADO')
                        <img src="{{ asset('img/web/rastrea/registrado.jpg') }}" alt="Tracking Illustration"
                            class="object-cover w-full h-full transition-transform duration-300 rounded-lg shadow-md animate__animated animate__fadeInRight hover:scale-110 cursor-zoom-in">
                    @break

                    @case('ENVIADO')
                        <img src="{{ asset('img/web/rastrea/camino.jpg') }}" alt="Tracking Illustration"
                            class="object-cover w-full h-full transition-transform duration-300 rounded-lg shadow-md animate__animated animate__fadeInRight hover:scale-110 cursor-zoom-in">
                    @break

                    @case('RECIBIDO')
                        <img src="{{ asset('img/web/rastrea/almacen.jpg') }}" alt="Tracking Illustration"
                            class="object-cover w-full h-full transition-transform duration-300 rounded-lg shadow-md animate__animated animate__fadeInRight hover:scale-110 cursor-zoom-in">
                    @break

                    @case('ENTREGADO')
                        <img src="{{ asset('img/web/rastrea/entregado.jpg') }}" alt="Tracking Illustration"
                            class="object-cover w-full h-full transition-transform duration-300 rounded-lg shadow-md animate__animated animate__fadeInRight hover:scale-110 cursor-zoom-in">
                    @break
                @endswitch
            </div>
        @else
            <div class="w-full max-w-lg md:w-1/2">
                <img src="{{ asset('img/web/rastrea/ticket.jpg') }}" alt="Tracking Illustration"
                    class="object-cover transition-transform duration-300 rounded-lg shadow-md h-80 animate__animated animate__fadeInRight hover:scale-125 cursor-zoom-in">
            </div>
        @endif
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
</x-web-layout>
