<div class="bg-white border rounded-xl p-5 shadow-sm {{ $class ?? '' }}">
    <div class="flex justify-between gap-4">
        <div>
            @if ($showProfesional ?? false)
                <p class="font-bold">
                    {{ $r->user->name ?? 'Cliente' }}
                    →
                    <a href="/panel/admin/profesionales/{{ $r->profesional->id }}" class="text-blue-600 hover:underline">
                        {{ $r->profesional->nombre }}
                    </a>
                </p>
                @if ($r->profesional->categoria ?? null)
                    <p class="text-sm text-gray-500">{{ $r->profesional->categoria->nombre_categoria }}</p>
                @endif
            @else
                <p class="font-bold">{{ $r->user->name ?? 'Cliente' }}</p>
            @endif
            <p class="text-xs text-gray-400 mt-1">{{ $r->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <span class="text-yellow-500 shrink-0">{{ str_repeat('⭐', $r->calificacion) }}</span>
    </div>
    <p class="text-gray-700 mt-2">{{ $r->comentario }}</p>
    @include('partials.admin-resena-actions', ['r' => $r])
</div>
