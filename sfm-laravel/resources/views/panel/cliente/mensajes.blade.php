@extends('layouts.panel')

@section('title', 'Mensajería — Cliente')

@section('content')
<div class="flex items-center gap-3 mb-2">
    <h1 class="text-3xl font-bold">Mensajería</h1>
    @if ($mensajesNoLeidos > 0)
        <span class="bg-red-500 text-white text-sm font-bold min-w-[1.5rem] h-6 px-2 rounded-full flex items-center justify-center">
            {{ $mensajesNoLeidos }}
        </span>
    @endif
</div>
<p class="text-gray-600 mb-8">Contacta profesionales, envía solicitudes de servicio y responde conversaciones.</p>

@include('partials.mensajeria', [
    'conversaciones' => $conversaciones,
    'profesionales' => $profesionales,
    'postUrl' => '/panel/cliente/mensajes',
    'deleteUrl' => '/panel/cliente/mensajes',
    'esCliente' => true,
    'profesionalId' => $profesionalId,
    'mensajesNoLeidos' => $mensajesNoLeidos,
    'serviciosPorConversacion' => $serviciosPorConversacion,
])
@endsection
