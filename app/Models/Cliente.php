<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'taller_id',
        'nombre',
        'email',
        'telefono',
        'direccion',
        'es_mayorista', // 1. Agregamos el campo aquí para futuros registros
    ];

    // 2. AGREGA ESTO: Esto obliga a Laravel a transformar el 1 de la base de datos en un "true" real
    protected $casts = [
        'es_mayorista' => 'boolean',
    ];

    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }

    public function reparaciones()
    {
        return $this->hasMany(Reparacion::class);
    }
}