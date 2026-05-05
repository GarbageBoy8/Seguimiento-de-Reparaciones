<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de orden {{ $reparacion->folio }} — FixFlow</title>
    <meta name="description" content="Consulta el estado de tu reparación con folio {{ $reparacion->folio }}.">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.95);
                opacity: 0.7;
            }

            100% {
                transform: scale(1.05);
                opacity: 0;
            }
        }

        .animate-pulse-ring {
            animation: pulse-ring 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
    {{-- Fallback para navegadores sin JS: recarga cada 30s para mostrar mensajes nuevos --}}
    <noscript>
        <meta http-equiv="refresh" content="30">
        <style>
            .no-js-alert {
                display: block;
            }

            .js-only {
                display: none;
            }
        </style>
    </noscript>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-[#7C3AED] to-[#EC4899] bg-clip-text text-transparent">
                        FixFlow
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Seguimiento de tu orden de reparación</p>
                </div>
                <div class="bg-[#7C3AED]/10 px-4 py-2 rounded-xl border border-[#7C3AED]/20">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Folio de seguimiento</p>
                    <p class="text-xl font-bold text-[#2D1B69] font-mono">{{ $reparacion->folio }}</p>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        {{-- Barra de progreso visual --}}
        <section class="bg-white rounded-2xl shadow-[0_10px_25px_-12px_rgba(124,58,237,0.25)] overflow-hidden" aria-label="Progreso de la reparación">
            <div class="bg-gradient-to-r from-[#7C3AED]/5 to-[#EC4899]/5 px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Estado actual: <span class="text-[#7C3AED]">{{ $reparacion->estado }}</span>
                </h2>
            </div>
            <div class="p-6">
                <!-- Barra de progreso visual pasos -->
                <div class="relative mb-8">
                    <div class="overflow-x-auto pb-2">
                        <div class="flex items-center justify-between min-w-[500px] md:min-w-0">
                            @php
                            $etapas = ['Recibido', 'En Revisión', 'Reparado', 'Entregado'];
                            $estadoActual = $reparacion->estado;
                            $etapaActual = array_search($estadoActual, $etapas);
                            $estadosEspeciales = ['Esperando Pieza', 'Retardo', 'Cancelado'];
                            @endphp
                            @foreach($etapas as $i => $etapa)
                            <div class="flex flex-col items-center flex-1 relative">
                                <div class="relative">
                                    @if($i < $etapaActual)
                                        <div class="w-10 h-10 rounded-full bg-[#7C3AED] flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                </div>
                                @elseif($i == $etapaActual)
                                <div class="w-10 h-10 rounded-full bg-[#7C3AED] flex items-center justify-center shadow-lg ring-4 ring-[#7C3AED]/20">
                                    <span class="text-white font-bold">{{ $i + 1 }}</span>
                                </div>
                                @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500 font-bold">{{ $i + 1 }}</span>
                                </div>
                                @endif
                            </div>
                            <span class="text-xs font-medium mt-2 {{ $i <= $etapaActual ? 'text-[#2D1B69]' : 'text-gray-400' }}">
                                {{ $etapa }}
                            </span>
                            @if($i < count($etapas) - 1)
                                <div class="absolute top-5 left-[60%] w-[70%] h-0.5 {{ $i < $etapaActual ? 'bg-[#7C3AED]' : 'bg-gray-200' }} hidden md:block">
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            </div>

            @if($estadoActual === 'Esperando Pieza')
            <div class="bg-amber-50 border-l-4 border-amber-500 rounded-xl p-4 mt-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-amber-700 text-sm">ℹ Tu equipo está en espera de una pieza de repuesto.</p>
                </div>
            </div>
            @elseif($estadoActual === 'Retardo')
            <div class="bg-orange-50 border-l-4 border-orange-500 rounded-xl p-4 mt-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-orange-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-orange-700 text-sm">⚠ La reparación está tomando más tiempo del estimado. El taller ya fue notificado.</p>
                </div>
            </div>
            @elseif($estadoActual === 'Cancelado')
            <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-4 mt-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <p class="text-red-700 text-sm">Tu orden fue cancelada. Comunícate con el taller para más información.</p>
                </div>
            </div>
            @endif
            </div>
        </section>

        {{-- Ficha técnica del equipo --}}
        <section class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#7C3AED]/5 to-[#EC4899]/5 px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 3h14a2 2 0 01-2 2H7a2 2 0 01-2-2zm0 0v16a2 2 0 002 2h10a2 2 0 002-2V5"></path>
                    </svg>
                    Tu equipo
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Dispositivo</dt>
                        <dd class="mt-1 font-medium text-gray-800">{{ $reparacion->tipo_equipo }} — {{ $reparacion->marca }} {{ $reparacion->modelo }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nivel de reparación</dt>
                        <dd class="mt-1 font-medium text-gray-800">
                            {{ $reparacion->nivel->nombre }}
                            <span class="text-xs text-gray-500 block">{{ $reparacion->nivel->descripcion }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Técnico asignado</dt>
                        <dd class="mt-1 font-medium text-gray-800">{{ $reparacion->tecnico->name ?? 'Pendiente de asignación' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tiempo estimado de entrega</dt>
                        <dd class="mt-1 font-medium text-[#7C3AED]">{{ $reparacion->hora_limite->format('d/m/Y H:i') }}</dd>
                    </div>
                </div>
            </div>
        </section>

        {{-- Chat con el taller --}}
        <section class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden" aria-label="Chat con el taller" id="chat-portal">
            <div class="bg-gradient-to-r from-[#7C3AED]/5 to-[#EC4899]/5 px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Mensajes con el taller
                </h2>
            </div>
            <div class="p-6">
                <!-- Contenedor de mensajes -->
                <div id="portal-mensajes" class="space-y-4 max-h-[400px] overflow-y-auto mb-6" aria-live="polite">
                    <div class="text-center py-8">
                        <div class="animate-pulse flex justify-center">
                            <div class="h-8 w-8 bg-[#7C3AED]/20 rounded-full"></div>
                        </div>
                        <p class="text-gray-500 text-sm mt-2">Cargando mensajes...</p>
                    </div>
                </div>

                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-3 mb-4">
                    <p class="text-green-700 text-sm">{{ session('success') }}</p>
                </div>
                @endif

                @php $ordenCerrada = in_array($reparacion->estado, ['Entregado', 'Cancelado']); @endphp

                @if(!$ordenCerrada)
                {{-- Orden activa: el cliente puede enviar mensajes --}}
                <form id="portal-form" method="POST" action="{{ route('seguimiento.mensaje', $reparacion->token_seguimiento) }}" class="border-t border-gray-100 pt-6">
                    @csrf
                    <label for="contenido" class="block text-sm font-medium text-gray-700 mb-2">Escribe tu mensaje</label>
                    <textarea id="contenido" name="contenido" rows="3" required
                        placeholder="Ej: ¿Tienen alguna actualización de mi equipo?"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all resize-none"></textarea>
                    <button type="submit" id="portal-btn"
                        class="mt-3 bg-[#7C3AED] hover:bg-[#6D28D9] text-white px-6 py-2.5 rounded-xl font-medium transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Enviar mensaje
                    </button>
                </form>
                @else
                {{-- Orden cerrada: solo lectura del historial --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-600 text-sm flex items-center gap-2">
                        @if($reparacion->estado === 'Entregado')
                        <span class="text-green-600">✅</span> Esta orden fue entregada. El chat ya no está disponible.
                        @else
                        <span class="text-red-600">❌</span> Esta orden fue cancelada. El chat ya no está disponible.
                        @endif
                    </p>
                </div>
                @endif
            </div>
        </section>

        <!-- Alerta para navegadores sin JS -->
        <noscript>
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 no-js-alert">
                <p class="text-amber-700 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    JavaScript está deshabilitado. La página se recargará automáticamente cada 30 segundos para mostrar nuevos mensajes.
                </p>
            </div>
        </noscript>
    </main>

    <footer class="border-t border-gray-200 mt-12 py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400 text-sm">FixFlow — Sistema de gestión de reparaciones</p>
        </div>
    </footer>

    <script>
        const mensajesUrl = "{{ route('seguimiento.mensajes.json', $reparacion->token_seguimiento) }}";

        let lastMessageId = 0;
        const tituloOriginal = document.title;

        function renderMensajes(mensajes) {
            const contenedor = document.getElementById('portal-mensajes');
            if (!mensajes || mensajes.length === 0) {
                contenedor.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p class="text-gray-500 text-sm">Aún no hay mensajes.</p>
                        <p class="text-gray-400 text-xs mt-1">Escribe tu primer mensaje arriba.</p>
                    </div>
                `;
                return;
            }

            contenedor.innerHTML = mensajes.map(m => `
                <div class="flex ${m.es_del_cliente ? 'justify-end' : 'justify-start'}">
                    <div class="max-w-[80%] ${m.es_del_cliente ? 'bg-[#7C3AED]/10' : 'bg-gray-100'} rounded-2xl px-4 py-3 ${m.es_del_cliente ? 'rounded-tr-sm' : 'rounded-tl-sm'}">
                        <div class="flex items-center gap-2 mb-1">
                            <strong class="text-xs font-semibold ${m.es_del_cliente ? 'text-[#7C3AED]' : 'text-gray-700'}">${m.autor}</strong>
                            <time class="text-[10px] text-gray-400">${m.fecha}</time>
                        </div>
                        <p class="text-sm text-gray-700">${escapeHtml(m.contenido)}</p>
                    </div>
                </div>
            `).join('');

            // Scroll al fondo
            contenedor.scrollTop = contenedor.scrollHeight;

            // Badge en el título si la pestaña no está enfocada
            if (!document.hasFocus()) {
                document.title = '🔔 Nuevo mensaje — FixFlow';
            }
        }

        // Función para escapar HTML
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Restaurar título cuando el usuario vuelve a la pestaña
        window.addEventListener('focus', () => {
            document.title = tituloOriginal;
        });

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

        // Orden cerrada = solo carga inicial del historial, sin polling ni badge
        const ordenCerrada = {
            {
                $ordenCerrada ? 'true' : 'false'
            }
        };

        cargarMensajes();
        if (!ordenCerrada) {
            setInterval(cargarMensajes, 5000);
        }

        // Submit AJAX — solo se enlaza si el formulario existe (orden activa)
        if (!ordenCerrada) {
            const portalForm = document.getElementById('portal-form');
            if (portalForm) {
                const portalStoreUrl = portalForm.action;
                const portalCsrf = document.querySelector('#portal-form input[name="_token"]').value;

                portalForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const textarea = document.getElementById('contenido');
                    const btn = document.getElementById('portal-btn');
                    const contenido = textarea.value.trim();
                    if (!contenido) return;

                    btn.disabled = true;
                    btn.innerHTML = `
                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Enviando...
                    `;

                    try {
                        const res = await fetch(portalStoreUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': portalCsrf
                            },
                            body: JSON.stringify({
                                contenido
                            })
                        });

                        if (res.ok) {
                            textarea.value = '';
                            cargarMensajes();
                        } else if (res.status === 419) {
                            alert('Tu sesión ha expirado. La página se recargará.');
                            location.reload();
                        } else {
                            alert('No se pudo enviar el mensaje. Intenta de nuevo.');
                        }
                    } catch (err) {
                        alert('Sin conexión. Verifica tu red e intenta de nuevo.');
                    } finally {
                        btn.disabled = false;
                        btn.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Enviar mensaje
                        `;
                    }
                });
            }
        }
    </script>
</body>

</html>