<x-web-layout>
    @include('web.partial.page-hero', [
        'title' => 'Cómo enviar',
        'subtitle' => 'Prepara, registra y rastrea. Así se mueve una encomienda con nosotros.',
        'image' => 'img/web/generic/cajas.jpg',
    ])

    <section class="max-w-5xl mx-auto px-4 sm:px-6 py-14 grid md:grid-cols-3 gap-6">
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <span class="text-rana-lime font-extrabold text-3xl">1</span>
            <h2 class="font-bold text-lg mt-3">Embala</h2>
            <p class="mt-2 text-gray-600">Cierra bien la caja, identifica frágil si corresponde y no incluyas artículos prohibidos.</p>
        </article>
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <span class="text-rana-lime font-extrabold text-3xl">2</span>
            <h2 class="font-bold text-lg mt-3">Registra</h2>
            <p class="mt-2 text-gray-600">En agencia o con recojo: datos de remitente, destinatario y destino. Te damos el código.</p>
        </article>
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <span class="text-rana-lime font-extrabold text-3xl">3</span>
            <h2 class="font-bold text-lg mt-3">Entrega</h2>
            <p class="mt-2 text-gray-600">El destinatario retira con su documento o recibe a domicilio si contrataste ese servicio.</p>
        </article>
    </section>

    <section class="max-w-3xl mx-auto px-4 pb-14 text-center">
        <a href="{{ url('/agencias') }}" class="btn-rana-dark">Ir a agencias</a>
        <a href="{{ url('/contacto') }}" class="btn-rana ml-2">Pedir recojo</a>
    </section>
</x-web-layout>
