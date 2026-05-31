<div class="space-y-4">
    @forelse ($mensajes as $m)
        <div class="bg-white border rounded-xl p-5 shadow-sm {{ $m->tipo === 'advertencia' ? 'border-amber-300 bg-amber-50' : '' }}">
            <div class="flex justify-between text-sm">
                <p>
                    <span class="font-semibold">{{ $m->remitente->name }}</span> →
                    <span class="font-semibold">{{ $m->destinatario->name }}</span>
                    @if ($m->tipo === 'advertencia')
                        <span class="ml-2 text-xs bg-amber-200 text-amber-900 px-2 py-0.5 rounded">Advertencia</span>
                    @elseif ($m->tipo === 'solicitud')
                        <span class="ml-2 text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded">Solicitud</span>
                    @endif
                </p>
                <span class="text-gray-400">{{ $m->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <p class="font-bold mt-2">{{ $m->asunto }}</p>
            @if ($m->profesional)
                <p class="text-xs text-blue-600">Ref: {{ $m->profesional->nombre }}</p>
            @endif
            <p class="text-gray-700 mt-2 whitespace-pre-wrap">{{ $m->cuerpo }}</p>
        </div>
    @empty
        <p class="text-gray-500 text-center py-12">No hay mensajes aún.</p>
    @endforelse
</div>
