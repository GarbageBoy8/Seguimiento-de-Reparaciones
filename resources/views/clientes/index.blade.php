@extends('plantillas.base')

@section('titulo-pestana', 'Clientes')

@section('contenido-principal')

    <header>
        <h1>Clientes del taller</h1>
        <a href="{{ route('clientes.create') }}">+ Nuevo cliente</a>
    </header>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Órdenes</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->telefono ?? '—' }}</td>
                    <td>{{ $cliente->email ?? '—' }}</td>
                    <td>{{ $cliente->reparaciones_count }}</td>
                    <td><a href="{{ route('clientes.show', $cliente) }}">Ver historial</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay clientes registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $clientes->links() }}

@endsection
