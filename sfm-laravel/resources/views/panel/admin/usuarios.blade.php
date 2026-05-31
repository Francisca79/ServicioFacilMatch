@extends('layouts.panel')

@section('title', 'Usuarios — Admin')

@section('content')
<div class="space-y-8">
    <h1 class="text-3xl font-bold">Usuarios del sistema</h1>

    @if ($errors->any())
        <div class="bg-red-50 text-red-700 p-4 rounded-lg">{{ $errors->first() }}</div>
    @endif

    @foreach ($usuarios as $u)
        <div class="bg-white border rounded-xl p-6 shadow-sm">
            <div class="flex flex-wrap justify-between gap-4">
                <div>
                    <h2 class="font-bold text-lg">{{ $u->name }}</h2>
                    <p class="text-sm text-gray-600">{{ $u->email }} · <span class="capitalize">{{ $u->tipo_usuario }}</span></p>
                    @if ($u->profesional)
                        <p class="text-sm text-blue-600 mt-1">Perfil: {{ $u->profesional->nombre }}</p>
                    @endif
                </div>
                @if (!$u->isAdmin())
                    <form action="/panel/admin/usuarios/{{ $u->id }}" method="POST" onsubmit="return confirm('¿Eliminar usuario?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 text-sm hover:underline">Eliminar usuario</button>
                    </form>
                @endif
            </div>

            @if (!$u->isAdmin())
                <form action="/panel/admin/advertencia" method="POST" class="mt-4 bg-amber-50 rounded-lg p-4 space-y-2">
                    @csrf
                    <input type="hidden" name="destinatario_id" value="{{ $u->id }}">
                    <p class="text-sm font-semibold text-amber-900">Enviar advertencia a {{ $u->name }}</p>
                    <input name="asunto" required class="w-full border rounded px-3 py-2 text-sm" placeholder="Asunto">
                    <textarea name="cuerpo" required rows="2" class="w-full border rounded px-3 py-2 text-sm" placeholder="Mensaje de advertencia..."></textarea>
                    <button class="bg-amber-600 text-white text-sm px-4 py-1.5 rounded">Enviar</button>
                </form>
            @endif

            @if ($u->isCliente())
                <div class="mt-4 border-t pt-4">
                    <p class="text-sm font-semibold mb-2">Verificar servicio adquirido (permite reseñar)</p>
                    <form action="/panel/admin/verificar-servicio" method="POST" class="flex flex-wrap gap-2 items-end">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $u->id }}">
                        <select name="profesional_id" required class="border rounded px-3 py-2 text-sm">
                            <option value="">Profesional...</option>
                            @foreach ($profesionales as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                            @endforeach
                        </select>
                        <input name="notas" placeholder="Notas (opcional)" class="border rounded px-3 py-2 text-sm">
                        <button class="bg-green-600 text-white text-sm px-4 py-2 rounded">Verificar</button>
                    </form>
                    @if ($u->serviciosAdquiridos->where('verificado', true)->count())
                        <ul class="mt-2 text-sm text-green-700">
                            @foreach ($u->serviciosAdquiridos->where('verificado', true) as $s)
                                <li class="flex justify-between items-center py-1">
                                    ✓ {{ $s->profesional->nombre ?? 'Profesional' }}
                                    <form action="/panel/admin/servicios/{{ $s->id }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 text-xs">Revocar</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif
        </div>
    @endforeach
</div>
@endsection
