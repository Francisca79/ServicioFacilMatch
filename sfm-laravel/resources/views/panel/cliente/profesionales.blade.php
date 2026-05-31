@extends('layouts.panel')

@section('title', 'Explorar — Cliente')

@section('content')
<div class="space-y-6">
    <h1 class="text-3xl font-bold">Explorar profesionales</h1>
    <form method="GET" class="grid md:grid-cols-3 gap-3">
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar..." class="border rounded-lg px-4 py-2">
        <select name="categoria" class="border rounded-lg px-4 py-2">
            <option value="">Todas</option>
            @foreach ($categorias as $cat)
                <option value="{{ $cat }}" @selected(request('categoria') === $cat)>{{ $cat }}</option>
            @endforeach
        </select>
        <button class="bg-blue-600 text-white rounded-lg font-semibold">Buscar</button>
    </form>
    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach ($profesionales as $p)
            @include('partials.profesional-card', ['profesional' => $p, 'puedeContratar' => true])
        @endforeach
    </div>
</div>
@endsection
