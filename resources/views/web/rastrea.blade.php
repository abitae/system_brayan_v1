<x-web-layout>
    @include('web.partial.page-hero', [
        'title' => 'Rastrea tu envío',
        'subtitle' => 'Consulta el estado con el código de tracking y el DNI o RUC del remitente o destinatario.',
        'image' => 'img/web/generic/mapa.jpg',
    ])

    <section class="max-w-5xl mx-auto px-4 sm:px-6 py-14">
        <div class="grid md:grid-cols-2 gap-8 items-start">
            <form action="{{ route('tracking.search') }}" method="POST" class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
                @csrf
                <h2 class="text-2xl font-bold mb-6">Rastrear encomienda</h2>
                @if ($errors->any())
                    <div class="p-4 mb-4 text-sm rounded-xl bg-red-100 text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <label for="tracking" class="block mb-1 text-sm font-semibold">Código de tracking</label>
                <input type="text" id="tracking" name="tracking" value="{{ old('tracking') }}" required class="input-rana mb-4" placeholder="Ingrese su código de tracking">
                <label for="code" class="block mb-1 text-sm font-semibold">DNI o RUC</label>
                <input type="text" id="code" name="code" value="{{ old('code') }}" required class="input-rana mb-6" placeholder="Número de documento">
                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="btn-rana-dark">Rastrear</button>
                    <a href="{{ route('rastrea') }}" class="btn-rana">Nueva búsqueda</a>
                </div>
            </form>

            <div>
                @if (isset($encomienda))
                    @php
                        $estado = $encomienda->estado_encomienda;
                        $estadoImagen = match ($estado) {
                            'REGISTRADO' => 'img/web/generic/cajas.jpg',
                            'ENVIADO' => 'img/web/generic/camion.jpg',
                            'RECIBIDO' => 'img/web/generic/almacen.jpg',
                            'ENTREGADO' => 'img/web/generic/atencion.jpg',
                            default => 'img/web/generic/mapa.jpg',
                        };
                    @endphp
                    <article class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm">
                        <img src="{{ asset($estadoImagen) }}" alt="Estado del envío" class="w-full h-40 object-cover">
                        <div class="p-6">
                            <p class="text-xs font-bold tracking-widest text-rana-mid">ENCOMIENDA</p>
                            <h3 class="text-2xl font-extrabold mt-1">{{ $encomienda->code }}</h3>
                            <p class="mt-3 inline-flex px-3 py-1 rounded-full bg-rana-lime/20 text-rana-dark text-sm font-bold">{{ $estado }}</p>
                            @if ($encomienda->sucursal_remitente)
                                <p class="mt-4 text-sm text-gray-600">Origen: {{ $encomienda->sucursal_remitente->name }}</p>
                            @endif
                            @if ($encomienda->sucursal_destinatario)
                                <p class="text-sm text-gray-600">Destino: {{ $encomienda->sucursal_destinatario->name }}</p>
                            @endif
                        </div>
                    </article>
                @else
                    <div class="rounded-3xl overflow-hidden">
                        <img src="{{ asset('img/web/generic/cajas.jpg') }}" alt="Paquetes" class="w-full h-64 object-cover">
                        <p class="mt-4 text-sm text-gray-500">Si no aparece resultado, verifica el código y el documento.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-web-layout>
