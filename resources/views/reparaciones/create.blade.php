@extends('plantillas.base')

@section('titulo-pestana', 'Nueva Orden')

@section('contenido-principal')

    <h1>Nueva orden de reparación</h1>

    @if($errors->any())
        <ul role="alert">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('reparaciones.store') }}">
        @csrf

        {{-- BLOQUE 1: Datos del cliente --}}
        <fieldset>
            <legend>Datos del cliente</legend>

            {{-- Selector de cliente existente --}}
            <div>
                <label for="cliente_id">Buscar cliente existente (opcional)</label>
                <select id="cliente_id" name="cliente_id">
                    <option value="">— Nuevo cliente —</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }} ({{ $cliente->telefono ?? $cliente->email ?? 'sin contacto' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <p><em>Si seleccionas un cliente existente, los campos de abajo se ignoran.</em></p>

            <div>
                <label for="cliente_nombre">Nombre completo</label>
                <input type="text" id="cliente_nombre" name="cliente_nombre" value="{{ old('cliente_nombre') }}" />
            </div>
            <div>
                <label for="cliente_telefono">Teléfono</label>
                <input type="text" id="cliente_telefono" name="cliente_telefono" value="{{ old('cliente_telefono') }}" />
            </div>
            <div>
                <label for="cliente_email">Email (para notificaciones)</label>
                <input type="email" id="cliente_email" name="cliente_email" value="{{ old('cliente_email') }}" />
            </div>
        </fieldset>

        {{-- BLOQUE 2: Datos del dispositivo --}}
        <fieldset>
            <legend>Datos del dispositivo</legend>

            <div>
                <label for="tipo_equipo">Tipo de equipo</label>
                <select id="tipo_equipo" name="tipo_equipo" required>
                    <option value="">— Seleccionar —</option>
                    @foreach(['Celular', 'Laptop', 'Tablet', 'Consola', 'PC', 'Otro'] as $tipo)
                        <option value="{{ $tipo }}" {{ old('tipo_equipo') === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="marca">Marca</label>
                <input type="text" id="marca" name="marca" value="{{ old('marca') }}" required />
            </div>
            <div>
                <label for="modelo">Modelo</label>
                <input type="text" id="modelo" name="modelo" value="{{ old('modelo') }}" required />
            </div>
            <div>
                <label for="numero_serie">Número de serie (opcional)</label>
                <input type="text" id="numero_serie" name="numero_serie" value="{{ old('numero_serie') }}" />
            </div>
        </fieldset>

        {{-- BLOQUE 3: Nivel y técnico --}}
        <fieldset>
            <legend>Clasificación de la reparación</legend>

            <div>
                <label for="nivel_id">Nivel de reparación</label>
                <select id="nivel_id" name="nivel_id" required>
                    <option value="">— Seleccionar nivel —</option>
                    @foreach($niveles as $nivel)
                        <option value="{{ $nivel->id }}" {{ old('nivel_id') == $nivel->id ? 'selected' : '' }}>
                            Nivel {{ $nivel->nivel }} — {{ $nivel->nombre }} (SLA: {{ $nivel->horas_sla }}h)
                        </option>
                    @endforeach
                </select>
                {{-- Descripción dinámica del nivel seleccionado (el diseñador puede conectar esto con JS) --}}
                <small id="descripcion-nivel">Selecciona un nivel para ver su descripción.</small>
            </div>

            <div>
                <label for="user_id">Técnico asignado (opcional)</label>
                <select id="user_id" name="user_id">
                    <option value="">— Sin asignar —</option>
                    @foreach($tecnicos as $tecnico)
                        <option value="{{ $tecnico->id }}" {{ old('user_id') == $tecnico->id ? 'selected' : '' }}>
                            {{ $tecnico->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </fieldset>

        {{-- BLOQUE 4: Problema y costo --}}
        <fieldset>
            <legend>Descripción del problema</legend>

            <div>
                <label for="problema_reportado">Problema reportado por el cliente</label>
                <textarea id="problema_reportado" name="problema_reportado" rows="4" required>{{ old('problema_reportado') }}</textarea>
            </div>
            <div>
                <label for="costo_estimado">Costo estimado (opcional)</label>
                <input type="number" id="costo_estimado" name="costo_estimado" value="{{ old('costo_estimado') }}" step="0.01" min="0" />
            </div>
        </fieldset>

        <button type="submit">Crear orden</button>
        <a href="{{ route('panel.inicio') }}">Cancelar</a>
    </form>

    {{-- Datos de niveles para JS (descripción dinámica) --}}
    <script>
        const niveles = @json($niveles->keyBy('id'));
        const selectNivel = document.getElementById('nivel_id');
        const descNivel   = document.getElementById('descripcion-nivel');

        selectNivel.addEventListener('change', function () {
            const nivel = niveles[this.value];
            descNivel.textContent = nivel
                ? `${nivel.descripcion} — Tiempo estimado: ${nivel.horas_sla} horas`
                : 'Selecciona un nivel para ver su descripción.';
        });
    </script>

@endsection
