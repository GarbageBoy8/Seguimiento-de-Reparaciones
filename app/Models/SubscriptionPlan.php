<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $table = 'subscription_plans';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'precio_mensual',
        'max_tecnicos',
        'permite_clientes_mayoristas',
        'features',
        'activo',
    ];

    protected $casts = [
        'precio_mensual' => 'decimal:2',
        'max_tecnicos' => 'integer',
        'permite_clientes_mayoristas' => 'boolean',
        'features' => 'array',
        'activo' => 'boolean',
    ];

    public function talleres()
    {
        return $this->hasMany(Taller::class, 'plan_id');
    }
}
