@extends('layouts.app')

@section('title', 'Categorías — SFM')

@section('content')
<main class="bg-gray-50 min-h-screen py-12 px-6">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-extrabold mb-2 text-center">Categorías de Servicios</h1>
        <p class="text-gray-600 text-center mb-12">Profesionales y reseñas por categoría</p>

        @foreach ($categorias as $categoria)
            <div class="bg-white border rounded-xl p-8 mb-8 shadow-sm">
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <h2 class="text-2xl font-bold flex-1">{{ $categoria->nombre_categoria }}</h2>
                    <a href="/profesionales?categoria={{ urlencode($categoria->nombre_categoria) }}"
                        class="text-blue-600 text-sm hover:underline">Ver todos →</a>
                </div>
                <p class="text-gray-600 mb-6">{{ $categoria->descripcion }}</p>

                @if ($categoria->profesionales->isEmpty())
                    <p class="text-gray-500 text-sm">No hay profesionales en esta categoría.</p>
                @else
                    <div class="grid md:grid-cols-3 gap-4">
                        @foreach ($categoria->profesionales->take(3) as $p)
                            @include('partials.profesional-card', ['profesional' => $p, 'puedeContratar' => $puedeContratar])
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</main>
@endsection
