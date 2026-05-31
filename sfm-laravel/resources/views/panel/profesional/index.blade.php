@extends('layouts.panel')

@section('title', 'Mi Panel — Profesional SFM')

@section('content')
<div class="space-y-8">
    <div class="flex flex-wrap justify-between items-start gap-4">
        <div>
            <h1 class="text-3xl font-bold">Mi Panel Profesional</h1>
            <p class="text-gray-600 mt-1">Gestiona tu perfil y revisa la opinión de tus clientes.</p>
            @if ($mensajesNoLeidos > 0)
                <a href="/panel/profesional/mensajes" class="inline-flex items-center gap-2 mt-2 text-sm bg-red-100 text-red-700 px-3 py-1 rounded-full">
                    💬 {{ $mensajesNoLeidos }} mensaje(s) nuevo(s)
                </a>
            @endif
        </div>
        <a href="/panel/profesional/editar" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-700">
            ✏️ Editar mi perfil
        </a>
    </div>

    <div class="bg-white rounded-xl border shadow-sm p-6">
        <div class="flex items-start gap-6">
            <img src="{{ $profesional->foto_url }}"
                class="w-24 h-24 rounded-full object-cover border" alt="{{ $profesional->nombre }}">
            <div class="flex-1">
                <h2 class="text-2xl font-bold">{{ $profesional->nombre }}</h2>
                <p class="text-gray-600">{{ $profesional->categoria->nombre_categoria ?? '—' }} · {{ $profesional->especialidad }}</p>
                <p class="text-yellow-500 mt-1">⭐ {{ number_format($profesional->calificacion, 1) }} de calificación</p>
                <p class="text-blue-600 font-bold text-xl mt-2">{{ $profesional->rango_precio }} <span class="text-sm text-gray-500 font-normal">según el trabajo</span></p>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-4 mt-6 text-sm text-gray-700">
            <p>📍 {{ $profesional->ciudad ?? '—' }}</p>
            <p>📞 {{ $profesional->telefono ?? '—' }}</p>
            <p>💼 {{ $profesional->experiencia ?? '—' }}</p>
            <p>🕐 {{ $profesional->disponibilidad ?? '—' }}</p>
            <p>🌐 {{ $profesional->modalidad ?? '—' }}</p>
        </div>
        <p class="mt-4 text-gray-600">{{ $profesional->descripcion }}</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border shadow-sm p-6">
            <h2 class="text-lg font-bold mb-4">Reseñas recibidas ({{ $resenas->count() }})</h2>
            @forelse ($resenas as $r)
                <div class="border-b py-3 last:border-0">
                    <p class="font-medium">{{ $r->user->name ?? 'Cliente' }}</p>
                    <p class="text-yellow-500 text-sm">{{ str_repeat('⭐', $r->calificacion) }}</p>
                    <p class="text-gray-600 text-sm">{{ $r->comentario }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $r->created_at->format('d/m/Y') }}</p>
                </div>
            @empty
                <p class="text-gray-500">Aún no tienes reseñas.</p>
            @endforelse
        </div>

        <div class="bg-white rounded-xl border shadow-sm p-6">
            <h2 class="text-lg font-bold mb-4">Mensajes de contacto recientes</h2>
            @forelse ($contactosPendientes as $c)
                <div class="border-b py-3 last:border-0">
                    <p class="font-medium">{{ $c->nombre }}</p>
                    <p class="text-sm text-gray-500">{{ $c->correo }}</p>
                    <p class="text-gray-600 text-sm mt-1">{{ Str::limit($c->mensaje, 100) }}</p>
                </div>
            @empty
                <p class="text-gray-500">No hay mensajes de contacto.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
