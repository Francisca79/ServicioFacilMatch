@extends('layouts.panel')

@section('title', 'Directorio — Profesional')

@section('content')
<div class="space-y-6">
    <h1 class="text-3xl font-bold">Directorio de profesionales</h1>
    <p class="text-gray-600">Solo lectura. Para contratar o reseñar necesitas una cuenta de cliente.</p>
    <form method="GET" class="flex gap-3">
        <select name="categoria" class="border rounded-lg px-4 py-2">
            <option value="">Todas</option>
            @foreach ($categorias as $cat)
                <option value="{{ $cat }}" @selected(request('categoria') === $cat)>{{ $cat }}</option>
            @endforeach
        </select>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Filtrar</button>
    </form>
    <div class="grid md:grid-cols-3 gap-4">
        @foreach ($profesionales as $p)
            <a href="/profesionales/{{ $p->id }}" class="block bg-white border rounded-xl p-5 hover:shadow-md">
                <h3 class="font-bold">{{ $p->nombre }}</h3>
                <p class="text-sm text-gray-600">{{ $p->nombre_categoria }}</p>
                <p class="text-yellow-500 text-sm">⭐ {{ number_format($p->calificacion, 1) }}</p>
                <p class="text-blue-600 font-semibold mt-2">{{ $p->rango_precio }}</p>
            </a>
        @endforeach
    </div>
</div>
@endsection
