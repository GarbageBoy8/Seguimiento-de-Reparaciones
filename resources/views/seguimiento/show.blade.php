<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de orden {{ $reparacion->folio }} — FixFlow</title>
    <meta name="description" content="Consulta el estado de tu reparación con folio {{ $reparacion->folio }}.">
</head>
<body>

    <header>
        <h1>FixFlow — Seguimiento de tu orden</h1>
        <p>Folio: <strong>{{ $reparacion->folio }}</strong></p>
    </header>

    <main>

        {{-- Barra de progreso visual --}}
        <section aria-label="Progreso de la reparación">
            <h2>Estado actual: {{ $reparacion->estado }}</h2>
            <ol aria-label="Etapas de la reparación">
                @php
                    $etapas = ['Recibido', 'En Revisión', 'Reparado', 'Entregado'];
                    $estadoActual = $reparacion->estado;
                    $etapaActual = array_search($estadoActual, $etapas);
                @endphp
                @foreach($etapas as $i => $etapa)
                    <li aria-current="{{ $estadoActual === $etapa ? 'step' : 'false' }}">
                        {{ $etapa }}
                        @if($i < $etapaActual) ✓ @endif
                    </li>
                @endforeach
            </ol>

            @if($estadoActual === 'Esperando Pieza')
                <p>ℹ Tu equipo está en espera de una pieza de repuesto.</p>
            @elseif($estadoActual === 'Retardo')
                <p>⚠ La reparación está tomando más tiempo del estimado. El taller ya fue notificado.</p>
            @elseif($estadoActual === 'Cancelado')
                <p>Tu orden fue cancelada. Comunícate con el taller para más información.</p>
            @endif
        </section>

        {{-- Ficha técnica --}}
        <section aria-label="Ficha técnica del equipo">
            <h2>Tu equipo</h2>
            <dl>
                <dt>Dispositivo</dt>
                <dd>{{ $reparacion->tipo_equipo }} — {{ $reparacion->marca }} {{ $reparacion->modelo }}</dd>

                <dt>Nivel de reparación</dt>
                <dd>{{ $reparacion->nivel->nombre }}: {{ $reparacion->nivel->descripcion }}</dd>

                <dt>Técnico asignado</dt>
                <dd>{{ $reparacion->tecnico->name ?? 'Pendiente de asignación' }}</dd>

                <dt>Tiempo estimado de entrega</dt>
                <dd>{{ $reparacion->hora_limite->format('d/m/Y H:i') }}</dd>
            </dl>
        </section>

        {{-- Chat con el taller --}}
        <section aria-label="Chat con el taller" id="chat-portal">
            <h2>Mensajes con el taller</h2>

            <div id="portal-mensajes" aria-live="polite">
                {{-- Cargado por JS --}}
            </div>

            @if(session('success'))
                <p role="alert">{{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ route('seguimiento.mensaje', $reparacion->token_seguimiento) }}">
                @csrf
                <label for="contenido">Escribe tu mensaje</label>
                <textarea id="contenido" name="contenido" rows="3" required placeholder="Ej: ¿Tienen alguna actualización de mi equipo?"></textarea>
                <button type="submit">Enviar mensaje</button>
            </form>
        </section>

    </main>

    <script>
        const mensajesUrl = "{{ route('seguimiento.mensajes.json', $reparacion->token_seguimiento) }}";

        let lastMessageId = 0;

        function renderMensajes(mensajes) {
            const contenedor = document.getElementById('portal-mensajes');
            if (mensajes.length === 0) {
                contenedor.innerHTML = '<p>Aún no hay mensajes.</p>';
                return;
            }
            contenedor.innerHTML = mensajes.map(m =>
                `<div data-cliente="${m.es_del_cliente}">
                    <strong>${m.autor}</strong> <time>${m.fecha}</time>
                    <p>${m.contenido}</p>
                </div>`
            ).join('');
        }

        async function cargarMensajes() {
            try {
                const res = await fetch(mensajesUrl);
                if (!res.ok) return;
                const mensajes = await res.json();

                if (mensajes.length === 0) return;
                const maxId = Math.max(...mensajes.map(m => m.id));
                if (maxId <= lastMessageId) return;

                lastMessageId = maxId;
                renderMensajes(mensajes);
            } catch (e) {
                // Error de red silencioso — reintento en 5s
            }
        }

        cargarMensajes();
        setInterval(cargarMensajes, 5000);
    </script>

</body>
</html>
