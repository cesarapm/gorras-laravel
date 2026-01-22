@php
$preguntas = config('preguntas_comerciales.' . $puesto, []);
@endphp

<div class="space-y-4">
    @foreach($preguntas as $pregunta)
        <div class="border p-4 rounded">
            <h3 class="font-bold">{{ $pregunta['pregunta'] }}</h3>

            @if($pregunta['tipo'] === 'opciones')
                <select class="mt-2 w-full">
                    @foreach($pregunta['opciones'] as $opcion)
                        <option value="{{ $opcion }}">{{ $opcion }}</option>
                    @endforeach
                </select>
            @else
                <input type="text" class="mt-2 w-full" placeholder="Tu respuesta...">
            @endif
        </div>
    @endforeach
</div>
