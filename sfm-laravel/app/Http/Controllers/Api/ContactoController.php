<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactoRequest;
use App\Models\Contacto;

class ContactoController extends Controller
{
    public function store(StoreContactoRequest $request)
    {
        $contacto = Contacto::create([
            'user_id' => auth()->id(),
            'profesional_id' => $request->profesional_id,
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'mensaje' => $request->mensaje,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mensaje enviado correctamente.',
            'contacto' => $contacto,
        ], 201);
    }
}
