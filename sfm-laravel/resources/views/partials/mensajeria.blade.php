@props([
    'mensajes',
    'postUrl',
    'deleteUrl' => null,
    'destinatarios' => collect(),
    'profesionales' => collect(),
    'esCliente' => false,
    'profesionalId' => null,
    'mensajesNoLeidos' => 0,
])

<div class="grid lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1">
        <div class="bg-white border rounded-xl p-6 shadow-sm sticky top-24">
            <h2 class="font-bold text-lg mb-1">
                @if ($esCliente) Contactar / Nuevo mensaje @else Nuevo mensaje @endif
            </h2>
            <p class="text-xs text-gray-500 mb-4">
                @if ($esCliente) Envía una solicitud de servicio al profesional. @else Inicia una conversación. @endif
            </p>
            <form action="{{ $postUrl }}" method="POST" class="space-y-3">
                @csrf
                @if ($esCliente)
                    <select name="profesional_id" required class="w-full border rounded-lg px-3 py-2 text-sm">
                        <option value="">Profesional...</option>
                        @foreach ($profesionales as $p)
                            @if ($p->user_id)
                                <option value="{{ $p->id }}" @selected(old('profesional_id', $profesionalId) == $p->id)>
                                    {{ $p->nombre }} — {{ $p->nombre_categoria }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <input type="text" name="asunto" placeholder="Asunto (opcional)" value="{{ old('asunto', 'Solicitud de servicio') }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm">
                @else
                    <select name="destinatario_id" required class="w-full border rounded-lg px-3 py-2 text-sm">
                        <option value="">Destinatario...</option>
                        @foreach ($destinatarios as $d)
                            <option value="{{ $d->id }}" @selected(old('destinatario_id') == $d->id)>
                                {{ $d->name }} ({{ $d->tipo_usuario }})
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="asunto" required placeholder="Asunto" value="{{ old('asunto') }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm">
                @endif
                <textarea name="cuerpo" rows="4" required placeholder="Describe qué necesitas o escribe tu mensaje..."
                    class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('cuerpo') }}</textarea>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700">
                    Enviar
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-4">
        @forelse ($mensajes as $m)
            @php
                $yo = auth()->id();
                $otro = $m->remitente_id === $yo ? $m->destinatario : $m->remitente;
                $soyDestinatario = $m->destinatario_id === $yo;
            @endphp
            <div class="bg-white border rounded-xl p-5 shadow-sm {{ $m->tipo === 'advertencia' ? 'border-amber-300 bg-amber-50' : '' }} {{ $soyDestinatario && ! $m->leido ? 'border-blue-400 ring-1 ring-blue-200' : '' }}">
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

                <div class="mt-3 flex flex-wrap items-center gap-4">
                    @if ($deleteUrl)
                        <form action="{{ $deleteUrl }}/{{ $m->id }}" method="POST" onsubmit="return confirm('¿Eliminar este mensaje?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 text-sm font-semibold hover:underline">🗑 Eliminar</button>
                        </form>
                    @endif

                <details class="flex-1 min-w-[200px]">
                    <summary class="text-sm text-blue-600 cursor-pointer hover:underline inline">Responder a {{ $otro->name }}</summary>
                    <form action="{{ $postUrl }}" method="POST" class="mt-3 space-y-2 border-t pt-3">
                        @csrf
                        @if ($esCliente)
                            <input type="hidden" name="destinatario_id" value="{{ $otro->id }}">
                            @if ($m->profesional_id)
                                <input type="hidden" name="profesional_id" value="{{ $m->profesional_id }}">
                            @endif
                        @else
                            <input type="hidden" name="destinatario_id" value="{{ $otro->id }}">
                            @if ($m->profesional_id)
                                <input type="hidden" name="profesional_id" value="{{ $m->profesional_id }}">
                            @endif
                        @endif
                        <input type="text" name="asunto" required value="Re: {{ $m->asunto }}"
                            class="w-full border rounded-lg px-3 py-2 text-sm">
                        <textarea name="cuerpo" rows="3" required placeholder="Tu respuesta..."
                            class="w-full border rounded-lg px-3 py-2 text-sm"></textarea>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-1.5 rounded-lg text-sm font-semibold">Enviar respuesta</button>
                    </form>
                </details>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-12 bg-white border rounded-xl">No hay mensajes. Usa el formulario para contactar a un profesional.</p>
        @endforelse
    </div>
</div>
