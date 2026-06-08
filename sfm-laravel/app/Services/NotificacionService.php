<?php

namespace App\Services;

use App\Mail\NotificacionSfm;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotificacionService
{
    public static function enviar(User $destinatario, string $asunto, string $mensaje): void
    {
        if (! $destinatario->email) {
            return;
        }

        Mail::to($destinatario->email)->send(new NotificacionSfm($asunto, $mensaje));
    }
}
