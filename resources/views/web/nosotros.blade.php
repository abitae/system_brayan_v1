<x-web-layout>
    @include('web.partial.page-hero', [
        'title' => 'Nosotros',
        'subtitle' => 'Operamos cargas y encomiendas con procesos simples, seguimiento claro y atención directa.',
        'image' => 'img/web/generic/camion.jpg',
    ])

    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-14 grid lg:grid-cols-2 gap-10 items-center">
        <div>
            <p class="text-rana-mid font-bold tracking-widest text-sm">LA RANA EXPRESS</p>
            <h2 class="text-3xl font-extrabold mt-2">Logística de envíos, sin ruido</h2>
            <p class="mt-4 text-gray-600 leading-relaxed">
                Somos una empresa de transporte de mercadería y encomiendas. Recibimos, movemos y entregamos paquetes con registro, guía y un código de tracking para que remitente y destinatario sepan en qué etapa está el envío.
            </p>
            <p class="mt-3 text-gray-600 leading-relaxed">
                Trabajamos con agencia de origen, traslado y agencia de destino. También coordinamos recojo o entrega a domicilio cuando el servicio lo permite.
            </p>
        </div>
        <img src="{{ asset('img/web/generic/almacen.jpg') }}" alt="Operación de carga" class="rounded-3xl w-full h-80 object-cover">
    </section>

    <section class="bg-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <h2 class="text-3xl font-extrabold text-center mb-10">Cómo trabajamos</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <article class="rounded-3xl border border-gray-100 p-7">
                    <h3 class="font-bold text-lg">Claridad</h3>
                    <p class="mt-2 text-gray-600">Cada envío queda registrado. El estado se consulta con el código y el documento.</p>
                </article>
                <article class="rounded-3xl border border-gray-100 p-7">
                    <h3 class="font-bold text-lg">Cuidado de la carga</h3>
                    <p class="mt-2 text-gray-600">Pedimos un embalaje adecuado y rechazamos artículos prohibidos para proteger la ruta.</p>
                </article>
                <article class="rounded-3xl border border-gray-100 p-7">
                    <h3 class="font-bold text-lg">Atención directa</h3>
                    <p class="mt-2 text-gray-600">Teléfono, correo y agencia: un canal cercano para cotizar, rastrear o reclamar.</p>
                </article>
            </div>
        </div>
    </section>
</x-web-layout>
