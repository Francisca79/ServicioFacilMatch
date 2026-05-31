@extends('layouts.panel')

@section('title', 'Reseñas — Admin')

@section('content')
<h1 class="text-3xl font-bold mb-8">Todas las reseñas</h1>
<div class="space-y-4">
    @foreach ($resenas as $r)
        @include('partials.admin-resena-card', ['r' => $r, 'showProfesional' => true])
    @endforeach
</div>
@endsection
