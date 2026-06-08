@extends('layouts.panel')

@section('title', 'Usuarios — Admin')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold">Todos los usuarios</h1>
        <p class="text-gray-600 mt-1">
            Clientes, profesionales y administradores con cuenta.
            @if (request('filtro') === 'bloqueados')
                <span class="text-red-700 font-medium">Mostrando solo bloqueados.</span>
                <a href="/panel/admin/usuarios" class="text-blue-600 hover:underline ml-2">Ver todos</a>
            @endif
        </p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 text-red-700 p-4 rounded-lg">{{ $errors->first() }}</div>
    @endif

    @foreach ($usuarios as $u)
        @php
            $perfilUrl = match (true) {
                $u->tipo_usuario === 'cliente' => '/panel/admin/clientes/'.$u->id,
                $u->tipo_usuario === 'profesional' && $u->profesional => '/panel/admin/profesionales/'.$u->profesional->id,
                default => null,
            };
        @endphp
        <div class="bg-white border rounded-xl p-6 shadow-sm {{ $u->bloqueado ? 'border-red-300 bg-red-50/20' : '' }}">
            <div class="flex flex-wrap justify-between gap-4">
                <div>
                    <h2 class="font-bold text-lg">
                        @if ($perfilUrl)
                            <a href="{{ $perfilUrl }}" class="text-blue-600 hover:underline">{{ $u->name }}</a>
                        @else
                            {{ $u->name }}
                        @endif
                    </h2>
                    <p class="text-sm text-gray-600">{{ $u->email }} · <span class="capitalize">{{ $u->tipo_usuario }}</span></p>
                    @if ($u->profesional)
                        <p class="text-sm text-blue-600 mt-1">
                            Perfil: <a href="/panel/admin/profesionales/{{ $u->profesional->id }}" class="hover:underline">{{ $u->profesional->nombre }}</a>
                        </p>
                    @endif
                    @if ($perfilUrl)
                        <a href="{{ $perfilUrl }}" class="text-xs text-blue-600 hover:underline mt-1 inline-block">Ver perfil completo →</a>
                    @endif
                    @if ($u->bloqueado)
                        <span class="inline-block mt-1 text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded font-semibold">Bloqueado</span>
                    @endif
                </div>
                <div class="flex flex-wrap gap-2 items-start">
                    @if (! $u->isAdmin())
                        <form action="/panel/admin/usuarios/{{ $u->id }}/bloqueo" method="POST">
                            @csrf
                            <button class="text-sm px-3 py-1.5 rounded-lg border {{ $u->bloqueado ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                {{ $u->bloqueado ? 'Desbloquear' : 'Bloquear' }}
                            </button>
                        </form>
                        <form action="/panel/admin/usuarios/{{ $u->id }}" method="POST" onsubmit="return confirm('¿Eliminar usuario?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 text-sm hover:underline px-2 py-1.5">Eliminar</button>
                        </form>
                    @endif
                </div>
            </div>

            @if (! $u->isAdmin())
                <form action="/panel/admin/advertencia" method="POST" class="mt-4 bg-amber-50 rounded-lg p-4 space-y-2">
                    @csrf
                    <input type="hidden" name="destinatario_id" value="{{ $u->id }}">
                    @if ($u->profesional)
                        <input type="hidden" name="profesional_id" value="{{ $u->profesional->id }}">
                    @endif
                    <p class="text-sm font-semibold text-amber-900">Enviar advertencia a {{ $u->name }}</p>
                    <input name="asunto" required class="w-full border rounded px-3 py-2 text-sm" placeholder="Asunto">
                    <textarea name="cuerpo" required rows="2" class="w-full border rounded px-3 py-2 text-sm" placeholder="Mensaje de advertencia..."></textarea>
                    <button class="bg-amber-600 text-white text-sm px-4 py-1.5 rounded">Enviar</button>
                </form>
            @endif
        </div>
    @endforeach
</div>
@endsection
