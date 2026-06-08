@extends('layouts.panel')

@section('title', $cliente->name . ' — Admin')

@section('content')
<div class="space-y-6">
    <a href="/panel/admin/usuarios" class="text-blue-600 text-sm hover:underline">← Volver a usuarios</a>

    <div class="bg-white rounded-xl border p-8 shadow-sm {{ $cliente->bloqueado ? 'border-red-300' : '' }}">
        <div class="flex flex-wrap gap-6 items-start justify-between">
            <div class="flex gap-4">
                <img src="{{ $cliente->foto_url }}" class="w-20 h-20 rounded-full object-cover border" alt="">
                <div>
                    <h1 class="text-3xl font-bold">{{ $cliente->name }}</h1>
                    <p class="text-gray-600">{{ $cliente->email }}</p>
                    <p class="text-sm text-gray-500 mt-1">📞 {{ $cliente->telefono ?? '—' }} · 📍 {{ $cliente->ciudad ?? 'San Miguel' }}</p>
                    @if ($cliente->bloqueado)
                        <span class="inline-block mt-2 text-xs bg-red-100 text-red-800 px-2 py-1 rounded font-semibold">Cuenta bloqueada</span>
                    @endif
                </div>
            </div>
            <div class="flex gap-2">
                <form action="/panel/admin/usuarios/{{ $cliente->id }}/bloqueo" method="POST">
                    @csrf
                    <button class="text-sm px-4 py-2 rounded-lg border {{ $cliente->bloqueado ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                        {{ $cliente->bloqueado ? 'Desbloquear' : 'Bloquear' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border p-6 shadow-sm">
            <h2 class="font-bold text-lg mb-4">Servicios y pagos</h2>
            @forelse ($cliente->serviciosAdquiridos as $s)
                <div class="border-b py-3 last:border-0 text-sm">
                    <p class="font-medium">{{ $s->profesional->nombre ?? 'Profesional' }}</p>
                    <p class="text-gray-500">
                        Solicitud: {{ $s->estado_solicitud ?? '—' }}
                        @if ($s->verificado) · Verificado @endif
                    </p>
                    @if ($s->profesional_confirmo_cobro)
                        <p class="text-green-600">💵 Cobro confirmado por profesional — ${{ number_format($s->monto_pagado, 0) }} ({{ $s->metodo_pago }})</p>
                    @else
                        <p class="text-amber-600">Cobro pendiente de confirmación del profesional</p>
                    @endif
                </div>
            @empty
                <p class="text-gray-500">Sin servicios registrados.</p>
            @endforelse
        </div>

        <div class="bg-white rounded-xl border p-6 shadow-sm">
            <h2 class="font-bold text-lg mb-4">Reseñas publicadas ({{ $cliente->resenas->count() }})</h2>
            @forelse ($cliente->resenas as $r)
                <div class="border-b py-3 last:border-0 text-sm">
                    <p class="font-medium">{{ $r->profesional->nombre ?? '—' }}</p>
                    <p class="text-yellow-500">{{ str_repeat('⭐', $r->calificacion) }}</p>
                    <p class="text-gray-600">{{ Str::limit($r->comentario, 100) }}</p>
                </div>
            @empty
                <p class="text-gray-500">Sin reseñas.</p>
            @endforelse
        </div>
    </div>

    @if ($cliente->advertenciasRecibidas->count())
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
            <h2 class="font-bold text-amber-900 mb-4">Advertencias recibidas</h2>
            @foreach ($cliente->advertenciasRecibidas as $adv)
                <div class="bg-white rounded p-3 mb-2 text-sm">
                    <p class="font-medium">{{ $adv->asunto }}</p>
                    <p class="text-gray-600">{{ $adv->cuerpo }}</p>
                    <p class="text-xs text-gray-400 mt-1">De: {{ $adv->remitente->name ?? 'Admin' }} · {{ $adv->created_at->format('d/m/Y H:i') }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
