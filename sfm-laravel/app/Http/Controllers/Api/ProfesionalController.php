<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profesional;

class ProfesionalController extends Controller
{
    public function index()
    {
        $profesionales = Profesional::with(['categoria', 'resenas'])->get();

        return response()->json($profesionales);
    }

    public function destroy(int $id)
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        Profesional::findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Profesional eliminado.']);
    }
}
