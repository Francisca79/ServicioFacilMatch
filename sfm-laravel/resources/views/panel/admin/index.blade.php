@extends('layouts.panel')

@section('title', 'Panel Admin — SFM')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Panel de Administración</h1>
        <p class="text-gray-600 mt-1">Control total del sistema Servicio Fácil Match</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
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
                            <td class="px-4 py-3 text-gray-500">{{ $p->user?->email ?? 'Sin cuenta' }}</td>
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

    <div class="grid md:grid-cols-2 gap-6">
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
