<div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
    <div class="text-center max-w-2xl mx-auto mb-12">
        <p class="text-rana-mid font-bold tracking-widest text-sm">SERVICIOS</p>
        <h1 class="text-3xl sm:text-4xl font-extrabold mt-2">Cargas y encomiendas a tu medida</h1>
        <p class="mt-3 text-gray-600">Elige el tipo de movimiento. Todos se registran y se pueden rastrear con un código.</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @php
            $items = [
                ['href' => '/servicios/courier', 'title' => 'Courier', 'text' => 'Paquetes y documentos.'],
                ['href' => '/servicios/recojo', 'title' => 'Recojo', 'text' => 'Salida desde tu dirección.'],
                ['href' => '/servicios/carga-consolidada', 'title' => 'Carga', 'text' => 'Bultos y mercadería.'],
                ['href' => '/servicios/door-to-door', 'title' => 'Puerta a puerta', 'text' => 'Origen y destino a domicilio.'],
                ['href' => '/servicios/almacen', 'title' => 'Almacén', 'text' => 'Custodia transitoria.'],
                ['href' => '/servicios/mudanza', 'title' => 'Mudanza', 'text' => 'Menaje y oficina.'],
                ['href' => '/servicios/traslados-vehiculos', 'title' => 'Vehículos', 'text' => 'Traslado de unidades.'],
                ['href' => '/servicios/traslados-contenedores', 'title' => 'Contenedores', 'text' => 'Carga unitizada.'],
            ];
        @endphp
        @foreach ($items as $item)
            <a href="{{ url($item['href']) }}" class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-md hover:border-rana-lime transition">
                <h2 class="font-bold text-lg">{{ $item['title'] }}</h2>
                <p class="mt-2 text-sm text-gray-600">{{ $item['text'] }}</p>
            </a>
        @endforeach
    </div>
</div>
