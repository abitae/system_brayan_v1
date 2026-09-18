<section class="relative overflow-hidden bg-rana-dark text-white">
    @if (!empty($image))
        <img src="{{ asset($image) }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-25">
        <div class="absolute inset-0 bg-rana-dark/75"></div>
    @endif
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 py-14 lg:py-16">
        <h1 class="text-3xl sm:text-4xl font-extrabold">{{ $title }}</h1>
        @if (!empty($subtitle))
            <p class="mt-3 max-w-2xl text-white/80">{{ $subtitle }}</p>
        @endif
    </div>
</section>
