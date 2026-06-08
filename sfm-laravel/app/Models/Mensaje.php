<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Mensaje extends Model
{
    protected $fillable = [
        'remitente_id',
        'destinatario_id',
        'profesional_id',
        'asunto',
        'cuerpo',
        'tipo',
        'leido',
    ];

    protected function casts(): array
    {
        return ['leido' => 'boolean'];
    }

    public function remitente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'remitente_id');
    }

    public function destinatario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'destinatario_id');
    }

    public function profesional(): BelongsTo
    {
        return $this->belongsTo(Profesional::class);
    }

    public static function agruparConversaciones(Collection $mensajes, int $userId): Collection
    {
        $grupos = collect();

        foreach ($mensajes as $mensaje) {
            $otroId = $mensaje->remitente_id === $userId
                ? $mensaje->destinatario_id
                : $mensaje->remitente_id;
            $clave = $otroId.'-'.($mensaje->profesional_id ?? 0);

            if (! $grupos->has($clave)) {
                $grupos[$clave] = [
                    'clave' => $clave,
                    'otro' => $mensaje->remitente_id === $userId ? $mensaje->destinatario : $mensaje->remitente,
                    'profesional' => $mensaje->profesional,
                    'profesional_id' => $mensaje->profesional_id,
                    'mensajes' => collect(),
                ];
            }

            $grupos[$clave]['mensajes']->push($mensaje);
        }

        return $grupos->map(function (array $conv) {
            $conv['mensajes'] = $conv['mensajes']->sortBy('created_at')->values();
            $conv['ultimo'] = $conv['mensajes']->last();

            return $conv;
        })->sortByDesc(fn (array $conv) => $conv['ultimo']->created_at)->values();
    }
}
