<?php

namespace App\Jobs;

use App\Models\Reparacion;
use App\Models\User;
use App\Notifications\RetardoAdminNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class VerificarRetardosJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        // Buscar órdenes activas cuya hora_limite ya pasó
        $ordenesRetrasadas = Reparacion::activas()
            ->whereNotIn('estado', ['Retardo'])
            ->where('hora_limite', '<', now())
            ->with(['taller', 'cliente', 'tecnico', 'nivel'])
            ->get();

        foreach ($ordenesRetrasadas as $reparacion) {
            // 1. Cambiar estado a Retardo
            $reparacion->update(['estado' => 'Retardo']);

            // 2. Buscar el admin del mismo taller
            $admin = User::where('taller_id', $reparacion->taller_id)
                         ->where('rol', 'admin')
                         ->first();

            // 3. Notificar al admin
            if ($admin) {
                $admin->notify(new RetardoAdminNotification($reparacion));
            }
        }
    }
}
