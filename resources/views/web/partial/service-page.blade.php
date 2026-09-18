@php
    $title = $title ?? 'Servicio';
    $lead = $lead ?? '';
    $image = $image ?? 'img/web/generic/cajas.jpg';
    $bullets = $bullets ?? [];
    $cta = $cta ?? '/contacto';
    $ctaLabel = $ctaLabel ?? 'Solicitar información';
@endphp

<section class="relative overflow-hidden bg-rana-dark text-white">
    <img src="{{ asset($image) }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-30">
    <div class="absolute inset-0 bg-rana-dark/70"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 py-16 lg:py-20">
        <p class="text-rana-lime font-bold tracking-[0.18em] text-xs mb-3">SERVICIO</p>
        <h1 class="text-4xl font-extrabold">{{ $title }}</h1>
        <p class="mt-4 max-w-2xl text-white/80 text-lg">{{ $lead }}</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 py-14">
    <div class="grid md:grid-cols-3 gap-6">
        @foreach ($bullets as $bullet)
            <article class="bg-white rounded-3xl p-7 border border-gray-100 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-rana-lime/20 text-rana-mid flex items-center justify-center mb-4 font-bold">
                    {{ $loop->iteration }}
                </div>
                <h2 class="text-lg font-bold">{{ $bullet['title'] }}</h2>
                <p class="mt-2 text-gray-600">{{ $bullet['text'] }}</p>
            </article>
        @endforeach
    </div>
    <div class="mt-10 flex flex-wrap gap-3">
        <a href="{{ url($cta) }}" class="btn-rana-dark">{{ $ctaLabel }}</a>
        <a href="{{ url('/cotiza') }}" class="btn-rana">Cotizar envío</a>
    </div>
</section>
