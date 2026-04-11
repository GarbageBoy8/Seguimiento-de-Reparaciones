<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Reparacion;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $tallerId = auth()->user()->taller_id;

        $clientes = Cliente::where('taller_id', $tallerId)
            ->withCount('reparaciones')
            ->orderBy('nombre')
            ->paginate(20);

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'    => ['required', 'string', 'max:255'],
            'email'     => ['nullable', 'email', 'max:255'],
            'telefono'  => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string', 'max:500'],
        ]);

        $cliente = Cliente::create([
            'taller_id' => auth()->user()->taller_id,
            ...$data,
        ]);

        return redirect()->route('clientes.show', $cliente)
                         ->with('success', 'Cliente registrado correctamente.');
    }

    public function show(Cliente $cliente)
    {
        abort_if((int) $cliente->taller_id !== (int) auth()->user()->taller_id, 403);

        $reparaciones = Reparacion::where('cliente_id', $cliente->id)
            ->with(['nivel', 'tecnico'])
            ->latest()
            ->get();

        return view('clientes.show', compact('cliente', 'reparaciones'));
    }
}
