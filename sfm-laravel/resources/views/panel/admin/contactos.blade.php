@extends('layouts.panel')

@section('title', 'Contactos — Admin')

@section('content')
<div class="bg-white rounded-xl border shadow-sm">
    <div class="px-6 py-4 border-b">
        <h1 class="text-2xl font-bold">Mensajes de contacto</h1>
        <p class="text-sm text-gray-600 mt-1">Cuando un cliente envía una solicitud desde el panel, el mensaje queda aquí y también llega al profesional por mensajería interna.</p>
    </div>
    <div class="divide-y">
        @forelse ($contactos as $c)
            <div class="px-6 py-4">
                <div class="flex justify-between">
                    <p class="font-bold">{{ $c->nombre }}</p>
                    <p class="text-sm text-gray-400">{{ $c->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <p class="text-sm text-blue-600">Para: {{ $c->profesional->nombre ?? '—' }} ({{ $c->profesional->categoria->nombre_categoria ?? '' }})</p>
                <p class="text-sm text-gray-500">{{ $c->correo }} @if($c->user) · Usuario: {{ $c->user->name }} @endif</p>
                <p class="mt-2 text-gray-700">{{ $c->mensaje }}</p>
            </div>
        @empty
            <p class="px-6 py-10 text-gray-500 text-center">No hay contactos. Los clientes pueden enviar solicitudes desde su panel → Contactar.</p>
        @endforelse
    </div>
</div>
@endsection
