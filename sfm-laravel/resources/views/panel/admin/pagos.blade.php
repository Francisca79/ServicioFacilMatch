@extends('layouts.panel')

@section('title', 'Pagos — Admin')

@section('content')
<div class="space-y-6">
    <div>
        <a href="/panel/admin" class="text-blue-600 text-sm hover:underline">← Panel admin</a>
        <h1 class="text-3xl font-bold mt-2">Pagos de servicios (efectivo)</h1>
        <p class="text-gray-600 mt-1">Solo se registran cobros confirmados por el profesional.</p>
    </div>

    <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">Cliente</th>
                    <th class="px-4 py-3 text-left">Profesional</th>
                    <th class="px-4 py-3 text-left">Solicitud</th>
                    <th class="px-4 py-3 text-left">Prof. confirmó cobro</th>
                    <th class="px-4 py-3 text-left">Monto</th>
                    <th class="px-4 py-3 text-left">Fecha cobro</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pagos as $p)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <a href="/panel/admin/clientes/{{ $p->user_id }}" class="text-blue-600 hover:underline">{{ $p->cliente->name ?? '—' }}</a>
                        </td>
                        <td class="px-4 py-3">
                            <a href="/panel/admin/profesionales/{{ $p->profesional_id }}" class="text-blue-600 hover:underline">{{ $p->profesional->nombre ?? '—' }}</a>
                        </td>
                        <td class="px-4 py-3 capitalize">{{ $p->estado_solicitud }}</td>
                        <td class="px-4 py-3">{{ $p->profesional_confirmo_cobro ? '✓ Sí' : '— Pendiente' }}</td>
                        <td class="px-4 py-3 font-medium">
                            @if ($p->profesional_confirmo_cobro)
                                ${{ number_format($p->monto_pagado, 0) }}
                            @else
                                <span class="text-amber-600">Pendiente</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $p->fecha_cobro?->format('d/m/Y H:i') ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Sin registros de pago.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
