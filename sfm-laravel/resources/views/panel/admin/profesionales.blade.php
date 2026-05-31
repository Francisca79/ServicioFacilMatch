@extends('layouts.panel')

@section('title', 'Profesionales — Admin')

@section('content')
<div class="space-y-6">
    <h1 class="text-3xl font-bold">Profesionales registrados</h1>

    <form method="GET" class="flex gap-3">
        <select name="categoria" class="border rounded-lg px-4 py-2">
            <option value="">Todas</option>
            @foreach ($categorias as $c)
                <option value="{{ $c->nombre_categoria }}" @selected(request('categoria') === $c->nombre_categoria)>{{ $c->nombre_categoria }}</option>
            @endforeach
        </select>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Filtrar</button>
    </form>

    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach ($profesionales as $p)
            <a href="/panel/admin/profesionales/{{ $p->id }}" class="block bg-white border rounded-xl p-5 hover:shadow-md transition">
                <h3 class="font-bold text-lg">{{ $p->nombre }}</h3>
                <p class="text-sm text-gray-600">{{ $p->categoria->nombre_categoria ?? '' }}</p>
                <p class="text-yellow-500 text-sm mt-1">⭐ {{ number_format($p->calificacion, 1) }}</p>
                <p class="text-blue-600 font-semibold mt-2">{{ $p->rango_precio }}</p>
                <p class="text-xs text-gray-400 mt-2">{{ $p->user?->email ?? 'Sin cuenta vinculada' }}</p>
            </a>
        @endforeach
    </div>
</div>
@endsection
