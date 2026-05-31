<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre_categoria',
        'descripcion',
    ];

    public function profesionales(): HasMany
    {
        return $this->hasMany(Profesional::class, 'categoria_id');
    }
}
