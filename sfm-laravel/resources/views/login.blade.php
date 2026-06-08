@extends('layouts.app')

@section('title', 'Iniciar Sesión — SFM')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-6">
    <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-bold text-center mb-8">Iniciar Sesión</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-2 font-medium">Correo Electrónico</label>
                <input name="correo" type="email" value="{{ old('correo') }}"
                    placeholder="correo@gmail.com"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none @error('correo') border-red-500 @enderror" required />
            </div>
            <div>
                <label class="block mb-2 font-medium">Contraseña</label>
                <input name="contrasena" type="password" placeholder="********"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" required />
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                Iniciar Sesión
            </button>
        </form>

        <p class="text-center mt-4 text-sm">
            <a href="/olvide-contrasena" class="text-blue-600 hover:underline">¿Olvidaste tu contraseña?</a>
        </p>
        <p class="text-center mt-4 text-sm text-gray-600">
            ¿No tienes cuenta? <a href="/registro" class="text-blue-600 font-semibold">Regístrate</a>
        </p>
    </div>
</div>
@endsection
