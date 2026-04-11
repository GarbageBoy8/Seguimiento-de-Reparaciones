<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'taller_id',
        'name',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ─── Helpers ─────────────────────────────────────────────

    public function esAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    public function esTecnico(): bool
    {
        return $this->rol === 'tecnico';
    }

    // ─── Relaciones ──────────────────────────────────────────

    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }

    public function reparaciones()
    {
        return $this->hasMany(Reparacion::class, 'user_id');
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }
}
