<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Panel — SFM')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100 text-gray-900 min-h-screen">

    @include('partials.navbar')



    @if (session('success'))

        <div class="bg-green-100 text-green-800 text-center py-3 px-6">{{ session('success') }}</div>

    @endif

    @if ($errors->any())

        <div class="bg-red-100 text-red-800 text-center py-3 px-6">{{ $errors->first() }}</div>

    @endif



    <main class="max-w-7xl mx-auto px-4 py-8">

        @yield('content')

    </main>

</body>

</html>

