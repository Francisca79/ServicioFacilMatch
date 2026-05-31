<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegistroClienteController extends Controller
{
    public function create()
    {
        return view('registro-cliente');
    }

    public function store(StoreClienteRequest $request)
    {
        $user = User::create([
            'name' => $request->nombre,
            'email' => $request->correo,
            'password' => $request->contrasena,
            'telefono' => $request->telefono,
            'ciudad' => 'San Miguel',
            'tipo_usuario' => 'cliente',
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Cuenta de cliente creada. ¡Bienvenido a SFM!');
    }
}
