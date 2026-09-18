<x-web-layout>
    @include('web.partial.service-page', [
        'title' => 'Traslado de contenedores',
        'lead' => 'Tramos terrestres para contenedores y carga unitizada, coordinados con tu operación de puerto o almacén.',
        'image' => 'img/web/generic/almacen.jpg',
        'bullets' => [
            ['title' => 'Planificación', 'text' => 'Fecha, origen y destino se confirman según disponibilidad de unidad.'],
            ['title' => 'Documentos de carga', 'text' => 'Trabajamos con la guía y los papeles que correspondan al movimiento.'],
            ['title' => 'Punto a punto', 'text' => 'Desde almacén, depósito o zona de retiro hasta el destino indicado.'],
        ],
    ])
</x-web-layout>
