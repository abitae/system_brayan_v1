<x-web-layout>
    @include('web.partial.page-hero', [
        'title' => 'Tarifario',
        'subtitle' => 'Referencia de cómo se arma el precio de un envío. La tarifa final se confirma en agencia o por contacto.',
    ])

    <section class="max-w-5xl mx-auto px-4 sm:px-6 py-14 grid md:grid-cols-3 gap-6">
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <h2 class="font-bold text-lg">Ruta</h2>
            <p class="mt-2 text-gray-600">Origen y destino definen el tramo y el tiempo estimado de tránsito.</p>
        </article>
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <h2 class="font-bold text-lg">Peso y volumen</h2>
            <p class="mt-2 text-gray-600">Se tarifa por kilo, por bulto o por el mayor entre peso real y volumétrico.</p>
        </article>
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <h2 class="font-bold text-lg">Servicio extra</h2>
            <p class="mt-2 text-gray-600">Recojo, entrega a domicilio o espera en almacén se cotizan aparte.</p>
        </article>
    </section>

    <section class="max-w-3xl mx-auto px-4 pb-14 text-center">
        <a href="{{ url('/contacto') }}" class="btn-rana-dark">Pedir tarifa</a>
    </section>
</x-web-layout>
