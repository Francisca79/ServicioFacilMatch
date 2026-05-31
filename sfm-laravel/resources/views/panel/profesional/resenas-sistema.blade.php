@extends('layouts.panel')

@section('title', 'Reseñas — Profesional')

@section('content')
<h1 class="text-3xl font-bold mb-8">Reseñas del sistema</h1>
@foreach ($resenas as $r)
    <div class="bg-white border rounded-xl p-5 mb-4 shadow-sm">
        <p class="font-bold">{{ $r->user->name ?? 'Cliente' }} → {{ $r->profesional->nombre }}</p>
        <p class="text-yellow-500 text-sm">{{ str_repeat('⭐', $r->calificacion) }}</p>
        <p class="text-gray-700 mt-2">{{ $r->comentario }}</p>
    </div>
@endforeach
@endsection
