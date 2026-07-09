<div class="container px-4 py-12 mx-auto">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Tutoriales</h1>
        <p class="text-lg text-gray-600">Aprende a usar nuestros servicios con estos videos guía</p>
    </div>

    {{-- Grid de Videos --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($videos as $video)
            <div class="group relative bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="relative aspect-video cursor-pointer" wire:click="seleccionarVideo('{{ $video['id'] }}')">
                    <img src="{{ $video['thumbnail'] }}" alt="{{ $video['title'] }}"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-play-circle text-white text-5xl opacity-90 group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $video['title'] }}</h3>
                    <p class="text-gray-600 text-sm">{{ $video['description'] }}</p>
                    <div class="flex items-center mt-3 text-sm text-gray-500">
                        <i class="far fa-clock mr-2"></i>
                        <span>{{ $video['duration'] }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modal de Video --}}
    @if($videoSeleccionado)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75"
             wire:click.self="cerrarVideo">
            <div class="relative w-full max-w-4xl bg-black rounded-xl overflow-hidden">
                <button wire:click="cerrarVideo"
                        class="absolute top-4 right-4 text-white hover:text-gray-300 z-10 p-2 bg-black bg-opacity-50 rounded-full">
                    <i class="fas fa-times text-xl"></i>
                </button>

                <div class="aspect-video">
                    <video class="w-full h-full" controls autoplay
                           wire:ignore
                           x-data
                           x-init="$el.play()"
                           @keydown.escape.window="$wire.cerrarVideo()">
                        <source src="{{ $videoSeleccionado['videoUrl'] }}" type="video/mp4">
                        Tu navegador no soporta el elemento de video.
                    </video>
                </div>
            </div>
        </div>
    @endif
</div>
