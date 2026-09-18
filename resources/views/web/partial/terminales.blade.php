<x-web-layout>
    @include('web.partial.page-hero', [
        'title' => 'Agencias',
        'subtitle' => 'Punto de atención para envíos, recojo y consultas.',
        'image' => 'img/web/generic/mapa.jpg',
    ])

    <section class="max-w-4xl mx-auto px-4 sm:px-6 py-14">
        <article class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
            <p class="text-rana-mid font-bold tracking-widest text-xs">AGENCIA REX</p>
            <h2 class="text-2xl font-extrabold mt-2">LA RANA EXPRESS</h2>
            <p class="mt-4 text-gray-600">Atención de cargas y encomiendas. Lleva tu paquete, cotiza un envío o recógelo con tu documento de identidad.</p>
            <ul class="mt-6 space-y-2 text-gray-700">
                <li>Perú</li>
                <li>Teléfonos: 976 790 973 / 963 508 032</li>
                <li>Correo: contacto@ranaexpress.pe</li>
                <li>Horario referencial: lunes a sábado, 9:00 a 18:00</li>
            </ul>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ url('/contacto') }}" class="btn-rana-dark">Escribirnos</a>
                <a href="{{ url('/rastrea') }}" class="btn-rana">Rastrear</a>
            </div>
        </article>
    </section>
</x-web-layout>
