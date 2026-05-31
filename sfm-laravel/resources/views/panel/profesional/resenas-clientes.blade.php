@extends('layouts.panel')

@section('title', 'Reseñas a clientes')

@section('content')
<div class="grid lg:grid-cols-2 gap-8">
    <div class="bg-white border rounded-xl p-6 shadow-sm">
        <h2 class="text-xl font-bold mb-4">Calificar un cliente</h2>
        <p class="text-sm text-gray-600 mb-4">Ayuda a otros profesionales a saber si un cliente es confiable.</p>
        <form action="/panel/profesional/resenas-clientes" method="POST" class="space-y-4">
            @csrf
            <select name="cliente_id" required class="w-full border rounded-lg px-4 py-2">
                <option value="">Cliente...</option>
                @foreach ($clientes as $c)
                    <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->email }})</option>
                @endforeach
            </select>
            <select name="calificacion" class="w-full border rounded-lg px-4 py-2">
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}">{{ $i }} estrella(s)</option>
                @endfor
            </select>
            <textarea name="comentario" rows="4" required class="w-full border rounded-lg px-4 py-2" placeholder="¿Fue puntual? ¿Pagó a tiempo?"></textarea>
            <button class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold">Publicar</button>
        </form>
    </div>
    <div>
        <h2 class="text-xl font-bold mb-4">Mis reseñas a clientes</h2>
        @forelse ($misResenas as $r)
            <div class="bg-white border rounded-xl p-5 mb-4">
                <p class="font-bold">{{ $r->cliente->name }}</p>
                <p class="text-yellow-500 text-sm">{{ str_repeat('⭐', $r->calificacion) }}</p>
                <p class="text-gray-600 text-sm">{{ $r->comentario }}</p>
            </div>
        @empty
            <p class="text-gray-500">No has calificado clientes aún.</p>
        @endforelse
    </div>
</div>
@endsection
