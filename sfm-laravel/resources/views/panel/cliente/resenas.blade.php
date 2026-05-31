@extends('layouts.panel')

@section('title', 'Reseñas — Cliente')

@section('content')
<div class="grid lg:grid-cols-2 gap-8">
    <div class="bg-white border rounded-xl p-6 shadow-sm">
        <h2 class="text-xl font-bold mb-4">Publicar reseña</h2>
        <p class="text-sm text-gray-600 mb-4">Solo puedes reseñar profesionales cuyo servicio fue verificado por el administrador.</p>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-700 rounded text-sm">{{ $errors->first() }}</div>
        @endif

        <form action="/panel/cliente/resenas" method="POST" class="space-y-4">
            @csrf
            <select name="profesional_id" required class="w-full border rounded-lg px-4 py-2">
                <option value="">Profesional verificado...</option>
                @foreach ($profesionales as $p)
                    @if (in_array($p->id, $verificados))
                        <option value="{{ $p->id }}">{{ $p->nombre }} — {{ $p->nombre_categoria }}</option>
                    @endif
                @endforeach
            </select>
            @if (empty($verificados))
                <p class="text-amber-700 text-sm bg-amber-50 p-3 rounded">Aún no tienes servicios verificados. El admin debe confirmar que adquiriste el servicio.</p>
            @endif
            <select name="calificacion" class="w-full border rounded-lg px-4 py-2">
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}">{{ $i }} estrella(s)</option>
                @endfor
            </select>
            <textarea name="comentario" rows="4" required class="w-full border rounded-lg px-4 py-2" placeholder="Tu experiencia..."></textarea>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold" @if(empty($verificados)) disabled @endif>Publicar</button>
        </form>
    </div>

    <div>
        <h2 class="text-xl font-bold mb-4">Mis reseñas</h2>
        @forelse ($misResenas as $r)
            <div class="bg-white border rounded-xl p-5 mb-4 shadow-sm">
                <p class="font-bold">{{ $r->profesional->nombre }}</p>
                <p class="text-yellow-500 text-sm">{{ str_repeat('⭐', $r->calificacion) }}</p>
                <p class="text-gray-600 text-sm mt-1">{{ $r->comentario }}</p>
                <form action="/panel/cliente/resenas/{{ $r->id }}" method="POST" class="mt-2">
                    @csrf @method('DELETE')
                    <button class="text-red-600 text-xs hover:underline">Eliminar mi reseña</button>
                </form>
            </div>
        @empty
            <p class="text-gray-500">No has publicado reseñas.</p>
        @endforelse
    </div>
</div>
@endsection
