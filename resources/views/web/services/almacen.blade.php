<x-web-layout>
    @include('web.partial.service-page', [
        'title' => 'Almacén',
        'lead' => 'Espacio transitorio para carga en espera de despacho, consolidación o recojo del destinatario.',
        'image' => 'img/web/generic/almacen.jpg',
        'bullets' => [
            ['title' => 'Corto plazo', 'text' => 'Custodia mientras se arma el viaje o se coordina la entrega.'],
            ['title' => 'Identificación', 'text' => 'La mercadería permanece asociada a su código y destinatario.'],
            ['title' => 'Retiro controlado', 'text' => 'Solo se entrega a quien acredite el documento correspondiente.'],
        ],
    ])
</x-web-layout>
