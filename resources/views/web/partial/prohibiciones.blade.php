<x-web-layout>
    @include('web.partial.page-hero', [
        'title' => 'Artículos prohibidos',
        'subtitle' => 'No aceptamos envíos que pongan en riesgo a las personas, la carga o la operación.',
    ])

    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-14 grid md:grid-cols-3 gap-6">
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <h2 class="text-lg font-bold mb-3">Materiales peligrosos</h2>
            <ul class="text-gray-600 space-y-2">
                <li>Explosivos e inflamables</li>
                <li>Sustancias tóxicas o corrosivas</li>
                <li>Gases comprimidos</li>
            </ul>
        </article>
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <h2 class="text-lg font-bold mb-3">Artículos ilegales</h2>
            <ul class="text-gray-600 space-y-2">
                <li>Drogas y estupefacientes</li>
                <li>Armas y municiones</li>
                <li>Mercancía de contrabando</li>
            </ul>
        </article>
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <h2 class="text-lg font-bold mb-3">Restricciones</h2>
            <ul class="text-gray-600 space-y-2">
                <li>Dinero en efectivo</li>
                <li>Valores negociables al portador</li>
                <li>Perecederos sin embalaje apto</li>
            </ul>
        </article>
    </section>

    <section class="max-w-3xl mx-auto px-4 pb-14 text-center">
        <p class="text-gray-600">Si tienes dudas sobre un artículo, consúltanos antes de llevarlo a agencia.</p>
        <a href="{{ url('/contacto') }}" class="btn-rana-dark mt-6">Consultar</a>
    </section>
</x-web-layout>
