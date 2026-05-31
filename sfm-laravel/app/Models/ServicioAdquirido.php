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
        'notas',
    ];

    protected function casts(): array
    {
        return ['verificado' => 'boolean'];
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
}
