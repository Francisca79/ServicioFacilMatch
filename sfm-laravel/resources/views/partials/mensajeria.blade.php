@props([
    'conversaciones',
    'postUrl',
    'deleteUrl' => null,
    'destinatarios' => collect(),
    'profesionales' => collect(),
    'esCliente' => false,
    'profesionalId' => null,
    'mensajesNoLeidos' => 0,
    'serviciosPorConversacion' => collect(),
])

<div class="grid lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1">
        <div class="bg-white border rounded-xl p-6 shadow-sm sticky top-24">
            <h2 class="font-bold text-lg mb-1">
                @if ($esCliente) Nueva solicitud de servicio @else Nuevo mensaje @endif
            </h2>
            <p class="text-xs text-gray-500 mb-4">
                @if ($esCliente)
                    Para chatear con un profesional primero envía una solicitud. Si fue rechazada, vuelve a solicitar aquí.
                @else
                    Solo puedes chatear con clientes cuya solicitud ya aceptaste.
                @endif
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
                <textarea name="cuerpo" rows="4" required placeholder="Describe qué necesitas..."
                    class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('cuerpo') }}</textarea>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700">
                    @if ($esCliente) Enviar solicitud @else Enviar @endif
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        @forelse ($conversaciones as $conv)
            @php
                $yo = auth()->id();
                $otro = $conv['otro'];
                $servicio = $serviciosPorConversacion->get($conv['clave']);
                $pendiente = $servicio?->estado_solicitud === 'pendiente';
                $aceptada = $servicio?->estado_solicitud === 'aceptada';
                $rechazada = $servicio?->estado_solicitud === 'denegada';
                $puedeChatear = $servicio?->permiteChat() ?? false;
                $mostrarRespuesta = ! $esCliente && $pendiente && $servicio;
            @endphp
            <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b bg-gray-50 flex flex-wrap justify-between gap-2">
                    <div>
                        <p class="font-bold text-lg">Conversación con {{ $otro->name }}</p>
                        @if ($conv['profesional'])
                            <p class="text-xs text-blue-600">Servicio: {{ $conv['profesional']->nombre }}</p>
                        @endif
                    </div>
                    <span class="text-xs text-gray-400 self-center">{{ $conv['ultimo']->created_at->format('d/m/Y H:i') }}</span>
                </div>

                <div class="p-5 space-y-3 max-h-[28rem] overflow-y-auto">
                    @foreach ($conv['mensajes'] as $m)
                        @php
                            $esMio = $m->remitente_id === $yo;
                            $puedeEliminar = $deleteUrl && $m->tipo !== 'advertencia';
                        @endphp
                        <div class="flex {{ $esMio ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[85%] rounded-xl px-4 py-3 text-sm
                                @if ($m->tipo === 'advertencia') bg-amber-100 border border-amber-300 text-amber-950
                                @elseif ($esMio) bg-blue-600 text-white
                                @else bg-gray-100 text-gray-800 @endif">
                                <div class="flex flex-wrap items-center gap-2 mb-1 text-xs opacity-80">
                                    <span class="font-semibold">{{ $m->remitente->name }}</span>
                                    <span>{{ $m->created_at->format('d/m H:i') }}</span>
                                    @if ($m->tipo === 'advertencia')
                                        <span class="bg-amber-200 text-amber-900 px-1.5 py-0.5 rounded">Advertencia</span>
                                    @elseif ($m->tipo === 'solicitud')
                                        <span class="bg-blue-200 text-blue-900 px-1.5 py-0.5 rounded">Solicitud</span>
                                    @endif
                                </div>
                                @if ($m->asunto && ! str_starts_with($m->asunto, 'Re:'))
                                    <p class="font-bold mb-1">{{ $m->asunto }}</p>
                                @endif
                                <p class="whitespace-pre-wrap">{{ $m->cuerpo }}</p>
                                @if ($puedeEliminar)
                                    <form action="{{ $deleteUrl }}/{{ $m->id }}" method="POST" class="mt-2" onsubmit="return confirm('¿Eliminar este mensaje?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs underline opacity-75 hover:opacity-100">Eliminar</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($servicio)
                    <div class="px-5 py-3 border-t text-sm
                        @if ($aceptada) bg-green-50
                        @elseif ($rechazada) bg-red-50
                        @else bg-gray-50 @endif">
                        <p class="font-semibold">
                            @if ($pendiente) ⏳ Solicitud pendiente de respuesta
                            @elseif ($aceptada) ✓ Solicitud aceptada — chat habilitado
                            @else ✗ Solicitud rechazada @endif
                        </p>

                        @if ($rechazada && $esCliente)
                            <p class="text-red-700 text-xs mt-1">Envía una nueva solicitud desde el formulario de la izquierda para volver a contactar.</p>
                        @endif

                        @if ($mostrarRespuesta)
                            <form action="/panel/profesional/solicitudes/responder" method="POST" class="mt-3 space-y-2">
                                @csrf
                                <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">
                                <label class="text-xs font-semibold text-gray-700">Mensaje al cliente (obligatorio para aceptar o rechazar)</label>
                                <textarea name="mensaje" rows="2" required minlength="10" placeholder="Escribe tu respuesta al cliente..."
                                    class="w-full border rounded-lg px-3 py-2 text-sm"></textarea>
                                <div class="flex flex-wrap gap-2">
                                    <button type="submit" name="accion" value="aceptar"
                                        class="bg-green-600 text-white px-4 py-1.5 rounded-lg text-sm font-semibold hover:bg-green-700">✓ Aceptar</button>
                                    <button type="submit" name="accion" value="rechazar"
                                        class="bg-red-600 text-white px-4 py-1.5 rounded-lg text-sm font-semibold hover:bg-red-700">✗ Rechazar</button>
                                </div>
                            </form>
                        @endif

                        @if ($aceptada)
                            <div class="mt-2 space-y-2">
                                @if ($esCliente)
                                    @if ($servicio->estaPagada())
                                        <p class="text-green-700">💵 El profesional confirmó el cobro — ${{ number_format($servicio->monto_pagado, 0) }}</p>
                                        @if (auth()->user()->puedeResenarProfesional($conv['profesional_id']))
                                            <a href="/panel/cliente/resenas" class="text-blue-600 text-sm hover:underline">→ Publicar reseña</a>
                                        @endif
                                    @else
                                        <p class="text-gray-600 text-xs">Espera a que el profesional confirme el cobro en efectivo para publicar tu reseña.</p>
                                    @endif
                                @else
                                    @if ($servicio->estaPagada())
                                        <p class="text-green-700">💵 Cobro registrado — ${{ number_format($servicio->monto_pagado, 0) }}</p>
                                    @else
                                        <form action="/panel/profesional/pagos/confirmar" method="POST" class="flex flex-wrap gap-2 items-end mt-2">
                                            @csrf
                                            <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">
                                            <div>
                                                <label class="text-xs text-gray-500">Monto recibido ($)</label>
                                                <input type="number" name="monto_pagado" min="1" required
                                                    value="{{ $conv['profesional']->precio_estimado ?? 50 }}"
                                                    class="border rounded px-2 py-1 text-sm w-28">
                                            </div>
                                            <button class="bg-green-600 text-white px-3 py-1.5 rounded text-xs font-semibold">Confirmar cobro en efectivo</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                @endif

                @if ($puedeChatear)
                    <div class="px-5 py-4 border-t bg-gray-50">
                        <form action="{{ $postUrl }}" method="POST" class="space-y-2">
                            @csrf
                            <input type="hidden" name="destinatario_id" value="{{ $otro->id }}">
                            @if ($conv['profesional_id'])
                                <input type="hidden" name="profesional_id" value="{{ $conv['profesional_id'] }}">
                            @endif
                            <input type="hidden" name="asunto" value="Re: {{ $conv['ultimo']->asunto }}">
                            <textarea name="cuerpo" rows="2" required placeholder="Continúa la conversación..."
                                class="w-full border rounded-lg px-3 py-2 text-sm"></textarea>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-1.5 rounded-lg text-sm font-semibold">Enviar mensaje</button>
                        </form>
                    </div>
                @elseif ($pendiente && $esCliente)
                    <div class="px-5 py-3 border-t bg-amber-50 text-xs text-amber-800">
                        Espera la respuesta del profesional. Podrás chatear cuando acepte tu solicitud.
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-500 text-center py-12 bg-white border rounded-xl">No hay conversaciones. Usa el formulario para contactar a un profesional.</p>
        @endforelse
    </div>
</div>
