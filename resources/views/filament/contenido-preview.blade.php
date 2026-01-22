<div class="space-y-6">
    <!-- Header del contenido -->
    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    @switch($contenido->categoria)
                        @case('ultimas_noticias')
                            bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                            @break
                        @case('enlaces_interes')
                            bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                            @break
                        @case('contenido_video')
                            bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                            @break
                        @case('articulos_destacados')
                            bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                            @break
                        @default
                            bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                    @endswitch">
                    @switch($contenido->categoria)
                        @case('ultimas_noticias')
                            📰 Últimas Noticias
                            @break
                        @case('enlaces_interes')
                            🔗 Enlaces de Interés
                            @break
                        @case('contenido_video')
                            🎥 Contenido de Video
                            @break
                        @case('articulos_destacados')
                            ⭐ Artículos Destacados
                            @break
                        @default
                            {{ $contenido->categoria }}
                    @endswitch
                </span>

                @if($contenido->subcategoria)
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                        {{ ucfirst(str_replace('_', ' ', $contenido->subcategoria)) }}
                    </span>
                @endif
            </div>

            @if($contenido->fecha)
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $contenido->fecha->format('d/m/Y') }}
                </div>
            @endif
        </div>

        @if($contenido->titulo)
            <h1 class="mt-3 text-2xl font-bold text-gray-900 dark:text-gray-100">
                {{ $contenido->titulo }}
            </h1>
        @endif

        @if($contenido->descripcion)
            <p class="mt-2 text-gray-600 dark:text-gray-300">
                {{ $contenido->descripcion }}
            </p>
        @endif
    </div>

    <!-- Imágenes -->
    @if($contenido->imagenes && count($contenido->imagenes) > 0)
        <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">📸 Imágenes</h3>

            @if(count($contenido->imagenes) == 1)
                <!-- Una sola imagen -->
                <div class="flex justify-center">
                    <img src="{{ Storage::url($contenido->imagenes[0]) }}"
                         alt="Imagen del contenido"
                         class="max-w-full h-auto rounded-lg shadow-md max-h-96 object-cover">
                </div>
            @else
                <!-- Múltiples imágenes en grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($contenido->imagenes as $imagen)
                        <img src="{{ Storage::url($imagen) }}"
                             alt="Imagen del contenido"
                             class="w-full h-32 object-cover rounded-lg shadow-md">
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <!-- Videos -->
    @if($contenido->video_url || $contenido->video_archivo)
        <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">🎥 Video</h3>

            @if($contenido->video_url)
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">URL del video:</p>
                    <a href="{{ $contenido->video_url }}"
                       target="_blank"
                       class="text-blue-600 dark:text-blue-400 hover:underline break-all">
                        {{ $contenido->video_url }}
                    </a>

                    <!-- Intentar mostrar embed de YouTube -->
                    @if(str_contains($contenido->video_url, 'youtube.com') || str_contains($contenido->video_url, 'youtu.be'))
                        @php
                            $videoId = null;
                            if (str_contains($contenido->video_url, 'youtube.com/watch?v=')) {
                                preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $contenido->video_url, $matches);
                                $videoId = $matches[1] ?? null;
                            } elseif (str_contains($contenido->video_url, 'youtu.be/')) {
                                $videoId = substr(parse_url($contenido->video_url, PHP_URL_PATH), 1);
                            }
                        @endphp

                        @if($videoId)
                            <div class="mt-3 aspect-video">
                                <iframe
                                    class="w-full h-full rounded-lg"
                                    src="https://www.youtube.com/embed/{{ $videoId }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @endif
                    @endif
                </div>
            @endif

            @if($contenido->video_archivo)
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Archivo de video:</p>
                    <video controls class="w-full max-w-2xl rounded-lg">
                        <source src="{{ Storage::url($contenido->video_archivo) }}" type="video/mp4">
                        Tu navegador no soporta el elemento de video.
                    </video>
                </div>
            @endif
        </div>
    @endif

    <!-- URLs y Enlaces -->
    @if($contenido->url)
        <div class="space-y-2">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">🔗 Enlace</h3>
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                <a href="{{ $contenido->url }}"
                   target="_blank"
                   class="text-blue-600 dark:text-blue-400 hover:underline break-all">
                    {{ $contenido->url }}
                </a>
            </div>
        </div>
    @endif

    @if($contenido->link)
        <div class="space-y-2">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">📖 Link del Artículo</h3>
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                <a href="{{ $contenido->link }}"
                   target="_blank"
                   class="text-blue-600 dark:text-blue-400 hover:underline break-all">
                    {{ $contenido->link }}
                </a>
            </div>
        </div>
    @endif

    <!-- Resumen -->
    @if($contenido->resumen)
        <div class="space-y-2">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">📝 Resumen</h3>
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $contenido->resumen }}</p>
            </div>
        </div>
    @endif

    <!-- Artículos Destacados (Repeater) -->
    @if($contenido->categoria === 'articulos_destacados' && $contenido->articulos_destacados && is_array($contenido->articulos_destacados) && count($contenido->articulos_destacados) > 0)
        <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">⭐ Artículos</h3>
            <div class="space-y-6">
                @foreach($contenido->articulos_destacados as $index => $articulo)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-900">
                        <div class="flex items-start justify-between mb-3">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $index + 1 }}. {{ $articulo['titulo'] ?? 'Sin título' }}
                            </h4>

                            @if(isset($articulo['subcategoria']))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ ucfirst(str_replace('_', ' ', $articulo['subcategoria'])) }}
                                </span>
                            @endif
                        </div>

                        @if(isset($articulo['link']) && $articulo['link'])
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">
                                    <strong>Enlace:</strong>
                                </p>
                                <a href="{{ $articulo['link'] }}"
                                   target="_blank"
                                   class="text-blue-600 dark:text-blue-400 hover:underline break-all text-sm">
                                    {{ $articulo['link'] }}
                                </a>
                            </div>
                        @endif

                        @if(isset($articulo['contenido']) && $articulo['contenido'])
                            <div class="prose dark:prose-invert max-w-none prose-sm">
                                {!! $articulo['contenido'] !!}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Información adicional -->
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
        <div class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
            <p><strong>Orden:</strong> {{ $contenido->orden }}</p>
            <p><strong>Creado:</strong> {{ $contenido->created_at->format('d/m/Y H:i') }}</p>
            @if($contenido->updated_at != $contenido->created_at)
                <p><strong>Última actualización:</strong> {{ $contenido->updated_at->format('d/m/Y H:i') }}</p>
            @endif
        </div>
    </div>
</div>
