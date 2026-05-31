<?php

namespace App\Http\Controllers;

use App\Models\Resena;

class ResenaController extends Controller
{
    public function index()
    {
        $resenas = Resena::with(['user', 'profesional.categoria'])->latest()->get();
        $puedeResenar = auth()->check() && auth()->user()->isCliente();

        return view('resenas.publico', compact('resenas', 'puedeResenar'));
    }
}
