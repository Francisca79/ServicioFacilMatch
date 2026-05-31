<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Servicio Fácil Match')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 min-h-screen flex flex-col">
    @include('partials.navbar')

    @if (session('success'))
        <div class="bg-green-100 text-green-800 text-center py-3 px-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex-1">
        @yield('content')
    </div>

    @include('partials.footer')
</body>
</html>
