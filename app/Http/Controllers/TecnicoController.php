<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TecnicoController extends Controller
{
    /**
     * Lista los técnicos del taller del admin autenticado.
     */
    public function index()
    {
        $this->soloAdmin();

        $tecnicos = User::where('taller_id', auth()->user()->taller_id)
            ->where('rol', 'tecnico')
            ->withCount([
                'reparaciones as ordenes_activas' => fn($q) => $q->whereNotIn('estado', ['Entregado', 'Cancelado']),
                'reparaciones as ordenes_total',
            ])
            ->orderBy('name')
            ->get();

        return view('tecnicos.index', compact('tecnicos'));
    }

    /**
     * Formulario para crear un nuevo técnico.
     */
    public function create()
    {
        $this->soloAdmin();
        return view('tecnicos.create');
    }

    /**
     * Guarda el nuevo técnico asociado al taller del admin.
     */
    public function store(Request $request)
    {
        $this->soloAdmin();

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ]);

        User::create([
            'taller_id' => auth()->user()->taller_id,
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
