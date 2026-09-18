<x-web-layout>
    @include('web.partial.service-page', [
        'title' => 'Carga consolidada',
        'lead' => 'Agrupamos mercadería de varios remitentes en un mismo tramo para mover volumen a mejor costo.',
        'image' => 'img/web/generic/almacen.jpg',
        'bullets' => [
            ['title' => 'Bultos y mercadería', 'text' => 'Pensado para cajas, fardos y carga que no viaja como paquete chico.'],
            ['title' => 'Guía y control', 'text' => 'El envío se documenta y se mueve con el resto de la ruta programada.'],
            ['title' => 'Entrega en destino', 'text' => 'Retiro en agencia o coordinación de última milla, según el servicio.'],
        ],
    ])
</x-web-layout>
