<x-web-layout>
    @include('web.partial.page-hero', [
        'title' => 'Libro de reclamaciones',
        'subtitle' => 'Registra tu queja o reclamo. Te responderemos según la normativa vigente.',
        'image' => 'img/web/generic/atencion.jpg',
    ])

    <section class="max-w-4xl mx-auto px-4 sm:px-6 py-14">
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 bg-rana-dark text-white">
                <h2 class="text-2xl font-bold">Registrar reclamo o queja</h2>
                <p class="mt-1 text-white/70 text-sm">Completa todos los campos. Conserva una copia de tu envío.</p>
            </div>

            <form action="{{ route('reclamaciones.enviar') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf

                @if (session('success') || isset($success))
                    <div class="p-4 text-sm rounded-xl bg-rana-lime/20 text-rana-dark">{{ session('success') ?? $success }}</div>
                @endif
                @if (session('error'))
                    <div class="p-4 text-sm rounded-xl bg-red-100 text-red-700">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="p-4 text-sm rounded-xl bg-red-100 text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="p-4 rounded-2xl bg-rana-bg">
                    <h3 class="font-bold mb-4">Datos del consumidor</h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="reclamo_nombre" class="block mb-1 text-sm font-semibold">Nombre completo *</label>
                            <input type="text" name="reclamo_nombre" id="reclamo_nombre" value="{{ old('reclamo_nombre') }}" required class="input-rana">
                        </div>
                        <div>
                            <label for="reclamo_documento" class="block mb-1 text-sm font-semibold">DNI / CE / Pasaporte *</label>
                            <input type="text" name="reclamo_documento" id="reclamo_documento" value="{{ old('reclamo_documento') }}" required class="input-rana">
                        </div>
                        <div>
                            <label for="reclamo_telefono" class="block mb-1 text-sm font-semibold">Teléfono *</label>
                            <input type="tel" name="reclamo_telefono" id="reclamo_telefono" value="{{ old('reclamo_telefono') }}" required class="input-rana">
                        </div>
                        <div>
                            <label for="reclamo_email" class="block mb-1 text-sm font-semibold">Correo *</label>
                            <input type="email" name="reclamo_email" id="reclamo_email" value="{{ old('reclamo_email') }}" required class="input-rana">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="reclamo_direccion" class="block mb-1 text-sm font-semibold">Dirección *</label>
                            <input type="text" name="reclamo_direccion" id="reclamo_direccion" value="{{ old('reclamo_direccion') }}" required class="input-rana">
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-rana-bg">
                    <h3 class="font-bold mb-4">Detalles de la reclamación</h3>
                    <div class="mb-4">
                        <p class="block mb-2 text-sm font-semibold">Tipo *</p>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 text-sm">
                                <input type="radio" name="reclamo_tipo" value="queja" required @checked(old('reclamo_tipo') == 'queja') class="accent-[#2F6B32]">
                                Queja
                            </label>
                            <label class="flex items-center gap-2 text-sm">
                                <input type="radio" name="reclamo_tipo" value="reclamo" required @checked(old('reclamo_tipo') == 'reclamo') class="accent-[#2F6B32]">
                                Reclamo
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Queja: disconformidad no ligada al servicio. Reclamo: disconformidad con el servicio o la encomienda.</p>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="reclamo_producto" class="block mb-1 text-sm font-semibold">Producto o servicio *</label>
                            <input type="text" name="reclamo_producto" id="reclamo_producto" value="{{ old('reclamo_producto') }}" required class="input-rana">
                        </div>
                        <div>
                            <label for="reclamo_monto" class="block mb-1 text-sm font-semibold">Monto reclamado (S/) *</label>
                            <input type="number" step="0.01" name="reclamo_monto" id="reclamo_monto" value="{{ old('reclamo_monto') }}" required class="input-rana">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="reclamo_descripcion" class="block mb-1 text-sm font-semibold">Descripción *</label>
                        <textarea name="reclamo_descripcion" id="reclamo_descripcion" rows="4" required class="input-rana">{{ old('reclamo_descripcion') }}</textarea>
                    </div>
                    <div class="mt-4">
                        <label for="reclamo_pedido" class="block mb-1 text-sm font-semibold">Pedido o solicitud</label>
                        <textarea name="reclamo_pedido" id="reclamo_pedido" rows="3" class="input-rana">{{ old('reclamo_pedido') }}</textarea>
                    </div>
                </div>

                <label class="flex items-start gap-2 text-sm">
                    <input id="reclamo_politicas" name="reclamo_politicas" type="checkbox" required class="mt-1 accent-[#2F6B32]">
                    <span>Acepto la <a href="{{ route('politicas-privacidad') }}" class="text-rana-mid underline">política de privacidad</a> y declaro que los datos son verídicos *</span>
                </label>
                <button type="submit" class="btn-rana-dark w-full">Registrar reclamo</button>
                <p class="text-xs text-gray-500">Plazo de atención: hasta 30 días hábiles.</p>
            </form>
        </div>
    </section>
</x-web-layout>
