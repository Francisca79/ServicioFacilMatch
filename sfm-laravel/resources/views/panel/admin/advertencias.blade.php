@extends('layouts.panel')

@section('title', 'Advertencias — Admin')

@section('content')
<div class="space-y-6">
    <div>
        <a href="/panel/admin" class="text-blue-600 text-sm hover:underline">← Panel admin</a>
        <h1 class="text-3xl font-bold mt-2">Advertencias enviadas</h1>
        <p class="text-gray-600 mt-1">{{ $advertencias->count() }} advertencias en el sistema</p>
    </div>

    @forelse ($advertencias as $a)
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 shadow-sm">
            <div class="flex flex-wrap justify-between gap-2 text-sm">
                <p>
                    <span class="font-semibold">{{ $a->remitente->name ?? 'Admin' }}</span> →
                    <a href="{{ $a->destinatario->tipo_usuario === 'cliente' ? '/panel/admin/clientes/'.$a->destinatario_id : ($a->destinatario->profesional ? '/panel/admin/profesionales/'.$a->destinatario->profesional->id : '#') }}"
                        class="font-semibold text-blue-600 hover:underline">{{ $a->destinatario->name }}</a>
                </p>
                <span class="text-gray-400">{{ $a->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <p class="font-bold mt-2">{{ $a->asunto }}</p>
            @if ($a->profesional)
                <p class="text-xs text-blue-600">Ref: {{ $a->profesional->nombre }}</p>
            @endif
            <p class="text-gray-700 mt-2 whitespace-pre-wrap">{{ $a->cuerpo }}</p>
        </div>
    @empty
        <p class="text-gray-500 bg-white border rounded-xl p-8 text-center">No se han enviado advertencias.</p>
    @endforelse
</div>
@endsection
