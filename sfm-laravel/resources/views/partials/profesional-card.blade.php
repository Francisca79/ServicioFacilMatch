@props(['profesional', 'puedeContratar' => false, 'linkPerfil' => true])

<div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition">
    <div class="flex items-center gap-4">
        <img src="{{ $profesional->foto_url }}" alt="{{ $profesional->nombre }}"
            class="w-16 h-16 rounded-full object-cover border">
        <div class="flex-1 min-w-0">
            @if ($linkPerfil)
                <a href="/profesionales/{{ $profesional->id }}" class="font-bold text-lg text-gray-900 hover:text-blue-600">
                    {{ $profesional->nombre }}
                </a>
            @else
                <h3 class="font-bold text-lg text-gray-900">{{ $profesional->nombre }}</h3>
            @endif
            <p class="text-sm text-gray-600">{{ $profesional->nombre_categoria }} · {{ $profesional->especialidad }}</p>
            <p class="text-yellow-500 text-sm mt-1">⭐ {{ number_format($profesional->calificacion, 1) }}</p>
        </div>
    </div>
    <p class="text-gray-600 text-sm mt-4 line-clamp-2">{{ Str::limit($profesional->descripcion, 120) }}</p>
    <div class="mt-4 flex items-center justify-between">
        <p class="text-blue-600 font-bold">{{ $profesional->rango_precio }}</p>
        @if ($puedeContratar)
            <a href="/panel/cliente/mensajes?profesional={{ $profesional->id }}"
                class="text-sm bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Contactar</a>
        @elseif (auth()->check() && auth()->user()->isAdmin())
            <a href="/panel/admin/profesionales/{{ $profesional->id }}"
                class="text-sm text-blue-600 hover:underline">Ver perfil →</a>
        @else
            <a href="/profesionales/{{ $profesional->id }}"
                class="text-sm text-blue-600 hover:underline">Ver perfil →</a>
        @endif
    </div>
</div>
