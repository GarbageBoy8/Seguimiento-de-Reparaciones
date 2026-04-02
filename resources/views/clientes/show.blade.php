@extends('plantillas.base')

@section('titulo-pestana', $cliente->nombre)

@section('contenido-principal')

    <article aria-label="Perfil del cliente">
        <h1>{{ $cliente->nombre }}</h1>
        <dl>
            <dt>Teléfono</dt><dd>{{ $cliente->telefono ?? '—' }}</dd>
            <dt>Email</dt><dd>{{ $cliente->email ?? '—' }}</dd>
            <dt>Dirección</dt><dd>{{ $cliente->direccion ?? '—' }}</dd>
        </dl>
        <a href="{{ route('reparaciones.create') }}?cliente_id={{ $cliente->id }}">+ Nueva orden para este cliente</a>
    </article>

    <section aria-label="Historial de reparaciones">
        <h2>Historial de reparaciones</h2>
        <table>
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Equipo</th>
                    <th>Nivel</th>
                    <th>Estado</th>
                    <th>Técnico</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($reparaciones as $orden)
                    <tr>
                        <td>{{ $orden->folio }}</td>
                        <td>{{ $orden->marca }} {{ $orden->modelo }}</td>
                        <td>{{ $orden->nivel->nombre }}</td>
                        <td>{{ $orden->estado }}</td>
                        <td>{{ $orden->tecnico->name ?? '—' }}</td>
                        <td>{{ $orden->created_at->format('d/m/Y') }}</td>
                        <td><a href="{{ route('reparaciones.show', $orden) }}">Ver</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Este cliente no tiene órdenes registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

@endsection
