<x-web-layout>
    @include('web.partial.page-hero', [
        'title' => 'Contacto',
        'subtitle' => 'Escríbenos para cotizaciones, seguimiento o consultas operativas.',
        'image' => 'img/web/generic/atencion.jpg',
    ])

    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-14 grid lg:grid-cols-2 gap-10">
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold mb-6">Envíanos un mensaje</h2>

            @if (session('success') || isset($success))
                <div class="p-4 mb-4 text-sm rounded-xl bg-rana-lime/20 text-rana-dark">{{ session('success') ?? $success }}</div>
            @endif
            @if (session('error'))
                <div class="p-4 mb-4 text-sm rounded-xl bg-red-100 text-red-700">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="p-4 mb-4 text-sm rounded-xl bg-red-100 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('contacto.enviar') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nombre" class="block mb-1 text-sm font-semibold">Nombre completo *</label>
                        <input type="text" name="name" id="nombre" value="{{ old('name') }}" required class="input-rana" placeholder="Tu nombre">
                    </div>
                    <div>
                        <label for="email" class="block mb-1 text-sm font-semibold">Correo *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="input-rana" placeholder="correo@dominio.com">
                    </div>
                </div>
                <div>
                    <label for="telefono" class="block mb-1 text-sm font-semibold">Teléfono *</label>
                    <input type="tel" name="phone" id="telefono" value="{{ old('phone') }}" required class="input-rana" placeholder="976 790 973">
                </div>
                <div>
                    <label for="asunto" class="block mb-1 text-sm font-semibold">Asunto *</label>
                    <select name="select" id="asunto" required class="input-rana">
                        <option value="">Selecciona un asunto</option>
                        <option value="Información general" @selected(old('select') == 'Información general')>Información general</option>
                        <option value="Cotización" @selected(old('select') == 'Cotización')>Cotización</option>
                        <option value="Soporte técnico" @selected(old('select') == 'Soporte técnico')>Seguimiento / soporte</option>
                        <option value="Otro" @selected(old('select') == 'Otro')>Otro</option>
                    </select>
                </div>
                <div>
                    <label for="mensaje" class="block mb-1 text-sm font-semibold">Mensaje *</label>
                    <textarea name="message" id="mensaje" rows="4" required class="input-rana" placeholder="Cuéntanos qué necesitas">{{ old('message') }}</textarea>
                </div>
                <label class="flex items-start gap-2 text-sm">
                    <input id="politicas" name="politicas" type="checkbox" required class="mt-1 accent-[#2F6B32]">
                    <span>Acepto la <a href="{{ route('politicas-privacidad') }}" class="text-rana-mid underline">política de privacidad</a> *</span>
                </label>
                <button type="submit" class="btn-rana-dark w-full">Enviar mensaje</button>
            </form>
        </div>

        <div class="space-y-5">
            <div class="bg-white rounded-3xl p-6 border border-gray-100">
                <h3 class="font-bold">Teléfono</h3>
                <p class="mt-1 text-gray-600"><a href="tel:+51976790973" class="hover:text-rana-mid">976 790 973</a> / <a href="tel:+51963508032" class="hover:text-rana-mid">963 508 032</a></p>
            </div>
            <div class="bg-white rounded-3xl p-6 border border-gray-100">
                <h3 class="font-bold">Correo</h3>
                <p class="mt-1 text-gray-600"><a href="mailto:contacto@ranaexpress.pe" class="hover:text-rana-mid">contacto@ranaexpress.pe</a></p>
            </div>
            <div class="bg-white rounded-3xl p-6 border border-gray-100">
                <h3 class="font-bold">Ubicación</h3>
                <p class="mt-1 text-gray-600">Perú — consulta tu agencia más cercana.</p>
                <a href="{{ url('/agencias') }}" class="inline-block mt-3 text-sm font-bold text-rana-mid">Ver agencias</a>
            </div>
            <img src="{{ asset('img/web/generic/mapa.jpg') }}" alt="Ruta de envíos" class="rounded-3xl w-full h-56 object-cover">
        </div>
    </section>
</x-web-layout>
