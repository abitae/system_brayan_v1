<x-web-layout>
    @include('web.partial.page-hero', [
        'title' => 'Cotiza tu envío',
        'subtitle' => 'Cuéntanos origen, destino, peso aproximado y tipo de carga. Te respondemos con una tarifa referencial.',
        'image' => 'img/web/generic/camion.jpg',
    ])

    <section class="max-w-3xl mx-auto px-4 sm:px-6 py-14 text-center">
        <div class="bg-white rounded-3xl p-8 border border-gray-100">
            <p class="text-gray-600">Las tarifas varían según ruta, volumen y servicio (courier, carga o recojo). Un asesor te confirma el monto antes de registrar el envío.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ url('/contacto') }}" class="btn-rana-dark">Solicitar cotización</a>
                <a href="{{ url('/tarifario') }}" class="btn-rana">Ver criterios de tarifa</a>
            </div>
        </div>
    </section>
</x-web-layout>
