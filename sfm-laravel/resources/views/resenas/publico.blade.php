@extends('layouts.app')

@section('title', 'Reseñas — SFM')

@section('content')
<main class="bg-gray-50 min-h-screen py-12 px-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-extrabold mb-2">Reseñas de Profesionales</h1>
        <p class="text-gray-600 mb-8">Opiniones verificadas de clientes que adquirieron el servicio.</p>

        @if ($puedeResenar)
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-8 text-sm text-blue-800">
                Para publicar reseñas ve a <a href="/panel/cliente/resenas" class="font-semibold underline">tu panel → Reseñas</a>.
                Solo puedes reseñar profesionales cuyo servicio fue verificado por el administrador.
            </div>
        @endif

        @forelse ($resenas as $r)
            <div class="bg-white border rounded-xl p-6 mb-4 shadow-sm">
                <div class="flex justify-between">
                    <div>
                        <p class="font-bold">{{ $r->user->name ?? 'Cliente' }}</p>
                        <a href="/profesionales/{{ $r->profesional_id }}" class="text-blue-600 text-sm hover:underline">
                            {{ $r->profesional->nombre }} — {{ $r->profesional->categoria->nombre_categoria ?? '' }}
                        </a>
                    </div>
                    <span class="text-yellow-500">{{ str_repeat('⭐', $r->calificacion) }}</span>
                </div>
                <p class="text-gray-700 mt-3">{{ $r->comentario }}</p>
                <p class="text-xs text-gray-400 mt-2">{{ $r->created_at->format('d/m/Y') }}</p>
            </div>
        @empty
            <p class="text-center text-gray-500 py-16">Aún no hay reseñas publicadas.</p>
        @endforelse
    </div>
</main>
@endsection
