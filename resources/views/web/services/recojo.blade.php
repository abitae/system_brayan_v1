<x-web-layout>
    @include('web.partial.service-page', [
        'title' => 'Recojo',
        'lead' => 'Coordinamos el recojo de tu encomienda en origen para ingresarla a la red de envíos.',
        'image' => 'img/web/generic/camion.jpg',
        'bullets' => [
            ['title' => 'Agenda tu recojo', 'text' => 'Indica dirección, horario tentativo y datos del destinatario.'],
            ['title' => 'Ingreso a agencia', 'text' => 'El paquete se registra y obtiene su código de tracking.'],
            ['title' => 'Siguiente tramo', 'text' => 'Continúa como courier, carga o entrega a domicilio según lo contratado.'],
        ],
    ])
</x-web-layout>
