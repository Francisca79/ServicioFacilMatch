@extends('layouts.app')

@section('title', 'Servicio Fácil Match')

@section('content')
<main>
    <section class="bg-blue-50 py-28 text-center px-6">
        <h1 class="text-3xl font-bold mb-4">Servicio Fácil Match</h1>
        <h2 class="text-5xl md:text-6xl font-extrabold text-gray-900 max-w-4xl mx-auto leading-tight">
            Encuentra al Profesional Perfecto para tu Proyecto
        </h2>

        <p class="mt-8 text-xl text-gray-700 max-w-3xl mx-auto">
            Conecta con profesionales calificados, verifica sus reseñas y contrata con confianza.
        </p>

        <form action="/profesionales" method="GET" class="mt-10 bg-white max-w-3xl mx-auto p-5 rounded-xl shadow-lg flex gap-4">
            <input
                type="text"
                name="buscar"
                placeholder="🔍 ¿Qué servicio necesitas? Ej. Plomero, Electricista..."
                class="flex-1 bg-gray-100 px-5 py-4 rounded-lg outline-none"
            />
            <button type="submit" class="bg-gray-950 text-white px-8 rounded-lg font-semibold">
                Buscar
            </button>
        </form>

        <div class="mt-10 flex flex-wrap justify-center gap-12 text-gray-700">
            <p>✅ Miles de profesionales</p>
            <p>✅ Reseñas verificadas</p>
            <p>✅ Respuesta rápida</p>
        </div>
    </section>

    <section class="py-20 px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Categorías Populares</h2>

        <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-5 gap-5">
            @foreach ($categorias as $categoria)
                <a href="/profesionales?categoria={{ urlencode($categoria->nombre_categoria) }}"
                   class="border border-gray-200 rounded-xl p-6 text-center shadow-sm hover:shadow-md transition hover:-translate-y-1">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">⚡</div>
                    <h3 class="font-semibold text-gray-900 text-sm">{{ $categoria->nombre_categoria }}</h3>
                </a>
            @endforeach
        </div>
        <p class="text-center mt-8">
            <a href="/categorias" class="text-blue-600 font-semibold hover:underline">Ver todas las categorías con profesionales →</a>
        </p>
    </section>

    <section class="bg-gray-50 py-20 px-6">
        <h2 class="text-3xl font-bold text-center mb-12">¿Por qué elegir SFM?</h2>

        <div class="max-w-4xl mx-auto grid md:grid-cols-3 gap-8">
            <div class="bg-white border rounded-xl p-10 text-center shadow-sm">
                <div class="text-4xl mb-6">🛡️</div>
                <h3 class="font-bold text-xl mb-4">Profesionales Verificados</h3>
                <p class="text-gray-600">Todos nuestros profesionales pasan por un proceso de verificación.</p>
            </div>
            <div class="bg-white border rounded-xl p-10 text-center shadow-sm">
                <div class="text-4xl mb-6">⭐</div>
                <h3 class="font-bold text-xl mb-4">Reseñas Reales</h3>
                <p class="text-gray-600">Lee opiniones verificadas de clientes antes de contratar.</p>
            </div>
            <div class="bg-white border rounded-xl p-10 text-center shadow-sm">
                <div class="text-4xl mb-6">🕒</div>
                <h3 class="font-bold text-xl mb-4">Respuesta Rápida</h3>
                <p class="text-gray-600">Los profesionales responden en promedio en menos de 2 horas.</p>
            </div>
        </div>
    </section>

    <section class="py-20 text-center px-6">
        <h2 class="text-3xl font-bold mb-12">Cómo funciona</h2>

        <div class="max-w-4xl mx-auto grid md:grid-cols-3 gap-10">
            <div>
                <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 font-bold">1</div>
                <h3 class="font-bold">Busca</h3>
                <p class="text-gray-600 mt-2">Encuentra profesionales por categoría, ubicación o servicio.</p>
            </div>
            <div>
                <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 font-bold">2</div>
                <h3 class="font-bold">Compara</h3>
                <p class="text-gray-600 mt-2">Revisa perfiles, reseñas, calificaciones y precios.</p>
            </div>
            <div>
                <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 font-bold">3</div>
                <h3 class="font-bold">Contrata</h3>
                <p class="text-gray-600 mt-2">Contacta directamente al profesional que mejor se adapte.</p>
            </div>
        </div>
    </section>

    <section class="bg-blue-600 text-white text-center py-16 px-6">
        <h2 class="text-3xl font-bold">¿Eres un Profesional?</h2>
        <p class="mt-4 text-lg">Únete a nuestra plataforma y conecta con más clientes potenciales.</p>
        <a href="/registro" class="inline-block mt-8 bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold">
            Regístrate como Profesional
        </a>
    </section>
</main>
@endsection
