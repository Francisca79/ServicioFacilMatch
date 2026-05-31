<div class="mt-4 pt-4 border-t flex flex-wrap gap-4 items-start">
    <form action="/panel/admin/resenas/{{ $r->id }}" method="POST" onsubmit="return confirm('¿Eliminar reseña?')">
        @csrf @method('DELETE')
        <button class="text-red-600 text-sm font-semibold hover:underline">🗑 Eliminar reseña</button>
    </form>

    @if ($r->user)
        <form action="/panel/admin/advertencia" method="POST" class="flex-1 min-w-[280px] space-y-2 bg-amber-50 rounded-lg p-3">
            @csrf
            <input type="hidden" name="destinatario_id" value="{{ $r->user->id }}">
            <p class="text-xs font-semibold text-amber-900">Enviar advertencia a {{ $r->user->name }}</p>
            <input type="hidden" name="asunto" value="Advertencia sobre tu reseña">
            <textarea name="cuerpo" rows="2" required placeholder="Ej: Tu reseña contiene lenguaje inapropiado..."
                class="w-full border rounded px-3 py-2 text-sm"></textarea>
            <button class="bg-amber-600 text-white text-xs px-3 py-1.5 rounded font-semibold">Enviar advertencia</button>
        </form>
    @endif
</div>
