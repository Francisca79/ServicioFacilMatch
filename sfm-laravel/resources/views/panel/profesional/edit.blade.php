@extends('layouts.panel')

@section('title', 'Editar Perfil — Profesional SFM')

@section('content')
<div class="max-w-3xl">
    <h1 class="text-3xl font-bold mb-2">Mi Perfil Profesional</h1>
    <p class="text-gray-600 mb-8">Actualiza la información que ven los clientes sobre tu trabajo.</p>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="/panel/profesional/editar" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border shadow-sm p-8 space-y-5">
        @csrf @method('PUT')

        <div class="grid md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Nombre completo</label>
                <input name="nombre" value="{{ old('nombre', $profesional->nombre) }}" required
                    class="w-full border rounded-lg px-4 py-2 outline-none" />
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Especialidad</label>
                <input name="especialidad" value="{{ old('especialidad', $profesional->especialidad) }}" required
                    class="w-full border rounded-lg px-4 py-2 outline-none" />
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Categoría</label>
                <select name="categoria_id" required class="w-full border rounded-lg px-4 py-2 outline-none">
                    @foreach ($categorias as $cat)
                        <option value="{{ $cat->id }}" @selected(old('categoria_id', $profesional->categoria_id) == $cat->id)>
                            {{ $cat->nombre_categoria }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Precio mínimo ($)</label>
                <input type="number" step="0.01" name="precio_min" value="{{ old('precio_min', $profesional->precio_min ?? $profesional->precio_estimado) }}" required
                    class="w-full border rounded-lg px-4 py-2 outline-none" />
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Precio máximo ($)</label>
                <input type="number" step="0.01" name="precio_max" value="{{ old('precio_max', $profesional->precio_max ?? $profesional->precio_estimado) }}" required
                    class="w-full border rounded-lg px-4 py-2 outline-none" />
                <p class="text-xs text-gray-500 mt-1">El precio final depende del tamaño del trabajo.</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Teléfono</label>
                <input name="telefono" value="{{ old('telefono', $profesional->telefono) }}"
                    class="w-full border rounded-lg px-4 py-2 outline-none" />
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Ciudad</label>
                <input name="ciudad" value="San Miguel" readonly class="w-full border rounded-lg px-4 py-2 outline-none bg-gray-100 text-gray-600" />
                <p class="text-xs text-gray-500 mt-1">SFM solo opera en San Miguel, El Salvador.</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Zona de San Miguel</label>
                <select name="zona" class="w-full border rounded-lg px-4 py-2 outline-none">
                    <option value="">Seleccione zona...</option>
                    @foreach (\App\Support\ZonasSanMiguel::todas() as $z)
                        <option value="{{ $z }}" @selected(old('zona', $profesional->zona ?? '') == $z)>{{ $z }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Experiencia</label>
                <input name="experiencia" value="{{ old('experiencia', $profesional->experiencia) }}"
                    class="w-full border rounded-lg px-4 py-2 outline-none" />
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Modalidad</label>
                <select name="modalidad" class="w-full border rounded-lg px-4 py-2 outline-none">
                    <option value="">Seleccione</option>
                    @foreach (['presencial', 'online', 'online y presencial'] as $m)
                        <option value="{{ $m }}" @selected(old('modalidad', $profesional->modalidad) == $m)>{{ ucfirst($m) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Disponibilidad</label>
                <input name="disponibilidad" value="{{ old('disponibilidad', $profesional->disponibilidad) }}"
                    class="w-full border rounded-lg px-4 py-2 outline-none" />
            </div>
            <div class="md:col-span-2">
                @include('partials.foto-input')
                @if ($profesional->foto)
                    <img src="{{ $profesional->foto_url }}" class="w-20 h-20 rounded-full mt-2 object-cover" alt="">
                @endif
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Descripción del servicio</label>
            <textarea name="descripcion" rows="5" class="w-full border rounded-lg px-4 py-2 outline-none">{{ old('descripcion', $profesional->descripcion) }}</textarea>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
            Guardar cambios
        </button>
    </form>
</div>
@endsection
