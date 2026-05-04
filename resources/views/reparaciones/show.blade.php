@extends('plantillas.base')

@section('titulo-pestana', $reparacion->folio)

@section('contenido-principal')

<div class="max-w-6xl mx-auto space-y-6">
    {{-- Alerta de éxito --}}
    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-lg shadow-sm flex items-center gap-3" role="alert">
        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="font-medium">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Ficha principal --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        {{-- Header de la orden --}}
        <div class="bg-gradient-to-r from-[#2D1B69] to-[#1E1B2E] px-6 py-5">
            <div class="flex flex-wrap justify-between items-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $reparacion->folio }}</h1>
                    <p class="text-purple-200 text-sm mt-1">Orden de reparación</p>
                </div>
                <div class="flex items-center gap-3">
                    @php
                    $estadoColors = [
                    'Recibido' => 'bg-slate-100 text-slate-700',
                    'En Revisión' => 'bg-blue-100 text-blue-700',
                    'Esperando Pieza' => 'bg-amber-100 text-amber-700',
                    'Reparado' => 'bg-emerald-100 text-emerald-700',
                    'Entregado' => 'bg-gray-100 text-gray-500',
                    'Cancelado' => 'bg-rose-100 text-rose-700',
                    ];
                    $colorClass = $estadoColors[$reparacion->estado] ?? 'bg-gray-100 text-gray-600';
                    @endphp
                    <span class="px-3 py-1.5 rounded-full text-xs font-medium {{ $colorClass }}">
                        {{ $reparacion->estado }}
                    </span>
                    @if($reparacion->estaRetrasada())
                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1.5 rounded-full text-xs font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        RETARDO — Hora límite superada
                    </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Grid de información --}}
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Datos del dispositivo --}}
            <div class="bg-gray-50 rounded-xl p-5">
                <h2 class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 3h14a2 2 0 011 2v14a2 2 0 01-1 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                    </svg>
                    Dispositivo
                </h2>
                <dl class="space-y-2">
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-gray-500 text-sm">Tipo:</dt>
                        <dd class="text-gray-800 font-medium">{{ $reparacion->tipo_equipo }}</dd>
                    </div>
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-gray-500 text-sm">Marca:</dt>
                        <dd class="text-gray-800">{{ $reparacion->marca }}</dd>
                    </div>
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-gray-500 text-sm">Modelo:</dt>
                        <dd class="text-gray-800">{{ $reparacion->modelo }}</dd>
                    </div>
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-gray-500 text-sm">Serie:</dt>
                        <dd class="text-gray-800">{{ $reparacion->numero_serie ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-gray-500 text-sm">Nivel:</dt>
                        <dd class="text-gray-800"><span class="bg-[#7C3AED]/10 text-[#7C3AED] px-2 py-0.5 rounded-full text-xs">Nivel {{ $reparacion->nivel->nivel }} — {{ $reparacion->nivel->nombre }}</span></dd>
                    </div>
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-gray-500 text-sm">Problema:</dt>
                        <dd class="text-gray-800">{{ $reparacion->problema_reportado }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Datos del cliente --}}
            <div class="bg-gray-50 rounded-xl p-5">
                <h2 class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Cliente
                </h2>
                <dl class="space-y-2">
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-gray-500 text-sm">Nombre:</dt>
                        <dd class="text-gray-800"><a href="{{ route('clientes.show', $reparacion->cliente) }}" class="text-[#7C3AED] hover:text-[#2D1B69]">{{ $reparacion->cliente->nombre }}</a></dd>
                    </div>
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-gray-500 text-sm">Teléfono:</dt>
                        <dd class="text-gray-800">{{ $reparacion->cliente->telefono ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-gray-500 text-sm">Email:</dt>
                        <dd class="text-gray-800">{{ $reparacion->cliente->email ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Control de tiempos --}}
            <div class="bg-gray-50 rounded-xl p-5">
                <h2 class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Control de tiempos
                </h2>
                <dl class="space-y-2">
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-gray-500 text-sm">Ingreso:</dt>
                        <dd class="text-gray-800">{{ $reparacion->hora_ingreso->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-gray-500 text-sm">Hora límite (SLA):</dt>
                        <dd class="{{ $reparacion->estaRetrasada() ? 'text-red-600 font-medium' : 'text-gray-800' }}">{{ $reparacion->hora_limite->format('d/m/Y H:i') }}</dd>
                    </div>
                    @if($reparacion->hora_fin)
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-gray-500 text-sm">Finalizado:</dt>
                        <dd class="text-gray-800">{{ $reparacion->hora_fin->format('d/m/Y H:i') }}</dd>
                    </div>
                    @endif
                    <div class="flex flex-wrap">
                        <dt class="w-32 text-gray-500 text-sm">Técnico:</dt>
                        <dd class="text-gray-800">{{ $reparacion->tecnico->name ?? 'Sin asignar' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Enlace de seguimiento --}}
            <div class="bg-gray-50 rounded-xl p-5">
                <h2 class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                    Enlace del cliente
                </h2>
                <p class="text-sm text-gray-600 mb-3">Comparte este enlace con el cliente para que pueda ver el estado de su orden:</p>
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="text" id="enlace-seguimiento" readonly
                        value="{{ url('/seguimiento/' . $reparacion->token_seguimiento) }}"
                        class="flex-1 px-4 py-2 rounded-xl border border-gray-300 bg-gray-100 text-gray-600 text-sm focus:outline-none" />
                    <button onclick="navigator.clipboard.writeText(document.getElementById('enlace-seguimiento').value)"
                        class="bg-[#7C3AED] hover:bg-[#6D28D9] text-white px-4 py-2 rounded-xl text-sm font-medium transition-all flex items-center gap-2 justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                        </svg>
                        Copiar enlace
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Actualizar orden --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-[#7C3AED]/5 to-[#EC4899]/5 px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2">
                <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Actualizar orden
            </h2>
        </div>
        <form method="POST" action="{{ route('reparaciones.update', $reparacion) }}" class="p-6 space-y-4">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select id="estado" name="estado" class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED]">
                        @foreach(['Recibido', 'En Revisión', 'Esperando Pieza', 'Reparado', 'Entregado', 'Cancelado'] as $estado)
                        <option value="{{ $estado }}" {{ $reparacion->estado === $estado ? 'selected' : '' }}>
                            {{ $estado }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Técnico asignado</label>
                    <select id="user_id" name="user_id" class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED]">
                        <option value="">— Sin asignar —</option>
                        @foreach($tecnicos as $tec)
                        <option value="{{ $tec->id }}" {{ $reparacion->user_id == $tec->id ? 'selected' : '' }}>
                            {{ $tec->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="diagnostico_tecnico" class="block text-sm font-medium text-gray-700 mb-1">Diagnóstico técnico</label>
                <textarea id="diagnostico_tecnico" name="diagnostico_tecnico" rows="3"
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] resize-none">{{ old('diagnostico_tecnico', $reparacion->diagnostico_tecnico) }}</textarea>
            </div>

            <div>
                <label for="comentario_retardo" class="block text-sm font-medium text-gray-700 mb-1">Comentario de justificación <span class="text-gray-400 text-xs">(si hay retardo)</span></label>
                <textarea id="comentario_retardo" name="comentario_retardo" rows="2"
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] resize-none">{{ old('comentario_retardo', $reparacion->comentario_retardo) }}</textarea>
            </div>

            <div>
                <label for="costo_final" class="block text-sm font-medium text-gray-700 mb-1">Costo final</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                    <input type="number" id="costo_final" name="costo_final" value="{{ old('costo_final', $reparacion->costo_final) }}" step="0.01" min="0"
                        class="w-full pl-7 pr-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED]" />
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-[#7C3AED] hover:bg-[#6D28D9] text-white px-6 py-2.5 rounded-xl font-medium transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>

    {{-- Escalar nivel --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-[#7C3AED]/5 to-[#EC4899]/5 px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2">
                <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                Escalar nivel
            </h2>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-600 mb-4">Nivel actual: <strong class="text-[#7C3AED]">{{ $reparacion->nivel->nombre }}</strong></p>

            @if($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                <ul class="list-disc list-inside text-red-700 text-sm">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('reparaciones.escalar', $reparacion) }}" class="space-y-4">
                @csrf
                <div>
                    <label for="nivel_nuevo_id" class="block text-sm font-medium text-gray-700 mb-1">Nuevo nivel</label>
                    <select id="nivel_nuevo_id" name="nivel_nuevo_id" required class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED]">
                        <option value="">— Seleccionar nuevo nivel —</option>
                        @foreach($niveles as $nivel)
                        @if($nivel->id != $reparacion->nivel_id)
                        <option value="{{ $nivel->id }}">
                            Nivel {{ $nivel->nivel }} — {{ $nivel->nombre }} (SLA: {{ $nivel->horas_sla }}h)
                        </option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="motivo" class="block text-sm font-medium text-gray-700 mb-1">Motivo del escalamiento</label>
                    <textarea id="motivo" name="motivo" rows="3" required
                        class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] resize-none"
                        placeholder="Ej: Se detectó falla en la placa madre, requiere microsoldadura.">{{ old('motivo') }}</textarea>
                </div>
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2.5 rounded-xl font-medium transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                    </svg>
                    Escalar nivel
                </button>
            </form>
        </div>
    </div>

    {{-- Historial de escalamientos --}}
    @if($reparacion->escalamientos->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-[#7C3AED]/5 to-[#EC4899]/5 px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2">
                <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Historial de escalamientos
            </h2>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @foreach($reparacion->escalamientos as $esc)
                <div class="border-l-4 border-[#7C3AED] pl-4 py-2 bg-gray-50 rounded-r-lg">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <span class="font-semibold text-[#2D1B69]">{{ $esc->nivelAnterior->nombre }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                        <span class="font-semibold text-[#7C3AED]">{{ $esc->nivelNuevo->nombre }}</span>
                        <span class="text-xs text-gray-400 ml-auto">por {{ $esc->user->name ?? 'Sistema' }} el {{ $esc->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <p class="text-sm text-gray-600 italic">"{{ $esc->motivo }}"</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Chat interno --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-[#7C3AED]/5 to-[#EC4899]/5 px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2">
                <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                Chat con el cliente
            </h2>
        </div>
        <div class="p-6">
            <div id="chat-mensajes" class="h-96 overflow-y-auto bg-gray-50 rounded-xl p-4 mb-4 space-y-3">
                {{-- Mensajes cargados por JS vía polling --}}
                <div class="text-center text-gray-400 text-sm">Cargando mensajes...</div>
            </div>

            <form id="chat-form" class="space-y-3">
                @csrf
                <div>
                    <label for="chat-input" class="block text-sm font-medium text-gray-700 mb-1">Mensaje</label>
                    <textarea id="chat-input" name="contenido" rows="2"
                        class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] resize-none"
                        placeholder="Escribe un mensaje..."></textarea>
                </div>
                <button type="submit" class="bg-[#7C3AED] hover:bg-[#6D28D9] text-white px-6 py-2.5 rounded-xl font-medium transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Enviar mensaje
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const chatUrl = "{{ route('reparaciones.mensajes.index', $reparacion) }}";
    const chatStoreUrl = "{{ route('reparaciones.mensajes.store', $reparacion) }}";
    const csrfToken = "{{ csrf_token() }}";

    let lastMessageId = 0;

    function renderMensajes(mensajes) {
        const contenedor = document.getElementById('chat-mensajes');
        if (mensajes.length === 0) {
            contenedor.innerHTML = '<div class="text-center text-gray-400 text-sm">Aún no hay mensajes.</div>';
            return;
        }
        contenedor.innerHTML = mensajes.map(m => `
            <div class="flex flex-col ${m.es_del_cliente ? 'items-start' : 'items-end'}">
                <div class="max-w-[80%] ${m.es_del_cliente ? 'bg-gray-200 text-gray-800' : 'bg-[#7C3AED] text-white'} rounded-2xl px-4 py-2">
                    <div class="flex items-center gap-2 mb-1">
                        <strong class="text-sm">${m.autor}</strong>
                        <time class="text-[10px] opacity-70">${m.fecha}</time>
                    </div>
                    <p class="text-sm break-words">${m.contenido}</p>
                </div>
            </div>
        `).join('');
        contenedor.scrollTop = contenedor.scrollHeight;
    }

    async function cargarMensajes() {
        try {
            const res = await fetch(chatUrl);
            if (!res.ok) return;
            const mensajes = await res.json();
            if (mensajes.length === 0) return;
            const maxId = Math.max(...mensajes.map(m => m.id));
            if (maxId <= lastMessageId) return;
            lastMessageId = maxId;
            renderMensajes(mensajes);
        } catch (e) {
            // Error silencioso
        }
    }

    document.getElementById('chat-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const btn = this.querySelector('button[type="submit"]');
        const contenido = input.value.trim();
        if (!contenido) return;

        btn.disabled = true;
        btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Enviando...';

        try {
            const res = await fetch(chatStoreUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    contenido
                })
            });

            if (res.ok) {
                input.value = '';
                cargarMensajes();
            } else if (res.status === 419) {
                alert('Tu sesión ha expirado. La página se recargará para continuar.');
                location.reload();
            } else {
                alert('No se pudo enviar el mensaje. Intenta de nuevo.');
            }
        } catch (err) {
            alert('Sin conexión. Verifica tu red.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg> Enviar mensaje';
        }
    });

    cargarMensajes();
    setInterval(cargarMensajes, 5000);
</script>

@endsection