<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class SaludoController extends Controller
{
    public function index()
    {
        return response()->json([
            'mensaje' => 'Bienvenido a la API de Servicio Fácil Match',
            'version' => '1.0',
        ]);
    }
}
