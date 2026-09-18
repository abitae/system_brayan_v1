<x-web-layout>
    @include('web.partial.page-hero', [
        'title' => 'Comunícate',
        'subtitle' => 'El mismo canal de contacto: teléfono, correo o formulario.',
        'image' => 'img/web/generic/atencion.jpg',
    ])

    <section class="max-w-3xl mx-auto px-4 sm:px-6 py-14">
        <div class="bg-white rounded-3xl p-8 border border-gray-100 text-center">
            <p class="text-gray-600">Escríbenos a <a class="font-semibold text-rana-mid" href="mailto:contacto@ranaexpress.pe">contacto@ranaexpress.pe</a> o llama al 976 790 973 / 963 508 032.</p>
            <a href="{{ url('/contacto') }}" class="btn-rana-dark mt-6">Ir al formulario</a>
        </div>
    </section>
</x-web-layout>
