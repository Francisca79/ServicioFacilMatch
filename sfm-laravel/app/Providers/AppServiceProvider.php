<?php

namespace App\Providers;

use App\Models\Mensaje;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('partials.navbar', function ($view) {
            $mensajesNoLeidos = 0;
            $mensajesUrl = null;

            if (Auth::check()) {
                $user = Auth::user();
                if ($user->isCliente() || $user->isProfesional()) {
                    $mensajesNoLeidos = Mensaje::where('destinatario_id', $user->id)
                        ->where('leido', false)
                        ->count();
                    $mensajesUrl = $user->isCliente()
                        ? '/panel/cliente/mensajes'
                        : '/panel/profesional/mensajes';
                }
            }

            $view->with(compact('mensajesNoLeidos', 'mensajesUrl'));
        });
    }
}
