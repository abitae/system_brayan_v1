@props([
    'size' => 'md',
    'showText' => true,
    'showSucursal' => false,
    'textClass' => '',
])

@php
    $sizes = [
        'sm' => ['box' => 'h-8 w-8', 'img' => 'h-5 w-5', 'title' => 'text-sm', 'subtitle' => 'text-[10px]'],
        'md' => ['box' => 'h-10 w-10', 'img' => 'h-7 w-7', 'title' => 'text-sm', 'subtitle' => 'text-[11px]'],
    ];
    $s = $sizes[$size] ?? $sizes['md'];
    $appName = config('app.name', 'Infinity Cargo');
@endphp

<a href="{{ route('dashboard') }}" {{ $attributes->merge(['class' => 'flex items-center gap-3 group']) }}>
    <div
        class="flex {{ $s['box'] }} shrink-0 items-center justify-center rounded-xl bg-primary/10 ring-1 ring-primary/20 transition-transform group-hover:scale-105">
        <img src="{{ asset('img/logo01.png') }}" alt="{{ $appName }}" class="{{ $s['img'] }} w-auto object-contain" />
    </div>

    @if ($showText)
        <div @class(['min-w-0 leading-tight', $textClass])>
            <p @class(['font-bold truncate text-base-content', $s['title']])>{{ $appName }}</p>
            @if ($showSucursal)
                <p @class(['text-base-content/50 truncate', $s['subtitle']])>
                    {{ auth()->user()->sucursal?->code ?? 'Sistema' }}
                </p>
            @else
                <p @class(['text-base-content/50', $s['subtitle']])>Panel operativo</p>
            @endif
        </div>
    @endif
</a>
