<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResenaCliente extends Model
{
    protected $table = 'resenas_clientes';

    protected $fillable = [
        'profesional_user_id',
        'cliente_id',
        'calificacion',
        'comentario',
    ];

    public function profesionalUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'profesional_user_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
