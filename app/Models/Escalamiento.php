<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escalamiento extends Model
{
    protected $fillable = [
        'reparacion_id',
        'user_id',
        'nivel_anterior_id',
        'nivel_nuevo_id',
        'motivo',
    ];

    public function reparacion()
    {
        return $this->belongsTo(Reparacion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nivelAnterior()
    {
        return $this->belongsTo(NivelReparacion::class, 'nivel_anterior_id');
    }

    public function nivelNuevo()
    {
        return $this->belongsTo(NivelReparacion::class, 'nivel_nuevo_id');
    }
}
