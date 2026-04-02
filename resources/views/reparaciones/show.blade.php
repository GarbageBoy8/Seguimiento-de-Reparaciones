@extends('plantillas.base')

@section('titulo-pestana', $reparacion->folio)

@section('contenido-principal')

    @if(session('success'))
        <p role="alert">{{ session('success') }}</p>
    @endif

    {{-- Ficha principal --}}
    <article aria-label="Ficha de la orden">
        <header>
            <h1>{{ $reparacion->folio }}</h1>
            <span>Estado: <strong>{{ $reparacion->estado }}</strong></span>
            @if($reparacion->estaRetrasada())
                <span role="alert">⚠ RETARDO — Hora límite superada</span>
            @endif
        </header>

        <section aria-label="Datos del dispositivo">
            <h2>Dispositivo</h2>
            <dl>
                <dt>Tipo</dt><dd>{{ $reparacion->tipo_equipo }}</dd>
                <dt>Marca</dt><dd>{{ $reparacion->marca }}</dd>
                <dt>Modelo</dt><dd>{{ $reparacion->modelo }}</dd>
                <dt>Serie</dt><dd>{{ $reparacion->numero_serie ?? '—' }}</dd>
                <dt>Nivel</dt><dd>Nivel {{ $reparacion->nivel->nivel }} — {{ $reparacion->nivel->nombre }}</dd>
                <dt>Problema reportado</dt><dd>{{ $reparacion->problema_reportado }}</dd>
            </dl>
        </section>

        <section aria-label="Datos del cliente">
            <h2>Cliente</h2>
            <dl>
                <dt>Nombre</dt><dd><a href="{{ route('clientes.show', $reparacion->cliente) }}">{{ $reparacion->cliente->nombre }}</a></dd>
                <dt>Teléfono</dt><dd>{{ $reparacion->cliente->telefono ?? '—' }}</dd>
                <dt>Email</dt><dd>{{ $reparacion->cliente->email ?? '—' }}</dd>
            </dl>
        </section>

        <section aria-label="Tiempos">
            <h2>Control de tiempos</h2>
            <dl>
                <dt>Ingreso</dt><dd>{{ $reparacion->hora_ingreso->format('d/m/Y H:i') }}</dd>
                <dt>Hora límite (SLA)</dt><dd>{{ $reparacion->hora_limite->format('d/m/Y H:i') }}</dd>
                @if($reparacion->hora_fin)
                    <dt>Finalizado</dt><dd>{{ $reparacion->hora_fin->format('d/m/Y H:i') }}</dd>
                @endif
                <dt>Técnico asignado</dt><dd>{{ $reparacion->tecnico->name ?? 'Sin asignar' }}</dd>
            </dl>
        </section>

        <section aria-label="Enlace de seguimiento para el cliente">
            <h2>Enlace del cliente</h2>
            <p>Comparte este enlace con el cliente para que pueda ver el estado de su orden:</p>
            <input type="text" id="enlace-seguimiento" readonly
                   value="{{ url('/seguimiento/' . $reparacion->token_seguimiento) }}" />
            <button onclick="navigator.clipboard.writeText(document.getElementById('enlace-seguimiento').value)">
                Copiar enlace
            </button>
        </section>
    </article>

    {{-- Actualizar estado / técnico / costo --}}
    <section aria-label="Actualizar orden">
        <h2>Actualizar orden</h2>
        <form method="POST" action="{{ route('reparaciones.update', $reparacion) }}">
            @csrf
            @method('PATCH')

            <div>
                <label for="estado">Estado</label>
                <select id="estado" name="estado">
                    @foreach(['Recibido', 'En Revisión', 'Esperando Pieza', 'Reparado', 'Entregado', 'Cancelado'] as $estado)
                        <option value="{{ $estado }}" {{ $reparacion->estado === $estado ? 'selected' : '' }}>
                            {{ $estado }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="user_id">Técnico asignado</label>
                <select id="user_id" name="user_id">
                    <option value="">— Sin asignar —</option>
                    @foreach($tecnicos as $tec)
                        <option value="{{ $tec->id }}" {{ $reparacion->user_id == $tec->id ? 'selected' : '' }}>
                            {{ $tec->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="diagnostico_tecnico">Diagnóstico técnico</label>
                <textarea id="diagnostico_tecnico" name="diagnostico_tecnico" rows="3">{{ old('diagnostico_tecnico', $reparacion->diagnostico_tecnico) }}</textarea>
            </div>

            <div>
                <label for="comentario_retardo">Comentario de justificación (si hay retardo)</label>
                <textarea id="comentario_retardo" name="comentario_retardo" rows="2">{{ old('comentario_retardo', $reparacion->comentario_retardo) }}</textarea>
            </div>

            <div>
                <label for="costo_final">Costo final</label>
                <input type="number" id="costo_final" name="costo_final" value="{{ old('costo_final', $reparacion->costo_final) }}" step="0.01" min="0" />
            </div>

            <button type="submit">Guardar cambios</button>
        </form>
    </section>

    {{-- Escalar nivel --}}
    <section aria-label="Escalar nivel de reparación">
        <h2>Escalar nivel</h2>
        <p>Nivel actual: <strong>{{ $reparacion->nivel->nombre }}</strong></p>
        <form method="POST" action="{{ route('reparaciones.escalar', $reparacion) }}">
            @csrf
            <div>
                <label for="nivel_nuevo_id">Nuevo nivel</label>
                <select id="nivel_nuevo_id" name="nivel_nuevo_id" required>
                    <option value="">— Seleccionar nuevo nivel —</option>
                    @foreach($niveles as $nivel)
                        @if($nivel->id !== $reparacion->nivel_id)
                            <option value="{{ $nivel->id }}">
                                Nivel {{ $nivel->nivel }} — {{ $nivel->nombre }} (SLA: {{ $nivel->horas_sla }}h)
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div>
                <label for="motivo">Motivo del escalamiento</label>
                <textarea id="motivo" name="motivo" rows="3" required placeholder="Ej: Se detectó falla en la placa madre, requiere microsoldadura."></textarea>
            </div>
            <button type="submit">Escalar nivel</button>
        </form>
    </section>

    {{-- Historial de escalamientos --}}
    @if($reparacion->escalamientos->isNotEmpty())
        <section aria-label="Historial de escalamientos">
            <h2>Historial de escalamientos</h2>
            <ol>
                @foreach($reparacion->escalamientos as $esc)
                    <li>
                        <strong>{{ $esc->nivelAnterior->nombre }}</strong> → <strong>{{ $esc->nivelNuevo->nombre }}</strong>
                        por {{ $esc->user->name ?? 'Sistema' }} el {{ $esc->created_at->format('d/m/Y H:i') }}
                        <br><em>{{ $esc->motivo }}</em>
                    </li>
                @endforeach
            </ol>
        </section>
    @endif

    {{-- Chat interno --}}
    <section aria-label="Chat interno con el cliente" id="chat-container">
        <h2>Chat con el cliente</h2>

        <div id="chat-mensajes" aria-live="polite">
            {{-- Mensajes cargados por JS vía polling --}}
        </div>

        <form id="chat-form">
            @csrf
            <label for="chat-input">Mensaje</label>
            <textarea id="chat-input" name="contenido" rows="2" placeholder="Escribe un mensaje..."></textarea>
            <button type="submit">Enviar</button>
        </form>
    </section>

    <script>
        const chatUrl     = "{{ route('reparaciones.mensajes.index', $reparacion) }}";
        const chatStoreUrl = "{{ route('reparaciones.mensajes.store', $reparacion) }}";
        const csrfToken   = "{{ csrf_token() }}";

        async function cargarMensajes() {
            const res = await fetch(chatUrl);
            const mensajes = await res.json();
            const contenedor = document.getElementById('chat-mensajes');
            contenedor.innerHTML = mensajes.map(m =>
                `<div data-cliente="${m.es_del_cliente}">
                    <strong>${m.autor}</strong> <time>${m.fecha}</time>
                    <p>${m.contenido}</p>
                </div>`
            ).join('');
            contenedor.scrollTop = contenedor.scrollHeight;
        }

        document.getElementById('chat-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const contenido = document.getElementById('chat-input').value.trim();
            if (!contenido) return;

            await fetch(chatStoreUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ contenido })
            });

            document.getElementById('chat-input').value = '';
            cargarMensajes();
        });

        // Polling cada 5 segundos
        cargarMensajes();
        setInterval(cargarMensajes, 5000);
    </script>

@endsection
