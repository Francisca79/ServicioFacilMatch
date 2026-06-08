@extends('layouts.panel')

@section('title', 'Reportes — Admin')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold">Reportes y estadísticas</h1>
        <p class="text-gray-600 mt-1">Resumen del estado del sistema SFM. Haz clic en cada recuadro para ver el detalle.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($resumen as $label => $stat)
            <a href="{{ $stat['url'] }}" class="bg-white border rounded-xl p-5 text-center shadow-sm hover:border-blue-400 hover:shadow-md transition block">
                <p class="text-2xl font-bold text-blue-600">{{ $stat['valor'] }}</p>
                <p class="text-sm text-gray-500 capitalize mt-1">{{ str_replace('_', ' ', $label) }}</p>
            </a>
        @endforeach
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white border rounded-xl p-6 shadow-sm">
            <h2 class="font-bold text-lg mb-4">Profesionales por categoría</h2>
            @foreach ($porCategoria as $cat => $total)
                <div class="mb-3">
                    <div class="flex justify-between text-sm mb-1">
                        <span>{{ $cat }}</span>
                        <span class="font-semibold">{{ $total }}</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-600 rounded-full" style="width: {{ $maxCategoria > 0 ? ($total / $maxCategoria * 100) : 0 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white border rounded-xl p-6 shadow-sm">
            <h2 class="font-bold text-lg mb-4">Profesionales por zona (San Miguel)</h2>
            @forelse ($porZona as $zona => $total)
                <div class="mb-3">
                    <div class="flex justify-between text-sm mb-1">
                        <span>{{ $zona }}</span>
                        <span class="font-semibold">{{ $total }}</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-green-600 rounded-full" style="width: {{ $maxZona > 0 ? ($total / $maxZona * 100) : 0 }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Sin datos de zona.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white border rounded-xl p-6 shadow-sm">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold text-lg">Pagos de servicios</h2>
            <a href="/panel/admin/pagos" class="text-blue-600 text-sm hover:underline">Ver detalle →</a>
        </div>
        <div class="grid md:grid-cols-3 gap-4 mb-4">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-green-700">{{ $pagos['pagados'] }}</p>
                <p class="text-sm text-green-800">Pagados</p>
            </div>
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-amber-700">{{ $pagos['pendientes'] }}</p>
                <p class="text-sm text-amber-800">Pendientes</p>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-blue-700">${{ number_format($pagos['total_monto'], 0) }}</p>
                <p class="text-sm text-blue-800">Total recaudado (simulado)</p>
            </div>
        </div>
    </div>

    <div class="bg-white border rounded-xl p-6 shadow-sm">
        <h2 class="font-bold text-lg mb-4">Top profesionales por calificación</h2>
        <table class="w-full text-sm">
            <thead><tr class="border-b"><th class="py-2 text-left">Nombre</th><th class="py-2 text-left">Categoría</th><th class="py-2">Calificación</th><th class="py-2">Reseñas</th></tr></thead>
            <tbody>
                @foreach ($topProfesionales as $p)
                    <tr class="border-b">
                        <td class="py-2"><a href="/panel/admin/profesionales/{{ $p->id }}" class="text-blue-600 hover:underline">{{ $p->nombre }}</a></td>
                        <td class="py-2">{{ $p->categoria->nombre_categoria ?? '—' }}</td>
                        <td class="py-2 text-center">⭐ {{ number_format($p->calificacion, 1) }}</td>
                        <td class="py-2 text-center">{{ $p->resenas_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
