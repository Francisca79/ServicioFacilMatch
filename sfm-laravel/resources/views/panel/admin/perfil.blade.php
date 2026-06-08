@extends('layouts.panel')

@section('title', 'Mi Perfil — Admin')

@section('content')
<div class="max-w-xl">
    <h1 class="text-3xl font-bold mb-8">Mi perfil de administrador</h1>

    <form action="/panel/admin/perfil" method="POST" enctype="multipart/form-data" class="bg-white border rounded-xl p-8 shadow-sm space-y-5">
        @csrf @method('PUT')

        <div class="flex items-center gap-4">
            <img src="{{ $user->foto_url }}" class="w-20 h-20 rounded-full object-cover border" alt="">
            <div>
                <p class="font-bold text-lg">{{ $user->name }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                <p class="text-sm text-blue-600 font-medium">Administrador SFM</p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Nombre</label>
            <input name="name" value="{{ old('name', $user->name) }}" required class="w-full border rounded-lg px-4 py-2">
        </div>
        <div>
            @include('partials.foto-input')
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">Guardar perfil</button>
    </form>
</div>
@endsection
