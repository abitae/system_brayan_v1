<div class="container px-4 py-12 mx-auto">
    <h1 class="mb-12 text-4xl font-bold text-center text-gray-800">
        Nuestros Servicios de Transporte y Logística
    </h1>

    <!-- Mudanza -->
    <div class="flex flex-col items-center justify-between gap-8 mb-16 md:flex-row">
        <div class="w-full md:w-1/2">
            <img src="{{ asset('img/web/servicios/mudanza.jpg') }}" alt="Servicio de Mudanza"
                class="w-full h-auto rounded-lg shadow-lg object-cover" loading="lazy">
        </div>
        <div class="w-full md:w-1/2">
            <h2 class="mb-4 text-2xl font-semibold text-gray-800">Servicio de Mudanza</h2>
            <p class="mb-4 leading-relaxed text-gray-600">
                Realizamos mudanzas seguras y eficientes para hogares y empresas, asegurando el traslado de sus pertenencias con el máximo cuidado. Nuestro servicio incluye:
            </p>
            <ul class="mb-6 space-y-2 text-gray-600">
                <li class="flex items-start">
                    <svg class="w-5 h-5 mt-1 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Planificación detallada del transporte
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mt-1 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Personal altamente capacitado
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mt-1 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Vehículos especializados para cada tipo de carga
                </li>
            </ul>
            <div class="mt-6">
                <a href="/cotizar" class="inline-flex items-center px-6 py-3 font-medium text-white transition duration-300 bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="mr-2 fas fa-home"></i> Cotizar Mudanza
                </a>
            </div>
        </div>
    </div>

    <!-- Almacén -->
    <div class="flex flex-col items-center justify-between gap-8 mb-16 md:flex-row-reverse">
        <div class="w-full md:w-1/2">
            <img src="{{ asset('img/web/servicios/almacen.jpg') }}" alt="Servicios de Almacenamiento"
                class="w-full h-auto rounded-lg shadow-lg object-cover" loading="lazy">
        </div>
        <div class="w-full md:w-1/2">
            <h2 class="mb-4 text-2xl font-semibold text-gray-800">Almacenamiento Especializado</h2>
            <p class="mb-4 leading-relaxed text-gray-600">
                Ofrecemos soluciones de almacenamiento con instalaciones adaptadas para preservar distintos tipos de mercancías, con:
            </p>
            <ul class="mb-6 space-y-2 text-gray-600">
                <li class="flex items-start">
                    <svg class="w-5 h-5 mt-1 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Monitoreo constante 24/7
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mt-1 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Control de acceso seguro
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mt-1 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Flexibilidad en tiempos de almacenamiento
                </li>
            </ul>
            <div class="mt-6">
                <a href="/cotizar" class="inline-flex items-center px-6 py-3 font-medium text-white transition duration-300 bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="mr-2 fas fa-warehouse"></i> Solicitar Información
                </a>
            </div>
        </div>
    </div>

    <!-- Servicios Especializados Grid -->
    <div class="grid grid-cols-1 gap-8 mb-16 md:grid-cols-2 lg:grid-cols-3">
        <!-- Door to Door -->
        <div class="p-6 transition-all duration-300 bg-white rounded-lg shadow-md hover:shadow-xl">
            <div class="mb-4 text-center">
                <i class="text-4xl text-blue-600 fas fa-door-open"></i>
            </div>
            <h3 class="mb-3 text-xl font-semibold text-center text-gray-800">Door to Door</h3>
            <p class="text-gray-600">
                Servicio puerta a puerta con recolección y entrega personalizada. Ideal para envíos que requieren atención especial y seguimiento detallado.
            </p>
        </div>

        <!-- Carga Consolidada -->
        <div class="p-6 transition-all duration-300 bg-white rounded-lg shadow-md hover:shadow-xl">
            <div class="mb-4 text-center">
                <i class="text-4xl text-blue-600 fas fa-boxes"></i>
            </div>
            <h3 class="mb-3 text-xl font-semibold text-center text-gray-800">Carga Consolidada</h3>
            <p class="text-gray-600">
                Optimizamos costos y tiempos integrando mercancías de diferentes clientes en un solo envío, manteniendo la eficiencia logística.
            </p>
        </div>

        <!-- Traslado de Vehículos -->
        <div class="p-6 transition-all duration-300 bg-white rounded-lg shadow-md hover:shadow-xl">
            <div class="mb-4 text-center">
                <i class="text-4xl text-blue-600 fas fa-car"></i>
            </div>
            <h3 class="mb-3 text-xl font-semibold text-center text-gray-800">Traslado de Vehículos</h3>
            <p class="text-gray-600">
                Transporte especializado para vehículos particulares y comerciales con equipos y procesos que garantizan máxima seguridad.
            </p>
        </div>

        <!-- Traslado de Contenedores -->
        <div class="p-6 transition-all duration-300 bg-white rounded-lg shadow-md hover:shadow-xl">
            <div class="mb-4 text-center">
                <i class="text-4xl text-blue-600 fas fa-shipping-fast"></i>
            </div>
            <h3 class="mb-3 text-xl font-semibold text-center text-gray-800">Traslado de Contenedores</h3>
            <p class="text-gray-600">
                Movilización de contenedores con altos estándares de seguridad y cumplimiento normativo en rutas nacionales.
            </p>
        </div>

        <!-- Servicio de Recojo -->
        <div class="p-6 transition-all duration-300 bg-white rounded-lg shadow-md hover:shadow-xl">
            <div class="mb-4 text-center">
                <i class="text-4xl text-blue-600 fas fa-truck-loading"></i>
            </div>
            <h3 class="mb-3 text-xl font-semibold text-center text-gray-800">Servicio de Recojo</h3>
            <p class="text-gray-600">
                Facilitamos el recojo de mercancías desde cualquier punto de origen, adaptándonos a sus necesidades específicas.
            </p>
        </div>
    </div>

    <!-- Llamado a la acción -->
    <div class="p-8 text-center bg-blue-50 rounded-xl shadow-md">
        <h2 class="mb-4 text-3xl font-semibold text-gray-800">¿Necesita un servicio de transporte confiable?</h2>
        <p class="max-w-3xl mx-auto mb-6 text-gray-600">
            Desde Lima hacia cualquier punto del Perú, nuestro equipo está listo para brindarle la mejor solución logística para su negocio.
        </p>
        <div class="flex justify-center gap-4">
            <a href="/cotizar" class="inline-flex items-center px-8 py-3 text-lg font-medium text-white transition duration-300 bg-blue-600 rounded-lg hover:bg-blue-700">
                <i class="mr-2 fas fa-calculator"></i> Solicitar Cotización
            </a>
            <a href="/contacto" class="inline-flex items-center px-8 py-3 text-lg font-medium text-blue-600 transition duration-300 bg-white border-2 border-blue-600 rounded-lg hover:bg-blue-50">
                <i class="mr-2 fas fa-phone"></i> Contactar
            </a>
        </div>
    </div>
</div>