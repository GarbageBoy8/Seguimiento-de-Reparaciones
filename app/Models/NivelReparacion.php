<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelReparacion extends Model
{
    protected $table = 'niveles_reparacion';

    protected $fillable = [
        'nivel',
        'nombre',
        'descripcion',
        'horas_sla',
    ];

    public function reparaciones()
    {
        return $this->hasMany(Reparacion::class, 'nivel_id');
    }
}
