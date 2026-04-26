<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use Illuminate\Http\Request;

class PanelTecnicoController extends Controller
{
    public function index()
    {
        $tallerId = auth()->user()->taller_id;

        $stats = [
            'total'       => Reparacion::delTaller($tallerId)->count(),
            'en_proceso'  => Reparacion::delTaller($tallerId)->activas()->count(),
            // Retardos: misma lógica que estaRetrasada() — hora_limite ya pasó y no está terminada
            'retardos'    => Reparacion::delTaller($tallerId)
                                ->whereNotIn('estado', ['Reparado', 'Entregado', 'Cancelado'])
                                ->where('hora_limite', '<', now())
                                ->count(),
            'completadas' => Reparacion::delTaller($tallerId)->where('estado', 'Entregado')->count(),
        ];

        $ordenesActivas = Reparacion::delTaller($tallerId)
            ->activas()
            ->with(['cliente', 'tecnico', 'nivel'])
            ->latest()
            ->take(10)
            ->get();

        $notificaciones = collect();
        if (auth()->user()->esAdmin()) {
            $notificaciones = auth()->user()->unreadNotifications;
        }

        return view('panel-tecnico', compact('stats', 'ordenesActivas', 'notificaciones'));
    }
}