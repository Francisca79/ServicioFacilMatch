@extends('layouts.panel')

@section('title', 'Clientes — Admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold">Clientes registrados</h1>
            <p class="text-gray-600 mt-1">{{ $clientes->count() }} clientes en el sistema</p>
        </div>
        <a href="/panel/admin/usuarios" class="text-blue-600 text-sm hover:underline">Ver todos los usuarios →</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 text-red-700 p-4 rounded-lg">{{ $errors->first() }}</div>
    @endif

    @forelse ($clientes as $c)
        <div class="bg-white border rounded-xl p-6 shadow-sm {{ $c->bloqueado ? 'border-red-300 bg-red-50/30' : '' }}">
            <div class="flex flex-wrap gap-4 justify-between items-start">
                <div class="flex gap-4">
                    <img src="{{ $c->foto_url }}" class="w-14 h-14 rounded-full object-cover border" alt="">
                    <div>
                        <h2 class="font-bold text-lg">
                            <a href="/panel/admin/clientes/{{ $c->id }}" class="text-blue-600 hover:underline">{{ $c->name }}</a>
                        </h2>
                        <p class="text-sm text-gray-600">{{ $c->email }}</p>
                        <p class="text-sm text-gray-500">📞 {{ $c->telefono ?? 'Sin teléfono' }} · 📍 {{ $c->ciudad ?? 'San Miguel' }}</p>
                        @if ($c->bloqueado)
                            <span class="inline-block mt-1 text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded font-semibold">Cuenta bloqueada</span>
                        @endif
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <form action="/panel/admin/clientes/{{ $c->id }}/bloqueo" method="POST">
                        @csrf
                        <button class="text-sm px-3 py-1.5 rounded-lg border {{ $c->bloqueado ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                            {{ $c->bloqueado ? 'Desbloquear' : 'Bloquear' }}
                        </button>
                    </form>
                    <form action="/panel/admin/usuarios/{{ $c->id }}" method="POST" onsubmit="return confirm('¿Eliminar cliente?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 text-sm hover:underline px-2 py-1.5">Eliminar</button>
                    </form>
                </div>
            </div>

            <div class="mt-4 grid md:grid-cols-2 gap-4">
                <div class="border-t pt-4">
                    <p class="text-sm font-semibold mb-2">Verificar servicio (permite reseñar)</p>
                    <form action="/panel/admin/verificar-servicio" method="POST" class="flex flex-wrap gap-2 items-end">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $c->id }}">
                        <select name="profesional_id" required class="border rounded px-3 py-2 text-sm flex-1 min-w-[180px]">
                            <option value="">Profesional...</option>
                            @foreach ($profesionales as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                            @endforeach
                        </select>
                        <input name="notas" placeholder="Notas" class="border rounded px-3 py-2 text-sm">
                        <button class="bg-green-600 text-white text-sm px-4 py-2 rounded">Verificar</button>
                    </form>
                </div>
                <div class="border-t pt-4">
                    <p class="text-sm font-semibold mb-2">Servicios verificados</p>
                    @forelse ($c->serviciosAdquiridos->where('verificado', true) as $s)
                        <div class="text-sm flex justify-between items-center py-1">
                            <span>✓ {{ $s->profesional->nombre ?? 'Profesional' }}
                                @if ($s->estado_pago === 'pagado')
                                    <span class="text-green-600 text-xs">(Pagado ${{ number_format($s->monto_pagado ?? 0, 0) }})</span>
                                @else
                                    <span class="text-amber-600 text-xs">(Pago pendiente)</span>
                                @endif
                            </span>
                            <form action="/panel/admin/servicios/{{ $s->id }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="text-red-500 text-xs">Revocar</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Sin servicios verificados.</p>
                    @endforelse
                </div>
            </div>

            @if ($c->advertenciasRecibidas->count())
                <div class="mt-4 border-t pt-4">
                    <p class="text-sm font-semibold text-amber-900 mb-2">Historial de advertencias ({{ $c->advertenciasRecibidas->count() }})</p>
                    @foreach ($c->advertenciasRecibidas->take(3) as $adv)
                        <div class="text-sm bg-amber-50 rounded p-2 mb-2">
                            <p class="font-medium">{{ $adv->asunto }}</p>
                            <p class="text-gray-600">{{ Str::limit($adv->cuerpo, 120) }}</p>
                            <p class="text-xs text-gray-400">{{ $adv->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="/panel/admin/advertencia" method="POST" class="mt-4 bg-amber-50 rounded-lg p-4 space-y-2">
                @csrf
                <input type="hidden" name="destinatario_id" value="{{ $c->id }}">
                <p class="text-sm font-semibold text-amber-900">Enviar advertencia</p>
                <input name="asunto" required class="w-full border rounded px-3 py-2 text-sm" placeholder="Asunto">
                <textarea name="cuerpo" required rows="2" class="w-full border rounded px-3 py-2 text-sm" placeholder="Mensaje..."></textarea>
                <button class="bg-amber-600 text-white text-sm px-4 py-1.5 rounded">Enviar advertencia</button>
            </form>
        </div>
    @empty
        <p class="text-gray-500">No hay clientes registrados.</p>
    @endforelse
</div>
@endsection
