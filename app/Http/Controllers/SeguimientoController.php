<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Reparacion;
use Illuminate\Http\Request;

class SeguimientoController extends Controller
{
    /**
     * Portal público del cliente — solo con el token.
     */
    public function show(string $token)
    {
        $reparacion = Reparacion::where('token_seguimiento', $token)
            ->with(['cliente', 'tecnico', 'nivel', 'mensajes.user'])
            ->firstOrFail();

        return view('seguimiento.show', compact('reparacion'));
    }

    /**
     * El cliente envía un mensaje desde el portal.
     */
    public function mensaje(Request $request, string $token)
    {
        $reparacion = Reparacion::where('token_seguimiento', $token)->firstOrFail();

        $data = $request->validate([
            'contenido' => ['required', 'string', 'max:1000'],
        ]);

        Mensaje::create([
            'reparacion_id'  => $reparacion->id,
            'user_id'        => null,
            'contenido'      => $data['contenido'],
            'es_del_cliente' => true,
        ]);

        return redirect()->route('seguimiento.show', $token)
                         ->with('success', 'Mensaje enviado correctamente.');
    }

    /**
     * Polling JSON de mensajes para el portal del cliente.
     */
    public function mensajesJson(string $token)
    {
        $reparacion = Reparacion::where('token_seguimiento', $token)->firstOrFail();

        $mensajes = $reparacion->mensajes()
            ->with('user:id,name')
            ->get()
            ->map(fn($m) => [
                'id'             => $m->id,
                'contenido'      => $m->contenido,
                'es_del_cliente' => $m->es_del_cliente,
                'autor'          => $m->es_del_cliente ? 'Tú' : ($m->user->name ?? 'Taller'),
                'fecha'          => $m->created_at->format('d/m H:i'),
            ]);

        return response()->json($mensajes);
    }
}
