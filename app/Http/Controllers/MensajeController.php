<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use App\Models\Mensaje;
use Illuminate\Http\Request;

class MensajeController extends Controller
{
    /**
     * Devuelve los mensajes de una orden en JSON (para polling del chat).
     */
    public function index(Reparacion $reparacion)
    {
        abort_if((int) $reparacion->taller_id !== (int) auth()->user()->taller_id, 403);

        $mensajes = $reparacion->mensajes()
            ->with('user:id,name,rol')
            ->get()
            ->map(fn($m) => [
                'id'             => $m->id,
                'contenido'      => $m->contenido,
                'es_del_cliente' => $m->es_del_cliente,
                'autor'          => $m->es_del_cliente ? 'Cliente' : ($m->user->name ?? 'Sistema'),
                'fecha'          => $m->created_at->format('d/m H:i'),
            ]);

        return response()->json($mensajes);
    }

    /**
     * Guarda un mensaje enviado por el técnico/admin.
     */
    public function store(Request $request, Reparacion $reparacion)
    {
        abort_if((int) $reparacion->taller_id !== (int) auth()->user()->taller_id, 403);

        $data = $request->validate([
            'contenido' => ['required', 'string', 'max:1000'],
        ]);

        Mensaje::create([
            'reparacion_id'  => $reparacion->id,
            'user_id'        => auth()->id(),
            'contenido'      => $data['contenido'],
            'es_del_cliente' => false,
        ]);

        return response()->json(['ok' => true]);
    }
}
