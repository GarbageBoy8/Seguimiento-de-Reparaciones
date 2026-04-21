@extends('plantillas.base')

@section('titulo-pestana', 'Centro de Mando')

@section('contenido-principal')

    {{-- Alertas de sesión --}}
    @if(session('success'))
        <p class="text-emerald-800 font-medium" role="alert">{{ session('success') }}</p>
    @endif

    {{-- Notificaciones de retardo (solo admin) --}}
    @if(auth()->user()->esAdmin() && $notificaciones->isNotEmpty())
        <section aria-label="Alertas de retardo" class="mb-8 bg-white rounded-2xl shadow-md border border-amber-200 overflow-hidden">
            <h2>Alertas de retardo ({{ $notificaciones->count() }})</h2>
            <form method="POST" action="{{ route('notificaciones.leer-todas') }}">
                @csrf
                <button type="submit">Marcar todas como leídas</button>
            </form>
            <ul>
                @foreach($notificaciones as $notif)
                    <li>
                        <strong>{{ $notif->data['folio'] }}</strong> —
                        {{ $notif->data['mensaje'] }}
                        (Técnico: {{ $notif->data['tecnico'] }})
                        <a href="{{ route('reparaciones.show', $notif->data['reparacion_id']) }}">Ver orden</a>
                        <form method="POST" action="{{ route('notificaciones.leida', $notif->id) }}" style="display:inline">
                            @csrf
                            <button type="submit">✓ Leída</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    {{-- Estadísticas --}}
    <section aria-label="Estadísticas del taller">
        <article>
            <h3>{{ $stats['total'] }}</h3>
            <p>Total órdenes</p>
        </article>
        <article>
            <h3>{{ $stats['en_proceso'] }}</h3>
            <p>En proceso</p>
        </article>
        <article>
            <h3>{{ $stats['retardos'] }}</h3>
            <p>Retardos activos</p>
        </article>
        <article>
            <h3>{{ $stats['completadas'] }}</h3>
            <p>Entregadas</p>
        </article>
    </section>

    {{-- Órdenes recientes --}}
    <section aria-label="Órdenes en proceso">
        <header>
            <h2>Órdenes activas recientes</h2>
            <a href="{{ route('reparaciones.index') }}">Ver todas</a>
            <a href="{{ route('reparaciones.create') }}">+ Nueva orden</a>
        </header>

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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ordenesActivas as $orden)
                    <tr>
                        <td>{{ $orden->folio }}</td>
                        <td>{{ $orden->cliente->nombre }}</td>
                        <td>{{ $orden->marca }} {{ $orden->modelo }}</td>
                        <td>Nivel {{ $orden->nivel->nivel }} — {{ $orden->nivel->nombre }}</td>
                        <td>{{ $orden->estado }}</td>
                        <td>{{ $orden->tecnico->name ?? 'Sin asignar' }}</td>
                        <td>
                            {{ $orden->hora_limite->format('d/m/Y H:i') }}
                            @if($orden->estaRetrasada())
                                <span aria-label="Retrasada">⚠ Retrasada</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('reparaciones.show', $orden) }}">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No hay órdenes activas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

@endsection