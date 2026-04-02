<?php

namespace App\Notifications;

use App\Models\Reparacion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RetardoAdminNotification extends Notification
{
    use Queueable;

    public function __construct(public Reparacion $reparacion) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'reparacion_id'   => $this->reparacion->id,
            'folio'           => $this->reparacion->folio,
            'cliente'         => $this->reparacion->cliente->nombre ?? 'Cliente',
            'equipo'          => "{$this->reparacion->marca} {$this->reparacion->modelo}",
            'tecnico'         => $this->reparacion->tecnico->name ?? 'Sin asignar',
            'nivel'           => $this->reparacion->nivel->nombre ?? '',
            'hora_limite'     => $this->reparacion->hora_limite->toDateTimeString(),
            'mensaje'         => "La orden {$this->reparacion->folio} ha superado su tiempo estimado de entrega.",
        ];
    }
}
