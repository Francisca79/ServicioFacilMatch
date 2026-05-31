<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Profesional;
use App\Models\Resena;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with(['profesionales' => fn ($q) => $q->enSanMiguel()->orderByDesc('calificacion')])->get();
        $puedeContratar = auth()->check() && auth()->user()->isCliente();

        return view('categorias.publico', compact('categorias', 'puedeContratar'));
    }
}
