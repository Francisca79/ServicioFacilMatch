<?php

namespace App\Http\Controllers;

use App\Models\Categoria;

class HomeController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('nombre_categoria')->get();

        return view('home', compact('categorias'));
    }
}
