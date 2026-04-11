<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $fillable = [
        'reparacion_id',
        'user_id',
        'contenido',
        'es_del_cliente',
    ];

    public function reparacion()
    {
        return $this->belongsTo(Reparacion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
