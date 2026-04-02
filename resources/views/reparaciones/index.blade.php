@extends('plantillas.base')

@section('titulo-pestana', 'Órdenes')

@section('contenido-principal')

    <header>
        <h1>Órdenes de reparación</h1>
        <a href="{{ route('reparaciones.create') }}">+ Nueva orden</a>
    </header>

    @if(session('success'))
        <p role="alert">{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Cliente</th>
                <th>Equipo</th>
                <th>Nivel</th>
                <th>Estado</th>
                <th>Técnico</th>
                <th>Hora límite</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($reparaciones as $orden)
                <tr>
                    <td>{{ $orden->folio }}</td>
                    <td>{{ $orden->cliente->nombre }}</td>
                    <td>{{ $orden->tipo_equipo }} · {{ $orden->marca }} {{ $orden->modelo }}</td>
                    <td>Nivel {{ $orden->nivel->nivel }} — {{ $orden->nivel->nombre }}</td>
                    <td>{{ $orden->estado }}</td>
                    <td>{{ $orden->tecnico->name ?? 'Sin asignar' }}</td>
                    <td>{{ $orden->hora_limite->format('d/m/Y H:i') }}</td>
                    <td><a href="{{ route('reparaciones.show', $orden) }}">Ver</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay órdenes activas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $reparaciones->links() }}

@endsection
