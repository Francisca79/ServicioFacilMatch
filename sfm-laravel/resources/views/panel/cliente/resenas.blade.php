@extends('layouts.panel')

@section('title', 'Reseñas — Cliente')

@section('content')
<div class="grid lg:grid-cols-3 gap-8">
    @if ($servicios->count())
        <div class="lg:col-span-3 bg-white border rounded-xl p-6 shadow-sm mb-2">
            <h2 class="text-xl font-bold mb-2">Estado de servicios</h2>
            <p class="text-sm text-gray-500 mb-4">Solo el profesional confirma el cobro en efectivo. Cuando lo haga, podrás publicar tu reseña.</p>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach ($servicios as $s)
                    <div class="border rounded-lg p-4">
                        <p class="font-semibold">{{ $s->profesional->nombre ?? 'Profesional' }}</p>
                        <p class="text-sm text-gray-500">{{ $s->profesional->categoria->nombre_categoria ?? '' }}</p>
                        @if ($s->estaPagada())
                            <p class="text-green-600 text-sm mt-2 font-medium">✓ Cobro confirmado por el profesional — ${{ number_format($s->monto_pagado, 0) }}</p>
                        @else
                            <p class="text-amber-600 text-sm mt-2">Esperando confirmación de cobro del profesional.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="bg-white border rounded-xl p-6 shadow-sm lg:col-span-1">
        <h2 class="text-xl font-bold mb-4">Publicar reseña</h2>
        <p class="text-sm text-gray-600 mb-4">Disponible cuando el profesional confirme el cobro o si ya tienes historial pagado con él.</p>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-700 rounded text-sm">{{ $errors->first() }}</div>
        @endif

        <form action="/panel/cliente/resenas" method="POST" class="space-y-4">
            @csrf
            <select name="profesional_id" required class="w-full border rounded-lg px-4 py-2">
                <option value="">Profesional...</option>
                @foreach ($profesionales as $p)
                    @if (in_array($p->id, $verificados))
                        <option value="{{ $p->id }}">{{ $p->nombre }} — {{ $p->nombre_categoria }}</option>
                    @endif
                @endforeach
            </select>
            @if (empty($verificados))
                <p class="text-amber-700 text-sm bg-amber-50 p-3 rounded">Aún no puedes reseñar. El profesional debe confirmar el cobro después de aceptar tu solicitud.</p>
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

    <div class="lg:col-span-2">
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
