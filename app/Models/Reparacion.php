<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reparacion extends Model
{
    protected $table = 'reparaciones';
    protected $fillable = [
        'taller_id',
        'cliente_id',
        'user_id',
        'nivel_id',
        'folio',
        'token_seguimiento',
        'tipo_equipo',
        'marca',
        'modelo',
        'numero_serie',
        'problema_reportado',
        'diagnostico_tecnico',
        'comentario_retardo',
        'estado',
        'costo_estimado',
        'costo_final',
        'hora_ingreso',
        'hora_limite',
        'hora_fin',
    ];

    protected $casts = [
        'hora_ingreso' => 'datetime',
        'hora_limite'  => 'datetime',
        'hora_fin'     => 'datetime',
    ];

    // ─── Relaciones ──────────────────────────────────────────

    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function nivel()
    {
        return $this->belongsTo(NivelReparacion::class, 'nivel_id');
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class)->orderBy('created_at');
    }

    public function escalamientos()
    {
        return $this->hasMany(Escalamiento::class)->orderBy('created_at');
    }

    // ─── Scopes ──────────────────────────────────────────────

    /**
     * Filtra las reparaciones por el taller del usuario autenticado.
     */
    public function scopeDelTaller($query, int $tallerId)
    {
        return $query->where('taller_id', $tallerId);
    }

    /**
     * Solo órdenes activas (no entregadas ni canceladas).
     */
    public function scopeActivas($query)
    {
        return $query->whereNotIn('estado', ['Entregado', 'Cancelado']);
    }

    // ─── Accesores / Helpers ─────────────────────────────────

    /**
     * Indica si la orden ya superó su hora límite.
     */
    public function estaRetrasada(): bool
    {
        if (in_array($this->estado, ['Reparado', 'Entregado', 'Cancelado'])) {
            return false;
        }

        return Carbon::now()->isAfter($this->hora_limite);
    }

    /**
     * Retorna el tiempo restante en formato legible.
     * Si ya pasó, retorna un número negativo de horas.
     */
    public function tiempoRestanteHoras(): float
    {
        return round(Carbon::now()->diffInMinutes($this->hora_limite, false) / 60, 1);
    }

    // ─── Generadores estáticos ───────────────────────────────

    /**
     * Genera un folio único: FF-YYYY-XXXX
     */
    public static function generarFolio(int $tallerId): string
    {
        $anio     = now()->year;
        $ultimo   = self::where('taller_id', $tallerId)
                        ->whereYear('created_at', $anio)
                        ->count();
        $numero   = str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);

        return "FF-{$anio}-{$numero}";
    }

    /**
     * Genera un token único para el portal del cliente.
     */
    public static function generarToken(): string
    {
        do {
            $token = Str::random(32);
        } while (self::where('token_seguimiento', $token)->exists());

        return $token;
    }
}
