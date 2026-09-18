<x-web-layout>
    @include('web.partial.service-page', [
        'title' => 'Mudanza',
        'lead' => 'Traslado de menaje y bienes del hogar o de oficina, con inventario previo y embalaje adecuado.',
        'image' => 'img/web/generic/camion.jpg',
        'bullets' => [
            ['title' => 'Inventario', 'text' => 'Listamos lo que viaja para evitar olvidos y reclamos posteriores.'],
            ['title' => 'Embalaje', 'text' => 'La mercadería debe ir protegida; te indicamos qué no se acepta.'],
            ['title' => 'Coordinación', 'text' => 'Fecha, acceso y destino se confirman antes de cargar.'],
        ],
    ])
</x-web-layout>
