<div class="container px-4 py-12 mx-auto">
    {{-- Sección: Quiénes Somos --}}
    <div class="mb-16">
        <h1 class="mb-2 text-4xl font-bold text-center text-gray-800">Desde 2016, moviendo confianza y oportunidades</h1>
        <div class="flex flex-col items-center gap-8 mt-12 md:flex-row">
            <div class="w-full md:w-1/2">
                <img src="{{ asset('img/web/fundadores.jpg') }}" alt="Fundadores y equipo operativo"
                    class="w-full h-auto rounded-lg shadow-xl" loading="lazy">
            </div>
            <div class="w-full md:w-1/2 space-y-4">
                <p class="text-lg leading-relaxed text-gray-600">
                    Corporación Logística Brayan Brush es una empresa peruana de transporte y logística, especializada en conectar cada rincón del país. Desde nuestros inicios, nos hemos enfocado en brindar soluciones rápidas y seguras para el envío de mercancías, apoyados en nuestra flota moderna y tecnología avanzada.
                </p>
                <p class="text-lg leading-relaxed text-gray-600">
                    Nuestro compromiso es ser el puente entre familias y negocios, generando vínculos que trascienden distancias.
                </p>
                <a href="#historia" class="inline-flex items-center px-6 py-3 mt-4 font-medium text-white transition-all duration-300 bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="mr-2 fas fa-book"></i> Conoce Nuestra Historia
                </a>
            </div>
        </div>
    </div>

    {{-- Sección: Misión y Visión --}}
    <div class="grid gap-8 mb-16 md:grid-cols-2">
        <div class="p-8 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="mb-6 text-center">
                <i class="text-4xl text-blue-600 fas fa-bullseye"></i>
                <h2 class="mt-4 text-2xl font-bold text-gray-800">Nuestra Misión</h2>
            </div>
            <p class="text-gray-600 leading-relaxed">
                Conectar, almacenar y entregar confianza a cada rincón del Perú. Proveemos soluciones de transporte de encomiendas y paquetería con cobertura nacional, eficiencia, seguridad, y rapidez. Nos respaldamos en una flota vehicular moderna, tecnología avanzada y el compromiso de nuestro talento humano, buscando crecer junto a nuestros clientes y comunidades.
            </p>
        </div>

        <div class="p-8 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="mb-6 text-center">
                <i class="text-4xl text-blue-600 fas fa-eye"></i>
                <h2 class="mt-4 text-2xl font-bold text-gray-800">Nuestra Visión</h2>
            </div>
            <p class="text-gray-600 leading-relaxed">
                Ser la empresa peruana líder en transporte empresarial y servicio logístico, llegando a los rincones más alejados del país. Aspiramos a generar vínculos sólidos con familias y negocios, convirtiéndonos en un anexo de su crecimiento, con servicios innovadores y sostenibles que transformen la logística en una experiencia confiable y memorable.
            </p>
        </div>
    </div>

    {{-- Sección: Beneficios --}}
    <div class="mb-16">
        <h2 class="mb-12 text-3xl font-bold text-center text-gray-800">Elegirnos es elegir confianza</h2>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="p-6 text-center bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300">
                <i class="mb-4 text-4xl text-blue-600 fas fa-clock"></i>
                <h3 class="mb-2 text-xl font-semibold text-gray-800">Tiempo Garantizado</h3>
                <p class="text-gray-600">Entregamos cuando lo necesitas.</p>
            </div>

            <div class="p-6 text-center bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300">
                <i class="mb-4 text-4xl text-blue-600 fas fa-map-marked-alt"></i>
                <h3 class="mb-2 text-xl font-semibold text-gray-800">Cobertura Nacional</h3>
                <p class="text-gray-600">Llevamos tu envío a donde sea.</p>
            </div>

            <div class="p-6 text-center bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300">
                <i class="mb-4 text-4xl text-blue-600 fas fa-satellite"></i>
                <h3 class="mb-2 text-xl font-semibold text-gray-800">Rastreo en Tiempo Real</h3>
                <p class="text-gray-600">Monitorea tu carga a cada paso.</p>
            </div>

            <div class="p-6 text-center bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300">
                <i class="mb-4 text-4xl text-blue-600 fas fa-calendar-check"></i>
                <h3 class="mb-2 text-xl font-semibold text-gray-800">Salidas Diarias</h3>
                <p class="text-gray-600">Flexibilidad para tus horarios.</p>
            </div>
        </div>
    </div>

    {{-- Sección: Testimonios --}}
    <div class="mb-16">
        <h2 class="mb-12 text-3xl font-bold text-center text-gray-800">Historias que nos mueven</h2>
        <div class="grid gap-8 md:grid-cols-3">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center mb-4">
                    <img src="{{ asset('img/web/testimonios/cliente1.jpg') }}" alt="Cliente satisfecho"
                        class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h3 class="font-semibold text-gray-800">María López</h3>
                        <p class="text-sm text-gray-600">Emprendedora</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">
                    "Gracias a su servicio de envíos, mi negocio online ha podido crecer y llegar a más clientes en todo el país."
                </p>
            </div>

            {{-- Agregar más testimonios siguiendo el mismo patrón --}}
        </div>
    </div>

    {{-- Llamado a la Acción --}}
    <div class="relative p-8 overflow-hidden bg-blue-600 rounded-xl">
        <div class="relative z-10 flex flex-col items-center md:flex-row">
            <div class="w-full md:w-2/3 text-white">
                <h2 class="mb-4 text-3xl font-bold">¡Confía en nosotros para tus envíos!</h2>
                <p class="mb-6 text-xl">Más que transporte, movemos emociones.</p>
                <a href="/enviar" class="inline-flex items-center px-8 py-3 font-bold text-blue-600 transition-all duration-300 bg-white rounded-lg hover:bg-gray-100">
                    <i class="mr-2 fas fa-paper-plane"></i> ¡Envía Ahora!
                </a>
            </div>
            <div class="w-full mt-6 md:w-1/3 md:mt-0">
                <img src="{{ asset('img/web/entrega-rural.jpg') }}" alt="Entrega en zona rural"
                    class="w-full h-auto rounded-lg shadow-lg" loading="lazy">
            </div>
        </div>
        <div class="absolute inset-0 bg-blue-700 opacity-10 pattern-dots"></div>
    </div>
</div>
