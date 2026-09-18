<x-web-layout>
    @include('web.partial.page-hero', [
        'title' => 'Términos y condiciones',
        'subtitle' => 'Condiciones del servicio de cargas y encomiendas de LA RANA EXPRESS E.I.R.L.',
    ])

    <section class="max-w-5xl mx-auto px-4 sm:px-6 py-14 grid gap-6 md:grid-cols-2">
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <h2 class="text-lg font-bold text-rana-mid mb-3">1. Servicio de envíos</h2>
            <p class="text-gray-600">Transportamos mercadería a nivel nacional con guía de remisión y/o comprobante de pago. El medio de transporte se elige según la ruta y el tipo de carga.</p>
        </article>
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <h2 class="text-lg font-bold text-rana-mid mb-3">2. Responsabilidades del cliente</h2>
            <ul class="text-gray-600 space-y-2 list-disc pl-5">
                <li>Entregar datos correctos para la guía y el destinatario.</li>
                <li>Embalar de forma adecuada la mercadería.</li>
                <li>No incluir artículos prohibidos.</li>
            </ul>
        </article>
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <h2 class="text-lg font-bold text-rana-mid mb-3">3. Plazos y seguimiento</h2>
            <p class="text-gray-600">Los tiempos dependen de la ruta y de la hora de ingreso. El estado se consulta con el código de tracking y el documento de identidad.</p>
        </article>
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <h2 class="text-lg font-bold text-rana-mid mb-3">4. Entrega</h2>
            <p class="text-gray-600">La encomienda se entrega a quien acredite ser el destinatario o un tercero autorizado, con documento de identidad.</p>
        </article>
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <h2 class="text-lg font-bold text-rana-mid mb-3">5. Reclamos</h2>
            <p class="text-gray-600">Cualquier disconformidad se registra en el libro de reclamaciones. Conserva tu ticket o guía para el seguimiento del caso.</p>
        </article>
        <article class="bg-white rounded-3xl p-6 border border-gray-100">
            <h2 class="text-lg font-bold text-rana-mid mb-3">6. Datos personales</h2>
            <p class="text-gray-600">Usamos los datos del envío solo para operar, facturar y contactarte. Esta página también sirve como política de privacidad del sitio público.</p>
        </article>
    </section>
</x-web-layout>
