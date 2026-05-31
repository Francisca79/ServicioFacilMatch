@extends('layouts.app')

@section('title', 'Registro Cliente — SFM')

@section('content')
<main class="bg-gray-100 min-h-screen py-12 px-6">
    <section class="max-w-md mx-auto bg-white rounded-2xl shadow-md p-10">
        <h1 class="text-3xl font-bold mb-2 text-center">Registro Cliente</h1>
        <p class="text-gray-600 text-center mb-8 text-sm">Crea tu cuenta para explorar y contratar servicios.</p>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg text-sm">
                <ul class="list-disc pl-5">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="/registro-cliente" method="POST" class="space-y-4">
            @csrf
            <input name="nombre" placeholder="Nombre completo" value="{{ old('nombre') }}" required class="w-full border rounded-xl px-4 py-3 outline-none" />
            <input type="email" name="correo" placeholder="Correo electrónico" value="{{ old('correo') }}" required class="w-full border rounded-xl px-4 py-3 outline-none" />
            <input type="password" name="contrasena" placeholder="Contraseña" required class="w-full border rounded-xl px-4 py-3 outline-none" />
            <input type="password" name="contrasena_confirmation" placeholder="Confirmar contraseña" required class="w-full border rounded-xl px-4 py-3 outline-none" />
            <input name="telefono" placeholder="Teléfono" value="{{ old('telefono') }}" class="w-full border rounded-xl px-4 py-3 outline-none" />
            <input name="ciudad" placeholder="Ciudad" value="{{ old('ciudad') }}" class="w-full border rounded-xl px-4 py-3 outline-none" />
            <button type="submit" class="w-full bg-blue-700 text-white py-3 rounded-xl font-bold hover:bg-blue-800">Crear cuenta</button>
        </form>
        <p class="text-center mt-4 text-sm">¿Eres profesional? <a href="/registro" class="text-blue-600 font-semibold">Regístrate aquí</a></p>
    </section>
</main>
@endsection
