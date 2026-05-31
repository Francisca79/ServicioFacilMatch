@extends('layouts.panel')

@section('title', $profesional->nombre . ' — Admin')

@section('content')
<div class="space-y-6">
    <a href="/panel/admin/profesionales" class="text-blue-600 text-sm hover:underline">← Volver al listado</a>

    <div class="bg-white rounded-xl border p-8 shadow-sm">
        <div class="flex gap-6 items-start">
            <img src="{{ $profesional->foto_url }}" class="w-24 h-24 rounded-full object-cover border" alt="">
            <div>
                <h1 class="text-3xl font-bold">{{ $profesional->nombre }}</h1>
                <p class="text-gray-600">{{ $profesional->nombre_categoria }} · {{ $profesional->especialidad }}</p>
                <p class="text-blue-600 font-bold text-xl mt-2">{{ $profesional->rango_precio }}</p>
                <p class="text-sm text-gray-500 mt-1">Cuenta: {{ $profesional->user?->email ?? 'Sin cuenta' }}</p>
            </div>
        </div>
        <p class="mt-6 text-gray-700">{{ $profesional->descripcion }}</p>
        <div class="mt-6 flex gap-3">
            <a href="/profesionales/{{ $profesional->id }}" target="_blank" class="text-blue-600 text-sm hover:underline">Ver perfil público</a>
            <form action="/panel/admin/profesionales/{{ $profesional->id }}" method="POST" onsubmit="return confirm('¿Eliminar perfil?')">
                @csrf @method('DELETE')
                <button class="text-red-600 text-sm hover:underline">Eliminar perfil</button>
            </form>
        </div>
    </div>

    @if ($profesional->user_id)
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
            <h2 class="font-bold text-amber-900 mb-3">Enviar advertencia al profesional</h2>
            <form action="/panel/admin/advertencia" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" name="destinatario_id" value="{{ $profesional->user_id }}">
                <input type="hidden" name="profesional_id" value="{{ $profesional->id }}">
                <input name="asunto" required class="w-full border rounded-lg px-4 py-2" value="Solicitud de mejora en tu perfil">
                <textarea name="cuerpo" required rows="4" class="w-full border rounded-lg px-4 py-2"
                    placeholder="Ej: El admin solicita que cambies o mejores tu foto porque podría incomodar a los usuarios..."></textarea>
                <button class="bg-amber-600 text-white px-5 py-2 rounded-lg font-semibold">Enviar advertencia</button>
            </form>
        </div>
    @endif

    <div class="bg-white rounded-xl border p-6">
        <h2 class="font-bold mb-4">Reseñas recibidas ({{ $profesional->resenas->count() }})</h2>
        @forelse ($profesional->resenas as $r)
            @include('partials.admin-resena-card', ['r' => $r, 'class' => 'mb-4 last:mb-0 bg-gray-50'])
        @empty
            <p class="text-gray-500">Sin reseñas.</p>
        @endforelse
    </div>
</div>
@endsection
