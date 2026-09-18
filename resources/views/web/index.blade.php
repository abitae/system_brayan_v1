<x-web-layout>
    <section class="relative overflow-hidden bg-rana-dark text-white">
        <img src="{{ asset('img/web/generic/hero.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-35">
        <div class="absolute inset-0 bg-gradient-to-r from-rana-dark via-rana-dark/85 to-rana-dark/50"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <img src="{{ asset('img/logo.png') }}?v=rana" alt="LA RANA EXPRESS" class="h-16 mb-6 bg-white rounded-2xl p-2">
                <p class="text-rana-lime font-bold tracking-[0.2em] text-sm mb-3">CARGAS Y ENCOMIENDAS</p>
                <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight">Envíos simples, seguros y rastreables</h1>
                <p class="mt-5 text-lg text-white/80 max-w-xl">
                    Recogemos, transportamos y entregamos paquetes y carga en todo el Perú. Sin complicaciones: un código, un destino, un seguimiento claro.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ url('/rastrea') }}" class="btn-rana">Rastrea tu envío</a>
                    <a href="{{ url('/contacto') }}" class="btn-rana-outline">Contáctanos</a>
                </div>
            </div>
            <form action="{{ route('tracking.search') }}" method="POST" class="bg-white text-rana-dark rounded-3xl p-6 sm:p-8 shadow-2xl">
                @csrf
                <h2 class="text-xl font-bold mb-1">Rastreo rápido</h2>
                <p class="text-sm text-gray-500 mb-6">Ingresa el código de tu encomienda y el DNI o RUC.</p>
                <label class="block text-sm font-semibold mb-1" for="home-tracking">Código de tracking</label>
                <input id="home-tracking" name="tracking" type="text" required class="input-rana mb-4" placeholder="Ej. ENC-000123">
                <label class="block text-sm font-semibold mb-1" for="home-code">DNI o RUC</label>
                <input id="home-code" name="code" type="text" required class="input-rana mb-6" placeholder="Número de documento">
                <button type="submit" class="btn-rana w-full">Consultar estado</button>
            </form>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-16">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-rana-mid font-bold tracking-widest text-sm">SERVICIOS</p>
            <h2 class="text-3xl font-extrabold mt-2">Lo que movemos por ti</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <a href="{{ url('/servicios/courier') }}" class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-lg transition border border-gray-100">
                <div class="w-12 h-12 rounded-2xl bg-rana-lime/20 text-rana-mid flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-3l-2-2H9L7 5H4a2 2 0 00-2 2v6m18 0l-2 7H6l-2-7m16 0H4"/></svg>
                </div>
                <h3 class="text-xl font-bold">Courier</h3>
                <p class="mt-2 text-gray-600">Documentos y paquetes pequeños con seguimiento y entrega ágil entre agencias.</p>
            </a>
            <a href="{{ url('/servicios/carga-consolidada') }}" class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-lg transition border border-gray-100">
                <div class="w-12 h-12 rounded-2xl bg-rana-lime/20 text-rana-mid flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
                <h3 class="text-xl font-bold">Carga</h3>
                <p class="mt-2 text-gray-600">Mercadería consolidada y bultos de mayor volumen, con guía y control de ruta.</p>
            </a>
            <a href="{{ url('/servicios/recojo') }}" class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-lg transition border border-gray-100">
                <div class="w-12 h-12 rounded-2xl bg-rana-lime/20 text-rana-mid flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold">Recojo</h3>
                <p class="mt-2 text-gray-600">Coordinamos el recojo en origen y la entrega en agencia o en destino, según el servicio.</p>
            </a>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 grid lg:grid-cols-2 gap-10 items-center">
            <img src="{{ asset('img/web/generic/cajas.jpg') }}" alt="Paquetes listos para envío" class="rounded-3xl w-full h-80 object-cover">
            <div>
                <p class="text-rana-mid font-bold tracking-widest text-sm">CÓMO ENVÍAS</p>
                <h2 class="text-3xl font-extrabold mt-2 mb-8">Tres pasos, sin vueltas</h2>
                <ol class="space-y-6">
                    <li class="flex gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-rana-dark text-rana-lime font-bold">1</span>
                        <div>
                            <h3 class="font-bold">Prepara tu encomienda</h3>
                            <p class="text-gray-600">Embala bien el contenido y ten a la mano los datos del destinatario.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-rana-dark text-rana-lime font-bold">2</span>
                        <div>
                            <h3 class="font-bold">Llévalo a agencia o pide recojo</h3>
                            <p class="text-gray-600">Te registramos el envío y te entregamos el código de tracking.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-rana-dark text-rana-lime font-bold">3</span>
                        <div>
                            <h3 class="font-bold">Sigue y recógelo</h3>
                            <p class="text-gray-600">Consulta el estado en línea. El destinatario retira con su documento.</p>
                        </div>
                    </li>
                </ol>
                <a href="{{ url('/envia') }}" class="btn-rana-dark mt-8">Ver guía de envío</a>
            </div>
        </div>
    </section>

    @if (isset($sucursales) && $sucursales->count())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 py-16">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <p class="text-rana-mid font-bold tracking-widest text-sm">AGENCIAS</p>
                <h2 class="text-3xl font-extrabold mt-2">Dónde encontrarnos</h2>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($sucursales as $sucursal)
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-lg">{{ $sucursal->name ?? $sucursal->code }}</h3>
                        <p class="text-sm text-gray-600 mt-2">{{ $sucursal->address ?? 'Perú' }}</p>
                        @if (!empty($sucursal->phone))
                            <p class="text-sm mt-2 font-semibold text-rana-mid">{{ $sucursal->phone }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ url('/agencias') }}" class="btn-rana-dark">Ver agencias</a>
            </div>
        </section>
    @endif
</x-web-layout>
