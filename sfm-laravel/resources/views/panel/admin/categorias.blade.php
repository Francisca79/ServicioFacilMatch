@extends('layouts.panel')

@section('title', 'Categorías — Admin')

@section('content')
<h1 class="text-3xl font-bold mb-8">Categorías y profesionales</h1>
@foreach ($categorias as $categoria)
    <div class="bg-white border rounded-xl p-6 mb-6 shadow-sm">
        <h2 class="text-xl font-bold">{{ $categoria->nombre_categoria }}</h2>
        <p class="text-gray-600 text-sm mb-4">{{ $categoria->descripcion }}</p>
        @if ($categoria->profesionales->isEmpty())
            <p class="text-gray-500 text-sm">Sin profesionales.</p>
        @else
            <div class="grid md:grid-cols-3 gap-4">
                @foreach ($categoria->profesionales as $p)
                    <a href="/panel/admin/profesionales/{{ $p->id }}" class="border rounded-lg p-4 hover:bg-gray-50">
                        <p class="font-semibold">{{ $p->nombre }}</p>
                        <p class="text-sm text-gray-500">⭐ {{ number_format($p->calificacion, 1) }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endforeach
@endsection
