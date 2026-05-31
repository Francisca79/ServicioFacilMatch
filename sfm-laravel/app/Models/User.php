<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'telefono',
        'ciudad',
        'foto',
        'tipo_usuario',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profesional(): HasOne
    {
        return $this->hasOne(Profesional::class);
    }

    public function resenas(): HasMany
    {
        return $this->hasMany(Resena::class);
    }

    public function contactos(): HasMany
    {
        return $this->hasMany(Contacto::class);
    }

    public function mensajesEnviados(): HasMany
    {
        return $this->hasMany(Mensaje::class, 'remitente_id');
    }

    public function mensajesRecibidos(): HasMany
    {
        return $this->hasMany(Mensaje::class, 'destinatario_id');
    }

    public function serviciosAdquiridos(): HasMany
    {
        return $this->hasMany(ServicioAdquirido::class);
    }

    public function resenasClientesRecibidas(): HasMany
    {
        return $this->hasMany(ResenaCliente::class, 'cliente_id');
    }

    public function puedeResenarProfesional(int $profesionalId): bool
    {
        return $this->serviciosAdquiridos()
            ->where('profesional_id', $profesionalId)
            ->where('verificado', true)
            ->exists();
    }

    public function isAdmin(): bool
    {
        return $this->tipo_usuario === 'admin';
    }

    public function isCliente(): bool
    {
        return $this->tipo_usuario === 'cliente';
    }

    public function isProfesional(): bool
    {
        return $this->tipo_usuario === 'profesional';
    }

    public function panelRoute(): string
    {
        return match ($this->tipo_usuario) {
            'admin' => '/panel/admin',
            'profesional' => '/panel/profesional',
            default => '/panel/cliente',
        };
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
}
