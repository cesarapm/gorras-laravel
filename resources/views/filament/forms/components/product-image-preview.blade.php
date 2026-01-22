<div>
    @if($getRecord()->image)
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <img src="{{ Storage::disk('public')->url($getRecord()->image) }}"
                 alt="Imagen actual"
                 class="max-w-full h-auto rounded-lg"
                 style="max-height: 200px; object-fit: contain;">
            <p class="text-sm text-gray-500 mt-2">Imagen actual</p>
        </div>
    @else
        <p class="text-sm text-gray-500">Sin imagen</p>
    @endif
</div>
