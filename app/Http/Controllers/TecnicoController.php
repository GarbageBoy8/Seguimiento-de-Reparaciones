<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class TecnicoController extends Controller
{
    /**
     * Lista los técnicos del taller del admin autenticado.
     */
    public function index()
    {
        $this->soloAdmin();
        $taller = auth()->user()->taller()->with('plan')->firstOrFail();

        $tecnicos = User::where('taller_id', $taller->id)
            ->where('rol', 'tecnico')
            ->withCount([
                'reparaciones as ordenes_activas' => fn($q) => $q->whereNotIn('estado', ['Entregado', 'Cancelado']),
                'reparaciones as ordenes_total',
            ])
            ->orderBy('name')
            ->get();

        $maxTecnicos = $taller->maxTecnicos();
        $puedeCrearTecnicos = $tecnicos->count() < $maxTecnicos;

        return view('tecnicos.index', compact('tecnicos', 'maxTecnicos', 'puedeCrearTecnicos'));
    }

    /**
     * Formulario para crear un nuevo técnico.
     */
    public function create()
    {
        $this->soloAdmin();
        $taller = auth()->user()->taller()->with('plan')->firstOrFail();
        $tecnicosActuales = $taller->tecnicosCount();
        $maxTecnicos = $taller->maxTecnicos();
        $puedeCrearTecnicos = $tecnicosActuales < $maxTecnicos;

        return view('tecnicos.create', compact('tecnicosActuales', 'maxTecnicos', 'puedeCrearTecnicos'));
    }

    /**
     * Guarda el nuevo técnico asociado al taller del admin.
     */
    public function store(Request $request)
    {
        $this->soloAdmin();
        $taller = auth()->user()->taller()->with('plan')->firstOrFail();

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ]);

        if (! $taller->puedeCrearTecnicos()) {
            throw ValidationException::withMessages([
                'name' => "Tu plan actual permite hasta {$taller->maxTecnicos()} técnicos. Actualiza tu suscripción para agregar más.",
            ]);
        }

        User::create([
            'taller_id' => $taller->id,
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'rol'       => 'tecnico',
        ]);

        return redirect()->route('tecnicos.index')
            ->with('success', "Técnico {$data['name']} creado correctamente.");
    }

    /**
     * Elimina (desactiva) un técnico del taller.
     */
    public function destroy(User $tecnico)
    {
        $this->soloAdmin();
        abort_if((int) $tecnico->taller_id !== (int) auth()->user()->taller_id, 403);
        abort_if($tecnico->rol !== 'tecnico', 403, 'No puedes eliminar a un administrador.');

        $tecnico->delete();

        return redirect()->route('tecnicos.index')
            ->with('success', 'Técnico eliminado del taller.');
    }

    // ─── Guard interno ─────────────────────────────────────────

    private function soloAdmin(): void
    {
        abort_unless(auth()->user()?->esAdmin(), 403, 'Solo los administradores pueden acceder a esta sección.');
    }
}
