@extends('layouts.app')

@section('title', 'Recuperar contraseña — SFM')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-6">
    <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-bold text-center mb-2">Recuperar contraseña</h1>
        <p class="text-gray-600 text-sm text-center mb-8">Te enviaremos un enlace a tu correo.</p>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
        @endif

        <form action="/olvide-contrasena" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-2 font-medium">Correo electrónico</label>
                <input name="email" type="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3">
                @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                Enviar enlace
            </button>
        </form>

        <p class="text-center mt-6 text-sm">
            <a href="/login" class="text-blue-600 font-semibold">Volver al inicio de sesión</a>
        </p>
    </div>
</div>
@endsection
