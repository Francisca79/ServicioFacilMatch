@extends('layouts.app')

@section('title', 'Profesionales — SFM')

@section('content')
<main class="bg-gray-50 min-h-screen py-12 px-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold mb-2">Profesionales</h1>
        <p class="text-gray-600 mb-8">Explora perfiles, reseñas y rangos de precio por servicio.</p>

        <form method="GET" class="grid md:grid-cols-3 gap-4 mb-8">
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar..."
                class="border rounded-lg px-4 py-3 bg-white">
            <select name="categoria" class="border rounded-lg px-4 py-3 bg-white">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat }}" @selected(request('categoria') === $cat)>{{ $cat }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">Filtrar</button>
        </form>

        @if ($profesionales->isEmpty())
            <div class="bg-white border rounded-xl p-16 text-center text-gray-500">
                No hay profesionales en esta búsqueda.
            </div>
        @else
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($profesionales as $p)
                    @include('partials.profesional-card', ['profesional' => $p, 'puedeContratar' => $puedeContratar])
                @endforeach
            </div>
        @endif
    </div>
</main>
@endsection
