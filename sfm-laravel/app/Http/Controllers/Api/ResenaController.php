<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PanelResenaRequest;
use App\Models\Profesional;
use App\Models\Resena;
use Illuminate\Support\Facades\Auth;

class ResenaController extends Controller
{
    public function index()
    {
        $resenas = Resena::with(['user', 'profesional.categoria'])
            ->latest()
            ->get();

        return response()->json($resenas);
    }

    public function store(PanelResenaRequest $request)
    {
        $user = Auth::user();

        if (! $user->isCliente()) {
            return response()->json(['message' => 'Solo los clientes pueden publicar reseñas.'], 403);
        }

        if (! $user->puedeResenarProfesional((int) $request->profesional_id)) {
            return response()->json([
                'message' => 'Solo puedes reseñar profesionales cuyo servicio fue verificado por el administrador.',
            ], 422);
        }

        $resena = Resena::create([
            'user_id' => $user->id,
            'profesional_id' => $request->profesional_id,
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
        ]);

        Profesional::find($request->profesional_id)?->actualizarCalificacion();

        return response()->json([
            'success' => true,
            'resena' => $resena->load('user', 'profesional'),
        ], 201);
    }
}
