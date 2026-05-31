<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Profesional;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with('profesionales')->get();

        return response()->json($categorias);
    }
}
