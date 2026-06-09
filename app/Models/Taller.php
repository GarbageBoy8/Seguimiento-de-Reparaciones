<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Taller extends Model
{
    protected $table = 'talleres';

    protected $fillable = [
        'nombre',
        'telefono',
        'direccion',
        'suscripcion_activa',
        'plan_id',
        'codigo_publico',
        'trial_ends_at',
        'subscription_status',
        'subscription_ends_at',
    ];

    protected $casts = [
        'suscripcion_activa' => 'boolean',
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    public function reparaciones()
    {
        return $this->hasMany(Reparacion::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function permiteClientesMayoristas(): bool
    {
        return (bool) $this->plan?->permite_clientes_mayoristas;
    }

    public function maxTecnicos(): int
    {
        return (int) ($this->plan?->max_tecnicos ?? 0);
    }

    public function tecnicosCount(): int
    {
        return $this->users()->where('rol', 'tecnico')->count();
    }

    public function puedeCrearTecnicos(): bool
    {
        return $this->tecnicosCount() < $this->maxTecnicos();
    }

    public function suscripcionEstaActiva(): bool
    {
        if ($this->subscription_status === 'trial') {
            return $this->trial_ends_at !== null && now()->lte($this->trial_ends_at);
        }

        if ($this->subscription_status === 'active') {
            return $this->subscription_ends_at === null || now()->lte($this->subscription_ends_at);
        }

        return false;
    }

    public static function normalizarCodigoPublico(?string $codigo): string
    {
        $codigo = Str::ascii($codigo ?? '');
        $codigo = preg_replace('/[^A-Za-z0-9]/', '', $codigo) ?? '';

        return substr(strtoupper($codigo), 0, 10);
    }

    public static function generarCodigoPublico(string $nombre): string
    {
        $base = substr(self::normalizarCodigoPublico($nombre), 0, 4);
        $base = str_pad($base !== '' ? $base : 'TALL', 3, 'X');
        $codigo = $base;
        $contador = 2;

        while (self::where('codigo_publico', $codigo)->exists()) {
            $sufijo = (string) $contador;
            $codigo = substr($base, 0, 10 - strlen($sufijo)) . $sufijo;
            $contador++;
        }

        return $codigo;
    }

    public function admin()
    {
        return $this->hasOne(User::class)->where('rol', 'admin');
    }
}
