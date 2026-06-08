@extends('layouts.app')

@section('title', 'Nueva contraseña — SFM')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-6">
    <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-bold text-center mb-8">Nueva contraseña</h1>

        <form action="/restablecer-contrasena" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div>
                <label class="block mb-2 font-medium">Correo electrónico</label>
                <input name="email" type="email" value="{{ old('email', $email) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3">
            </div>
            <div>
                <label class="block mb-2 font-medium">Nueva contraseña</label>
                <input name="password" type="password" required minlength="6"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3">
            </div>
            <div>
                <label class="block mb-2 font-medium">Confirmar contraseña</label>
                <input name="password_confirmation" type="password" required minlength="6"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3">
            </div>
            @error('email')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                Guardar contraseña
            </button>
        </form>
    </div>
</div>
@endsection
