<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicioAdquirido extends Model
{
    protected $table = 'servicios_adquiridos';

    protected $fillable = [
        'user_id',
        'profesional_id',
        'verificado',
        'verificado_por',
        'estado_solicitud',
        'mensaje_id',
        'notas',
        'monto_pagado',
        'estado_pago',
        'cliente_confirmo_pago',
        'profesional_confirmo_cobro',
        'metodo_pago',
        'fecha_cobro',
    ];

    protected function casts(): array
    {
        return [
            'verificado' => 'boolean',
            'cliente_confirmo_pago' => 'boolean',
            'profesional_confirmo_cobro' => 'boolean',
            'fecha_cobro' => 'datetime',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function profesional(): BelongsTo
    {
        return $this->belongsTo(Profesional::class);
    }

    public function verificador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verificado_por');
    }

    public function mensaje(): BelongsTo
    {
        return $this->belongsTo(Mensaje::class);
    }

    public function estaAceptada(): bool
    {
        return $this->estado_solicitud === 'aceptada' && $this->verificado;
    }

    public function estaPagada(): bool
    {
        return $this->estado_pago === 'pagado' && $this->profesional_confirmo_cobro;
    }

    public static function paraConversacion(int $clienteId, int $profesionalId): ?self
    {
        $pendiente = static::where('user_id', $clienteId)
            ->where('profesional_id', $profesionalId)
            ->where('estado_solicitud', 'pendiente')
            ->first();

        return $pendiente ?? static::where('user_id', $clienteId)
            ->where('profesional_id', $profesionalId)
            ->orderByDesc('updated_at')
            ->first();
    }

    public function permiteChat(): bool
    {
        return $this->estado_solicitud === 'aceptada';
    }
}
