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
