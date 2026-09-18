<x-web-layout>
    @include('web.partial.page-hero', [
        'title' => 'Servicios',
        'subtitle' => 'Courier, carga, recojo, almacén y traslados. Un mismo estándar de registro y seguimiento.',
        'image' => 'img/web/generic/hero.jpg',
    ])
    @include('web.partial.servicios')
</x-web-layout>
