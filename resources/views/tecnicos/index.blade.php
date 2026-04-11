@extends('plantillas.base')

@section('titulo-pestana', 'Técnicos del taller')

@section('contenido-principal')

    <header>
        <h1>Técnicos del taller</h1>
        <a href="{{ route('tecnicos.create') }}">+ Nuevo técnico</a>
    </header>

    @if(session('success'))
        <p role="alert">{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Órdenes activas</th>
                <th>Total histórico</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($tecnicos as $tecnico)
                <tr>
                    <td>{{ $tecnico->name }}</td>
                    <td>{{ $tecnico->email }}</td>
                    <td>{{ $tecnico->ordenes_activas }}</td>
                    <td>{{ $tecnico->ordenes_total }}</td>
                    <td>
                        <form method="POST" action="{{ route('tecnicos.destroy', $tecnico) }}"
                              onsubmit="return confirm('¿Eliminar a {{ $tecnico->name }} del taller?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay técnicos registrados. <a href="{{ route('tecnicos.create') }}">Agregar el primero</a>.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
