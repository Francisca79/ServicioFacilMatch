<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->correo,
            'password' => $request->contrasena,
        ];

        if (Auth::attempt($credentials, $request->boolean('recordar'))) {
            $request->session()->regenerate();

            return redirect()->intended('/')->with('success', 'Inicio de sesión correcto.');
        }

        return back()->withErrors([
            'correo' => 'Correo o contraseña incorrectos.',
        ])->onlyInput('correo');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }
}
