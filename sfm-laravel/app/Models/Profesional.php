<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profesional extends Model
{
    protected $table = 'profesionales';

    protected $fillable = [
        'user_id',
        'nombre',
        'especialidad',
        'precio_estimado',
        'precio_min',
        'precio_max',
        'descripcion',
        'categoria_id',
        'telefono',
        'ciudad',
        'experiencia',
        'modalidad',
        'disponibilidad',
        'foto',
        'calificacion',
        'zona',
    ];

    protected $appends = ['nombre_categoria', 'descripcion_servicio', 'id_profesional'];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resenas(): HasMany
    {
        return $this->hasMany(Resena::class);
    }

    public function contactos(): HasMany
    {
        return $this->hasMany(Contacto::class);
    }

    public function serviciosAdquiridos(): HasMany
    {
        return $this->hasMany(ServicioAdquirido::class);
    }

    public function getFotoUrlAttribute(): string
    {
        if (! $this->foto) {
            return 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';
        }

        if (str_starts_with($this->foto, 'http')) {
            return $this->foto;
        }

        return asset('storage/'.$this->foto);
    }

    public function getRangoPrecioAttribute(): string
    {
        $min = $this->precio_min ?? $this->precio_estimado;
        $max = $this->precio_max ?? $this->precio_estimado;

        if ($min && $max && (float) $min !== (float) $max) {
            return '$'.number_format((float) $min, 0).' - $'.number_format((float) $max, 0);
        }

        $valor = $min ?? $max ?? 0;

        return '$'.number_format((float) $valor, 0);
    }

    public function getNombreCategoriaAttribute(): ?string
    {
        return $this->categoria?->nombre_categoria;
    }

    public function getDescripcionServicioAttribute(): ?string
    {
        return $this->descripcion;
    }

    public function getIdProfesionalAttribute(): int
    {
        return $this->id;
    }

    public function actualizarCalificacion(): void
    {
        $promedio = $this->resenas()->avg('calificacion');
        $this->update(['calificacion' => round($promedio ?? 0, 2)]);
    }

    public function scopeEnSanMiguel($query)
    {
        return $query->where('ciudad', 'San Miguel');
    }
}
