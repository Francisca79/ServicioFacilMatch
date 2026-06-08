@extends('layouts.app')

@section('title', 'Registro Profesional — SFM')

@section('content')
<main class="bg-gray-100 min-h-screen py-12 px-6">
    <section class="max-w-5xl mx-auto bg-white rounded-2xl shadow-md p-10">
        <h1 class="text-4xl font-bold mb-10 text-center">Registro Profesional</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/registro" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <div class="grid md:grid-cols-2 gap-5">
                <input type="text" name="nombre" placeholder="Nombre completo" value="{{ old('nombre') }}"
                    class="border border-gray-300 rounded-xl px-4 py-3 outline-none" required />

                <input type="email" name="correo" placeholder="Correo electrónico" value="{{ old('correo') }}"
                    class="border border-gray-300 rounded-xl px-4 py-3 outline-none" required />

                <input type="password" name="contrasena" placeholder="Contraseña"
                    class="border border-gray-300 rounded-xl px-4 py-3 outline-none" required />

                <input type="password" name="contrasena_confirmation" placeholder="Confirmar contraseña"
                    class="border border-gray-300 rounded-xl px-4 py-3 outline-none" required />

                <input type="text" name="telefono" placeholder="Teléfono" value="{{ old('telefono') }}"
                    class="border border-gray-300 rounded-xl px-4 py-3 outline-none" />

                <input type="text" name="ciudad" value="San Miguel" readonly
                    class="border border-gray-300 rounded-xl px-4 py-3 outline-none bg-gray-100 text-gray-600" />

                <select name="categoria_id" class="border border-gray-300 rounded-xl px-4 py-3 outline-none" required>
                    <option value="">Seleccione categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>
                            {{ $categoria->nombre_categoria }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="experiencia" placeholder="Experiencia" value="{{ old('experiencia') }}"
                    class="border border-gray-300 rounded-xl px-4 py-3 outline-none" />

                <input type="text" name="especialidad" placeholder="Especialidad" value="{{ old('especialidad') }}"
                    class="border border-gray-300 rounded-xl px-4 py-3 outline-none" required />

                <input type="number" step="0.1" name="precio_estimado" placeholder="Precio" value="{{ old('precio_estimado') }}"
                    class="border border-gray-300 rounded-xl px-4 py-3 outline-none" required />

                <select name="modalidad" class="border border-gray-300 rounded-xl px-4 py-3 outline-none">
                    <option value="">Modalidad</option>
                    <option value="presencial" @selected(old('modalidad') == 'presencial')>Presencial</option>
                    <option value="online" @selected(old('modalidad') == 'online')>Online</option>
                    <option value="online y presencial" @selected(old('modalidad') == 'online y presencial')>Online y presencial</option>
                </select>

                <input type="text" name="disponibilidad" placeholder="Disponibilidad" value="{{ old('disponibilidad') }}"
                    class="border border-gray-300 rounded-xl px-4 py-3 outline-none" />

                <div class="md:col-span-2">
                    @include('partials.foto-input')
                </div>
            </div>

            <div>
                <label class="block text-lg font-semibold mb-3">Descripción del servicio</label>
                <textarea name="descripcion" rows="6"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none"
                    placeholder="Describe tu servicio...">{{ old('descripcion') }}</textarea>
            </div>

            <button type="submit"
                class="w-full bg-blue-700 hover:bg-blue-800 text-white py-4 rounded-xl font-bold text-lg transition">
                Crear perfil profesional
            </button>
        </form>
    </section>
</main>
@endsection
