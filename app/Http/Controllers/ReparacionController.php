<?php

namespace App\Http\Controllers;

use App\Mail\ReparacionListaMail;
use App\Models\Cliente;
use App\Models\Escalamiento;
use App\Models\NivelReparacion;
use App\Models\Reparacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReparacionController extends Controller
{
    public function index()
    {
        $tallerId = auth()->user()->taller_id;

        $reparaciones = Reparacion::delTaller($tallerId)
            ->activas()
            ->with(['cliente', 'tecnico', 'nivel'])
            ->latest()
            ->paginate(20);

        return view('reparaciones.index', compact('reparaciones'));
    }

    public function create()
    {
        $tallerId = auth()->user()->taller_id;

        $niveles  = NivelReparacion::orderBy('nivel')->get();
        $clientes = Cliente::where('taller_id', $tallerId)->orderBy('nombre')->get();
        $tecnicos = User::where('taller_id', $tallerId)->orderBy('name')->get();

        return view('reparaciones.create', compact('niveles', 'clientes', 'tecnicos'));
    }

    public function store(Request $request)
    {
        $tallerId = auth()->user()->taller_id;

        $data = $request->validate([
            // Cliente
            'cliente_id'        => ['nullable', 'exists:clientes,id'],
            'cliente_nombre'    => ['required_without:cliente_id', 'string', 'max:255'],
            'cliente_email'     => ['nullable', 'email', 'max:255'],
            'cliente_telefono'  => ['nullable', 'string', 'max:20'],
            // Dispositivo
            'tipo_equipo'       => ['required', 'string', 'max:100'],
            'marca'             => ['required', 'string', 'max:100'],
            'modelo'            => ['required', 'string', 'max:100'],
            'numero_serie'      => ['nullable', 'string', 'max:100'],
            // Reparación
            'nivel_id'          => ['required', 'exists:niveles_reparacion,id'],
            'user_id'           => ['nullable', 'exists:users,id'],
            'problema_reportado' => ['required', 'string'],
            'costo_estimado'    => ['nullable', 'numeric', 'min:0'],
        ]);

        // Resolver o crear el cliente
        if (!empty($data['cliente_id'])) {
            $cliente = Cliente::findOrFail($data['cliente_id']);
        } else {
            $cliente = Cliente::create([
                'taller_id' => $tallerId,
                'nombre'    => $data['cliente_nombre'],
                'email'     => $data['cliente_email'] ?? null,
                'telefono'  => $data['cliente_telefono'] ?? null,
            ]);
        }

        // Calcular hora_limite según el SLA del nivel
        $nivel      = NivelReparacion::findOrFail($data['nivel_id']);
        $horaIngreso = now();
        $horaLimite  = now()->addHours($nivel->horas_sla);

        $reparacion = Reparacion::create([
            'taller_id'          => $tallerId,
            'cliente_id'         => $cliente->id,
            'user_id'            => $data['user_id'] ?? null,
            'nivel_id'           => $nivel->id,
            'folio'              => Reparacion::generarFolio($tallerId),
            'token_seguimiento'  => Reparacion::generarToken(),
            'tipo_equipo'        => $data['tipo_equipo'],
            'marca'              => $data['marca'],
            'modelo'             => $data['modelo'],
            'numero_serie'       => $data['numero_serie'] ?? null,
            'problema_reportado' => $data['problema_reportado'],
            'costo_estimado'     => $data['costo_estimado'] ?? null,
            'estado'             => 'Recibido',
            'hora_ingreso'       => $horaIngreso,
            'hora_limite'        => $horaLimite,
        ]);

        return redirect()->route('reparaciones.show', $reparacion)
                         ->with('success', "Orden {$reparacion->folio} creada correctamente.");
    }

    public function show(Reparacion $reparacion)
    {
        $this->autorizarTaller($reparacion);

        $reparacion->load(['cliente', 'tecnico', 'nivel', 'mensajes.user', 'escalamientos.nivelAnterior', 'escalamientos.nivelNuevo', 'escalamientos.user']);

        $niveles  = NivelReparacion::orderBy('nivel')->get();
        $tecnicos = User::where('taller_id', auth()->user()->taller_id)->orderBy('name')->get();

        return view('reparaciones.show', compact('reparacion', 'niveles', 'tecnicos'));
    }

    public function update(Request $request, Reparacion $reparacion)
    {
        $this->autorizarTaller($reparacion);

        $data = $request->validate([
            'estado'              => ['sometimes', 'in:Recibido,En Revisión,Esperando Pieza,Reparado,Entregado,Cancelado'],
            'diagnostico_tecnico' => ['sometimes', 'nullable', 'string'],
            'comentario_retardo'  => ['sometimes', 'nullable', 'string'],
            'costo_final'         => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'user_id'             => ['sometimes', 'nullable', 'exists:users,id'],
        ]);

        $estadoAnterior = $reparacion->estado;
        $reparacion->update($data);

        // Si se marca como Reparado: registrar hora_fin y enviar email al cliente
        if (isset($data['estado']) && $data['estado'] === 'Reparado' && $estadoAnterior !== 'Reparado') {
            $reparacion->update(['hora_fin' => now()]);

            if ($reparacion->cliente->email) {
                Mail::to($reparacion->cliente->email)
                    ->send(new ReparacionListaMail($reparacion));
            }
        }

        return redirect()->route('reparaciones.show', $reparacion)
                         ->with('success', 'Orden actualizada correctamente.');
    }

    public function escalar(Request $request, Reparacion $reparacion)
    {
        $this->autorizarTaller($reparacion);

        $data = $request->validate([
            'nivel_nuevo_id' => ['required', 'exists:niveles_reparacion,id', 'different:' . $reparacion->nivel_id],
            'motivo'         => ['required', 'string', 'min:10'],
        ]);

        $nivelAnteriorId = $reparacion->nivel_id;
        $nivelNuevo      = NivelReparacion::findOrFail($data['nivel_nuevo_id']);

        // Registrar el escalamiento
        Escalamiento::create([
            'reparacion_id'    => $reparacion->id,
            'user_id'          => auth()->id(),
            'nivel_anterior_id' => $nivelAnteriorId,
            'nivel_nuevo_id'   => $nivelNuevo->id,
            'motivo'           => $data['motivo'],
        ]);

        // Actualizar nivel y recalcular hora_limite
        $reparacion->update([
            'nivel_id'    => $nivelNuevo->id,
            'hora_limite' => $reparacion->hora_ingreso->addHours($nivelNuevo->horas_sla),
        ]);

        return redirect()->route('reparaciones.show', $reparacion)
                         ->with('success', "Nivel escalado a {$nivelNuevo->nombre}. Tiempo límite recalculado.");
    }

    // ─── Helper privado ───────────────────────────────────────

    private function autorizarTaller(Reparacion $reparacion): void
    {
        abort_if((int) $reparacion->taller_id !== (int) auth()->user()->taller_id, 403);
    }
}
