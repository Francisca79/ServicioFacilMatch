@extends('layouts.panel')

@section('title', 'Mi Panel — Cliente SFM')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold">Hola, {{ auth()->user()->name }}</h1>
        <p class="text-gray-600 mt-1">Explora profesionales, contrata servicios y deja reseñas verificadas.</p>
        @if ($mensajesNoLeidos > 0)
            <a href="/panel/cliente/mensajes" class="inline-block mt-2 text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                💬 {{ $mensajesNoLeidos }} mensaje(s) nuevo(s)
            </a>
        @endif
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="/panel/cliente/profesionales" class="bg-white border rounded-xl p-6 shadow-sm hover:shadow-md transition">
            <div class="text-3xl mb-3">🔍</div>
            <h3 class="font-bold text-lg">Explorar</h3>
        </a>
        <a href="/panel/cliente/mensajes" class="bg-white border rounded-xl p-6 shadow-sm hover:shadow-md transition relative">
            <div class="text-3xl mb-3">💬</div>
            <h3 class="font-bold text-lg">Mensajería</h3>
            @if ($mensajesNoLeidos > 0)
                <span class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $mensajesNoLeidos }}</span>
            @endif
        </a>
        <a href="/panel/cliente/resenas" class="bg-white border rounded-xl p-6 shadow-sm hover:shadow-md transition">
            <div class="text-3xl mb-3">⭐</div>
            <h3 class="font-bold text-lg">Reseñas</h3>
        </a>
        <a href="/panel/cliente/perfil" class="bg-white border rounded-xl p-6 shadow-sm hover:shadow-md transition">
            <div class="text-3xl mb-3">👤</div>
            <h3 class="font-bold text-lg">Mi Perfil</h3>
        </a>
    </div>

    <div class="bg-white rounded-xl border shadow-sm p-6">
        <h2 class="text-xl font-bold mb-4">Profesionales destacados</h2>
        <div class="grid md:grid-cols-3 gap-4">
            @foreach ($profesionalesDestacados as $p)
                <div class="border rounded-lg p-4">
                    <a href="/profesionales/{{ $p->id }}" class="font-bold hover:text-blue-600">{{ $p->nombre }}</a>
                    <p class="text-sm text-gray-600">{{ $p->nombre_categoria }}</p>
                    <p class="text-yellow-500 text-sm mt-1">⭐ {{ number_format($p->calificacion, 1) }}</p>
                    <p class="text-blue-600 font-bold mt-2">{{ $p->rango_precio }}</p>
                    <a href="/panel/cliente/mensajes?profesional={{ $p->id }}" class="text-sm bg-blue-600 text-white px-3 py-1.5 rounded-lg inline-block mt-2 hover:bg-blue-700">Contactar</a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-xl border shadow-sm p-6">
        <h2 class="text-xl font-bold mb-4">Mis reseñas publicadas</h2>
        @forelse ($misResenas as $r)
            <div class="border-b py-3 last:border-0">
                <p class="font-medium">{{ $r->profesional->nombre }} — {{ $r->profesional->categoria->nombre_categoria ?? '' }}</p>
                <p class="text-yellow-500 text-sm">{{ str_repeat('⭐', $r->calificacion) }}</p>
                <p class="text-gray-600 text-sm">{{ $r->comentario }}</p>
            </div>
        @empty
            <p class="text-gray-500">Aún no has publicado reseñas. <a href="/panel/cliente/resenas" class="text-blue-600 hover:underline">Ir a reseñas →</a></p>
        @endforelse
    </div>
</div>
@endsection
