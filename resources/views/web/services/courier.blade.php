<x-web-layout>
    @include('web.partial.service-page', [
        'title' => 'Courier',
        'lead' => 'Documentos y paquetes pequeños entre agencias, con registro y seguimiento.',
        'image' => 'img/web/generic/cajas.jpg',
        'bullets' => [
            ['title' => 'Rápido y simple', 'text' => 'Ideal para sobres, cajas chicas y encomiendas de bajo volumen.'],
            ['title' => 'Código de tracking', 'text' => 'Cada envío queda identificado para consultar su estado en línea.'],
            ['title' => 'Retiro con documento', 'text' => 'El destinatario recoge en agencia presentando su DNI o RUC.'],
        ],
    ])
</x-web-layout>
