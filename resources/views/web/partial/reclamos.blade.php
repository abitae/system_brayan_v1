<section class="py-12 overflow-hidden bg-gray-50" id="contacto">
    <div class="container px-4 mx-auto sm:px-6 lg:px-8">
        <!-- Título y subtítulo de la sección -->

        <!-- Pestañas para alternar entre contacto y libro de reclamaciones -->
        <div class="mb-8 text-center">
            <div class="inline-flex p-1 border border-gray-300 rounded-md bg-gray-50">
                <button type="button" id="tab-contacto"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md active-tab">
                    Formulario de Contacto
                </button>
                <button type="button" id="tab-reclamaciones"
                    class="px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-gray-900 hover:bg-gray-100">
                    Libro de Reclamaciones
                </button>
            </div>
        </div>

        <!-- Formulario a todo ancho (sin grid) -->
        <div class="max-w-4xl mx-auto">
            <!-- Contenedor de formularios con sistema de pestañas -->
            <div id="form-container" class="overflow-hidden bg-white shadow-xl rounded-2xl">
                <!-- Formulario de contacto -->
                <div id="contacto-form" class="form-content">
                    <div class="p-6 bg-blue-600">
                        <h3 class="text-2xl font-bold text-white">Envíanos un mensaje</h3>
                        <p class="mt-2 text-blue-100">Completa el formulario y nos pondremos en contacto contigo lo
                            antes
                            posible.</p>
                    </div>

                    <form action="{{ route('contacto.enviar') }}" method="POST" class="p-6 space-y-6">
                        @csrf

                        <!-- Alertas de estado -->
                        @if (session('success'))
                            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                                <ul class="pl-5 list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Campos del formulario -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="nombre" class="block mb-1 text-sm font-medium text-gray-700">Nombre
                                    completo*</label>
                                <input type="text" name="name" id="nombre" value="{{ old('nombre') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Tu nombre completo">
                            </div>

                            <div>
                                <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Correo
                                    electrónico *</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="ejemplo@correo.com">
                            </div>
                        </div>

                        <div>
                            <label for="telefono" class="block mb-1 text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="tel" name="phone" id="telefono" value="{{ old('telefono') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Tu número telefónico">
                        </div>

                        <div>
                            <label for="asunto" class="block mb-1 text-sm font-medium text-gray-700">Asunto *</label>
                            <select name="select" id="asunto" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Selecciona un asunto</option>
                                <option value="Información general"
                                    {{ old('asunto') == 'Información general' ? 'selected' : '' }}>Información general
                                </option>
                                <option value="Cotización" {{ old('asunto') == 'Cotización' ? 'selected' : '' }}>
                                    Cotización
                                </option>
                                <option value="Soporte técnico"
                                    {{ old('asunto') == 'Soporte técnico' ? 'selected' : '' }}>
                                    Soporte técnico</option>
                                <option value="Otro" {{ old('asunto') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>

                        <div>
                            <label for="mensaje" class="block mb-1 text-sm font-medium text-gray-700">Mensaje *</label>
                            <textarea name="message" id="mensaje" rows="4" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Escribe tu mensaje aquí...">{{ old('mensaje') }}</textarea>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="politicas" name="politicas" type="checkbox" required
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="politicas" class="font-medium text-gray-700">
                                    Acepto la <a href="{{ route('politicas-privacidad') }}"
                                        class="text-blue-600 hover:underline">política de privacidad</a> y el
                                    tratamiento de
                                    mis datos personales *
                                </label>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full px-4 py-3 font-medium text-center text-white transition duration-150 bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Enviar mensaje
                            </button>
                        </div>

                        <p class="mt-2 text-xs text-gray-500">
                            Los campos marcados con * son obligatorios
                        </p>
                    </form>
                </div>

                <!-- Formulario de Libro de Reclamaciones -->
                <div id="reclamaciones-form" class="hidden form-content">
                    <div class="p-6 bg-red-600">
                        <h3 class="text-2xl font-bold text-white">Libro de Reclamaciones</h3>
                        <p class="mt-2 text-red-100">Registra aquí tu reclamo o queja formal. Daremos seguimiento a tu
                            caso según la normativa vigente.</p>
                    </div>

                    <form action="{{ route('reclamaciones.enviar') }}" method="POST" class="p-6 space-y-6">
                        @csrf

                        <!-- Alertas de estado para reclamaciones -->
                        @if (session('reclamo_success'))
                            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                                {{ session('reclamo_success') }}
                            </div>
                        @endif

                        @if ($errors->has('reclamo_*'))
                            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                                <ul class="pl-5 list-disc">
                                    @foreach ($errors->all() as $error)
                                        @if (strpos($error, 'reclamo_') !== false)
                                            <li>{{ $error }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Detalles del consumidor -->
                        <div class="p-4 mb-4 border border-gray-200 rounded-lg bg-gray-50">
                            <h4 class="mb-3 text-lg font-semibold text-gray-800">Datos del consumidor</h4>

                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="reclamo_nombre"
                                        class="block mb-1 text-sm font-medium text-gray-700">Nombre completo *</label>
                                    <input type="text" name="reclamo_nombre" id="reclamo_nombre"
                                        value="{{ old('reclamo_nombre') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                                        placeholder="Tu nombre completo">
                                </div>

                                <div>
                                    <label for="reclamo_documento"
                                        class="block mb-1 text-sm font-medium text-gray-700">DNI/CE/Pasaporte *</label>
                                    <input type="text" name="reclamo_documento" id="reclamo_documento"
                                        value="{{ old('reclamo_documento') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                                        placeholder="Número de documento">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                                <div>
                                    <label for="reclamo_telefono"
                                        class="block mb-1 text-sm font-medium text-gray-700">Teléfono *</label>
                                    <input type="tel" name="reclamo_telefono" id="reclamo_telefono"
                                        value="{{ old('reclamo_telefono') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                                        placeholder="Tu número telefónico">
                                </div>

                                <div>
                                    <label for="reclamo_email"
                                        class="block mb-1 text-sm font-medium text-gray-700">Correo electrónico
                                        *</label>
                                    <input type="email" name="reclamo_email" id="reclamo_email"
                                        value="{{ old('reclamo_email') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                                        placeholder="ejemplo@correo.com">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="reclamo_direccion"
                                    class="block mb-1 text-sm font-medium text-gray-700">Dirección *</label>
                                <input type="text" name="reclamo_direccion" id="reclamo_direccion"
                                    value="{{ old('reclamo_direccion') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                                    placeholder="Tu dirección completa">
                            </div>
                        </div>

                        <!-- Detalles de la reclamación -->
                        <div class="p-4 mb-4 border border-gray-200 rounded-lg bg-gray-50">
                            <h4 class="mb-3 text-lg font-semibold text-gray-800">Detalles de la reclamación</h4>

                            <div>
                                <label for="reclamo_tipo" class="block mb-1 text-sm font-medium text-gray-700">Tipo
                                    *</label>
                                <div class="flex gap-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="reclamo_tipo" value="queja" required
                                            {{ old('reclamo_tipo') == 'queja' ? 'checked' : '' }}
                                            class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                                        <span class="ml-2 text-sm text-gray-700">Queja</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="reclamo_tipo" value="reclamo" required
                                            {{ old('reclamo_tipo') == 'reclamo' ? 'checked' : '' }}
                                            class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                                        <span class="ml-2 text-sm text-gray-700">Reclamo</span>
                                    </label>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Queja: Disconformidad no relacionada con productos o servicios.<br>
                                    Reclamo: Disconformidad relacionada con productos o servicios.
                                </p>
                            </div>

                            <div class="mt-4">
                                <label for="reclamo_producto"
                                    class="block mb-1 text-sm font-medium text-gray-700">Producto o servicio reclamado
                                    *</label>
                                <input type="text" name="reclamo_producto" id="reclamo_producto"
                                    value="{{ old('reclamo_producto') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                                    placeholder="Nombre del producto o servicio">
                            </div>

                            <div class="mt-4">
                                <label for="reclamo_monto" class="block mb-1 text-sm font-medium text-gray-700">Monto
                                    reclamado (S/)</label>
                                <input type="number" step="0.01" name="reclamo_monto" id="reclamo_monto"
                                    value="{{ old('reclamo_monto') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                                    placeholder="0.00">
                            </div>

                            <div class="mt-4">
                                <label for="reclamo_descripcion"
                                    class="block mb-1 text-sm font-medium text-gray-700">Descripción *</label>
                                <textarea name="reclamo_descripcion" id="reclamo_descripcion" rows="4" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                                    placeholder="Detalla aquí tu reclamo o queja...">{{ old('reclamo_descripcion') }}</textarea>
                            </div>

                            <div class="mt-4">
                                <label for="reclamo_pedido"
                                    class="block mb-1 text-sm font-medium text-gray-700">Pedido o solicitud *</label>
                                <textarea name="reclamo_pedido" id="reclamo_pedido" rows="4" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                                    placeholder="¿Qué solución esperas para tu reclamo?">{{ old('reclamo_pedido') }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="reclamo_politicas" name="reclamo_politicas" type="checkbox" required
                                    class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="reclamo_politicas" class="font-medium text-gray-700">
                                    Acepto la <a href="{{ route('politicas-privacidad') }}"
                                        class="text-red-600 hover:underline">política de privacidad</a> y declaro que
                                    los datos proporcionados son verídicos *
                                </label>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full px-4 py-3 font-medium text-center text-white transition duration-150 bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Registrar reclamo
                            </button>
                        </div>

                        <p class="mt-2 text-xs text-gray-500">
                            Los campos marcados con * son obligatorios. Tu reclamo será atendido en un plazo máximo de
                            30 días hábiles.
                        </p>
                    </form>
                </div>

                <!-- Redes sociales -->
                <div class="p-6 bg-white shadow-md rounded-xl">
                    <h4 class="mb-4 text-lg font-medium text-gray-900">Síguenos en redes sociales</h4>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="https://facebook.com/empresa" target="_blank" rel="noopener noreferrer"
                            class="text-blue-600 transition-colors hover:text-blue-700" aria-label="Facebook">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://twitter.com/empresa" target="_blank" rel="noopener noreferrer"
                            class="text-blue-400 transition-colors hover:text-blue-500" aria-label="Twitter">
                            <span class="sr-only">Twitter</span>
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="https://instagram.com/empresa" target="_blank" rel="noopener noreferrer"
                            class="text-pink-600 transition-colors hover:text-pink-700" aria-label="Instagram">
                            <span class="sr-only">Instagram</span>
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://linkedin.com/company/empresa" target="_blank" rel="noopener noreferrer"
                            class="text-blue-800 transition-colors hover:text-blue-900" aria-label="LinkedIn">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://wa.me/51912345678" target="_blank" rel="noopener noreferrer"
                            class="text-green-600 transition-colors hover:text-green-700" aria-label="WhatsApp">
                            <span class="sr-only">WhatsApp</span>
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M17.415 14.382c-.298-.149-1.759-.867-2.031-.967-.272-.099-.47-.148-.67.15-.198.296-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.019-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.297-.497.1-.198.05-.371-.025-.52-.074-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.064 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.57-.085 1.758-.719 2.006-1.413.247-.694.247-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.422 7.403h-.004a9.87 9.87 0 01-5.032-1.378l-.36-.214-3.742.982.999-3.648-.235-.374a9.861 9.861 0 01-1.511-5.26c.002-5.45 4.436-9.884 9.889-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.898 6.994c-.003 5.45-4.436 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Información de contacto (tarjetas) -->
            <div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2">
                <!-- Teléfono -->
                <div class="p-6 transition-transform bg-white shadow-md rounded-xl hover:scale-105">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Teléfono</h4>
                            <p class="mt-1 text-gray-600">
                                <a href="tel:+51912345678" class="transition-colors hover:text-blue-600">912 345
                                    678</a>
                            </p>
                            <p class="mt-1 text-gray-600">
                                <a href="tel:+5101234567" class="transition-colors hover:text-blue-600">(01)
                                    234-5678</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Correo electrónico -->
                <div class="p-6 transition-transform bg-white shadow-md rounded-xl hover:scale-105">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Correo electrónico</h4>
                            <p class="mt-1 text-gray-600">
                                <a href="mailto:info@empresa.com"
                                    class="transition-colors hover:text-blue-600">info@empresa.com</a>
                            </p>
                            <p class="mt-1 text-gray-600">
                                <a href="mailto:soporte@empresa.com"
                                    class="transition-colors hover:text-blue-600">soporte@empresa.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dirección y horario -->
            <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-2">
                <!-- Oficina principal -->
                <div class="p-6 transition-transform bg-white shadow-md rounded-xl hover:scale-105">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Oficina principal</h4>
                            <address class="mt-1 not-italic text-gray-600">
                                Av. Principal 123, Piso 4<br>
                                Lima, Perú
                            </address>
                        </div>
                    </div>
                </div>

                <!-- Horario de atención -->
                <div class="p-6 transition-transform bg-white shadow-md rounded-xl hover:scale-105">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Horario de atención</h4>
                            <p class="mt-1 text-gray-600">
                                Lunes a Viernes<br>
                                8:00 AM - 6:00 PM
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mapa de ubicación -->
            <div class="p-4 mt-8 overflow-hidden bg-white shadow-md rounded-xl">
                <h4 class="mb-4 text-lg font-medium text-gray-900">Nuestra ubicación</h4>
                <div class="overflow-hidden rounded-lg h-80">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d249744.0332046289!2d-77.12786346937012!3d-12.02695597895741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c5f619ee3ec7%3A0x14206cb9cc452e4a!2sLima!5e0!3m2!1ses!2spe!4v1688574558595!5m2!1ses!2spe"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" title="Ubicación de nuestra oficina en Lima">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript para manejar las pestañas -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabContacto = document.getElementById('tab-contacto');
        const tabReclamaciones = document.getElementById('tab-reclamaciones');
        const contactoForm = document.getElementById('contacto-form');
        const reclamacionesForm = document.getElementById('reclamaciones-form');

        tabContacto.addEventListener('click', function() {
            // Activar pestaña de contacto
            tabContacto.classList.add('bg-blue-600', 'text-white');
            tabContacto.classList.remove('text-gray-700', 'hover:bg-gray-100');

            // Desactivar pestaña de reclamaciones
            tabReclamaciones.classList.remove('bg-red-600', 'text-white');
            tabReclamaciones.classList.add('text-gray-700', 'hover:bg-gray-100');

            // Mostrar formulario de contacto y ocultar reclamaciones
            contactoForm.classList.remove('hidden');
            reclamacionesForm.classList.add('hidden');
        });

        tabReclamaciones.addEventListener('click', function() {
            // Activar pestaña de reclamaciones
            tabReclamaciones.classList.add('bg-red-600', 'text-white');
            tabReclamaciones.classList.remove('text-gray-700', 'hover:bg-gray-100');

            // Desactivar pestaña de contacto
            tabContacto.classList.remove('bg-blue-600', 'text-white');
            tabContacto.classList.add('text-gray-700', 'hover:bg-gray-100');

            // Mostrar formulario de reclamaciones y ocultar contacto
            reclamacionesForm.classList.remove('hidden');
            contactoForm.classList.add('hidden');
        });
    });
</script>
