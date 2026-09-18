<x-web-layout>
    @include('web.partial.service-page', [
        'title' => 'Traslado de vehículos',
        'lead' => 'Movemos automóviles y unidades livianas entre ciudades, con inspección de estado al recojo y a la entrega.',
        'image' => 'img/web/generic/camion.jpg',
        'bullets' => [
            ['title' => 'Inspección', 'text' => 'Se registra el estado visible de la unidad al iniciar el servicio.'],
            ['title' => 'Documentación', 'text' => 'Requerimos papeles del vehículo y de quien autoriza el traslado.'],
            ['title' => 'Entrega en destino', 'text' => 'La unidad se libera a la persona acreditada en el punto acordado.'],
        ],
    ])
</x-web-layout>
