@extends('layouts.app')

@section('title', $profesional->nombre . ' — SFM')

@section('content')
<main class="bg-gray-50 min-h-screen py-12 px-6">
    <div class="max-w-4xl mx-auto">
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : '/profesionales' }}"
            class="text-blue-600 text-sm hover:underline mb-6 inline-block">← Volver</a>

        <div class="bg-white rounded-xl border shadow-sm p-8">
            <div class="flex flex-wrap gap-6 items-start">
                <img src="{{ $profesional->foto_url }}" class="w-28 h-28 rounded-full object-cover border" alt="">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold">{{ $profesional->nombre }}</h1>
                    <p class="text-gray-600 mt-1">{{ $profesional->nombre_categoria }} · {{ $profesional->especialidad }}</p>
                    <p class="text-yellow-500 mt-2">⭐ {{ number_format($profesional->calificacion, 1) }}</p>
                    <p class="text-blue-600 font-bold text-2xl mt-3">{{ $profesional->rango_precio }} <span class="text-sm text-gray-500 font-normal">según el trabajo</span></p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-3 mt-6 text-sm text-gray-700">
                @if ($profesional->ciudad)<p>📍 {{ $profesional->ciudad }}</p>@endif
                @if ($profesional->telefono)<p>📞 {{ $profesional->telefono }}</p>@endif
                @if ($profesional->experiencia)<p>💼 {{ $profesional->experiencia }}</p>@endif
                @if ($profesional->modalidad)<p>🌐 {{ $profesional->modalidad }}</p>@endif
                @if ($profesional->disponibilidad)<p>🕐 {{ $profesional->disponibilidad }}</p>@endif
            </div>

            <p class="mt-6 text-gray-700">{{ $profesional->descripcion }}</p>

            @if ($puedeContratar)
                <a href="/panel/cliente/mensajes?profesional={{ $profesional->id }}"
                    class="inline-block mt-8 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">
                    Solicitar servicio
                </a>
            @elseif (auth()->check() && auth()->user()->isProfesional())
                <p class="mt-8 text-sm text-gray-500 bg-gray-100 rounded-lg p-4">Como profesional solo puedes ver perfiles. Para contratar necesitas una cuenta de cliente.</p>
            @elseif (!auth()->check())
                <a href="/login" class="inline-block mt-8 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">
                    Inicia sesión como cliente para contactar
                </a>
            @endif
        </div>

        <div class="bg-white rounded-xl border shadow-sm p-8 mt-8">
            <h2 class="text-xl font-bold mb-4">Reseñas ({{ $profesional->resenas->count() }})</h2>
            @forelse ($profesional->resenas as $r)
                <div class="border-b py-4 last:border-0">
                    <p class="font-medium">{{ $r->user->name ?? 'Cliente' }}</p>
                    <p class="text-yellow-500 text-sm">{{ str_repeat('⭐', $r->calificacion) }}</p>
                    <p class="text-gray-600 text-sm mt-1">{{ $r->comentario }}</p>
                </div>
            @empty
                <p class="text-gray-500">Sin reseñas aún.</p>
            @endforelse
        </div>

        @if ($esAdmin)
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mt-8">
                <h3 class="font-bold text-amber-900 mb-3">Enviar advertencia al profesional</h3>
                <form action="/panel/admin/advertencia" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="destinatario_id" value="{{ $profesional->user_id }}">
                    <input type="hidden" name="profesional_id" value="{{ $profesional->id }}">
                    @if (!$profesional->user_id)
                        <p class="text-amber-800 text-sm">Este perfil no tiene cuenta vinculada; la advertencia no se puede enviar por mensajería.</p>
                    @else
                        <input name="asunto" required placeholder="Asunto" class="w-full border rounded-lg px-4 py-2" value="Solicitud de mejora en tu perfil">
                        <textarea name="cuerpo" required rows="4" placeholder="Ej: Por favor actualiza tu foto o corrige la descripción..."
                            class="w-full border rounded-lg px-4 py-2"></textarea>
                        <button type="submit" class="bg-amber-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-amber-700">Enviar advertencia</button>
                    @endif
                </form>
            </div>
        @endif
    </div>
</main>
@endsection
