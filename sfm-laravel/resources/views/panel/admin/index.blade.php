@extends('layouts.panel')

@section('title', 'Panel Admin — SFM')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Panel de Administración</h1>
        <p class="text-gray-600 mt-1">Control total del sistema Servicio Fácil Match</p>
        <div class="flex flex-wrap gap-3 mt-3 text-sm">
            <a href="/panel/admin/pagos" class="text-blue-600 hover:underline">Pagos</a>
            <a href="/panel/admin/reportes" class="text-blue-600 hover:underline">Reportes</a>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach ($stats as $label => $stat)
            <a href="{{ $stat['url'] }}" class="bg-white rounded-xl border p-5 text-center shadow-sm hover:border-blue-400 hover:shadow-md transition block">
                <p class="text-3xl font-bold text-blue-600">{{ $stat['valor'] }}</p>
                <p class="text-sm text-gray-500 capitalize mt-1">{{ $label }}</p>
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold">Profesionales registrados</h2>
            <a href="/panel/admin/profesionales" class="text-blue-600 text-sm hover:underline">Ver todos →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Categoría</th>
                        <th class="px-4 py-3 text-left">Precio</th>
                        <th class="px-4 py-3 text-left">Calificación</th>
                        <th class="px-4 py-3 text-left">Usuario</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profesionales as $p)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium">
                                <a href="/panel/admin/profesionales/{{ $p->id }}" class="text-blue-600 hover:underline">{{ $p->nombre }}</a>
                            </td>
                            <td class="px-4 py-3">{{ $p->categoria->nombre_categoria ?? '—' }}</td>
                            <td class="px-4 py-3">${{ $p->precio_estimado }}</td>
                            <td class="px-4 py-3">⭐ {{ number_format($p->calificacion, 1) }}</td>
                            <td class="px-4 py-3 text-gray-500">
                                @if ($p->user)
                                    <a href="/panel/admin/profesionales/{{ $p->id }}" class="text-blue-600 hover:underline">{{ $p->user->email }}</a>
                                @else
                                    Sin cuenta
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <form action="/panel/admin/profesionales/{{ $p->id }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline text-xs">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">Últimas reseñas</h2>
                <a href="/panel/admin/resenas" class="text-blue-600 text-sm hover:underline">Ver todas →</a>
            </div>
            <div class="space-y-4">
            @forelse ($resenas as $r)
                @include('partials.admin-resena-card', ['r' => $r, 'showProfesional' => true])
            @empty
                <p class="text-gray-500">Sin reseñas</p>
            @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-amber-900">Advertencias recientes</h2>
                <a href="/panel/admin/advertencias" class="text-blue-600 text-sm hover:underline">Ver todas →</a>
            </div>
            @forelse ($advertenciasRecientes as $a)
                <div class="border-b py-3 last:border-0 text-sm">
                    <p class="font-medium">{{ $a->destinatario->name ?? '—' }}</p>
                    <p class="text-gray-600">{{ Str::limit($a->asunto, 50) }}</p>
                    <p class="text-xs text-gray-400">{{ $a->created_at->format('d/m/Y') }}</p>
                </div>
            @empty
                <p class="text-gray-500">Sin advertencias</p>
            @endforelse
        </div>

        <div class="bg-white rounded-xl border shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-red-800">Usuarios bloqueados</h2>
                <a href="/panel/admin/usuarios?filtro=bloqueados" class="text-blue-600 text-sm hover:underline">Ver todos →</a>
            </div>
            @forelse ($usuariosBloqueados as $u)
                <div class="border-b py-3 last:border-0 text-sm">
                    <p class="font-medium">
                        @if ($u->tipo_usuario === 'cliente')
                            <a href="/panel/admin/clientes/{{ $u->id }}" class="text-blue-600 hover:underline">{{ $u->name }}</a>
                        @elseif ($u->profesional)
                            <a href="/panel/admin/profesionales/{{ $u->profesional->id }}" class="text-blue-600 hover:underline">{{ $u->name }}</a>
                        @else
                            {{ $u->name }}
                        @endif
                        <span class="text-gray-400 capitalize">({{ $u->tipo_usuario }})</span>
                    </p>
                    <p class="text-gray-500">{{ $u->email }}</p>
                </div>
            @empty
                <p class="text-gray-500">Ningún usuario bloqueado</p>
            @endforelse
        </div>

        <div class="bg-white rounded-xl border shadow-sm p-6 md:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-green-800">Pagos confirmados (efectivo)</h2>
                <a href="/panel/admin/pagos" class="text-blue-600 text-sm hover:underline">Ver todos →</a>
            </div>
            @forelse ($pagosRecientes as $p)
                <div class="border-b py-3 last:border-0 text-sm flex justify-between">
                    <div>
                        <p class="font-medium">{{ $p->cliente->name ?? '—' }} → {{ $p->profesional->nombre ?? '—' }}</p>
                        <p class="text-gray-500">{{ $p->fecha_cobro?->format('d/m/Y H:i') ?? '—' }}</p>
                    </div>
                    <p class="font-bold text-green-700">${{ number_format($p->monto_pagado, 0) }}</p>
                </div>
            @empty
                <p class="text-gray-500">Sin pagos registrados aún</p>
            @endforelse
        </div>

        <div class="bg-white rounded-xl border shadow-sm p-6">
            <h2 class="text-lg font-bold mb-4">Últimos contactos</h2>
            @forelse ($contactos as $c)
                <div class="border-b py-3 last:border-0">
                    <p class="font-medium">{{ $c->nombre }} → {{ $c->profesional->nombre ?? '—' }}</p>
                    <p class="text-gray-500 text-sm">{{ $c->correo }}</p>
                    <p class="text-gray-600 text-sm">{{ Str::limit($c->mensaje, 80) }}</p>
                </div>
            @empty
                <p class="text-gray-500">Sin contactos</p>
            @endforelse
            <a href="/panel/admin/contactos" class="text-blue-600 text-sm mt-3 inline-block hover:underline">Ver todos →</a>
        </div>
    </div>
</div>
@endsection
