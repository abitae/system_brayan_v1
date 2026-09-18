<x-web-layout>
    @include('web.partial.service-page', [
        'title' => 'Puerta a puerta',
        'lead' => 'Recojo en origen y entrega en destino, sin que tengas que pasar por agencia si el tramo lo permite.',
        'image' => 'img/web/generic/mapa.jpg',
        'bullets' => [
            ['title' => 'Un solo servicio', 'text' => 'Coordinamos ambos extremos: salida y llegada.'],
            ['title' => 'Datos completos', 'text' => 'Necesitamos direcciones, contactos y horarios de ambas partes.'],
            ['title' => 'Seguimiento', 'text' => 'El estado se consulta igual que cualquier encomienda registrada.'],
        ],
    ])
</x-web-layout>
