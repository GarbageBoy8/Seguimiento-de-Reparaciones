@extends('plantillas.base')

@section('titulo-pestana', 'Centro de Mando')

@section('contenido-principal')

{{-- Alertas de sesión --}}
@if(session('success'))
<div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-lg mb-6 shadow-sm" role="alert">
    <p class="font-medium">{{ session('success') }}</p>
</div>
@endif

{{-- Notificaciones de retardo (solo admin) --}}
@if(auth()->user()->esAdmin() && $notificaciones->isNotEmpty())
<section id="notificaciones" aria-label="Alertas de retardo" class="mb-8 overflow-hidden rounded-2xl border border-amber-200 bg-white shadow-lg">
    <div class="border-b border-amber-200 bg-gradient-to-r from-amber-50 to-white px-4 py-4 md:px-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="flex items-center gap-2 text-lg font-bold text-[#2D1B69]">
                <span class="text-xl">!</span> Alertas de retardo ({{ $notificaciones->count() }})
            </h2>
            <form method="POST" action="{{ route('notificaciones.leer-todas') }}">
                @csrf
                <button type="submit" class="w-full rounded-xl bg-[#7C3AED] px-4 py-2 text-sm font-medium text-white shadow-sm transition-all hover:bg-[#6D28D9] sm:w-auto">
                    Marcar todas como leídas
                </button>
            </form>
        </div>
    </div>
<ul class="divide-y divide-amber-100">
    @foreach($notificaciones as $notif)
    <li class="p-4 transition-colors hover:bg-amber-50/50">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                {{-- Usamos ?? '' para que si no existe 'folio', no rompa la página --}}
                <strong class="text-[#2D1B69] font-semibold">{{ $notif->data['folio'] ?? 'Sin Folio' }}</strong>
                <span class="mx-2 hidden text-gray-600 sm:inline">—</span>
                <span class="block text-sm text-gray-700 sm:inline">{{ $notif->data['mensaje'] ?? 'Sin mensaje' }}</span>
                <span class="block text-sm text-gray-500 sm:ml-2 sm:inline">(Técnico: {{ $notif->data['tecnico'] ?? 'No asignado' }})</span>
            </div>
            <div class="flex items-center gap-2">
                {{-- Validamos también el ID de reparación antes de armar la ruta --}}
                @if(isset($notif->data['reparacion_id']))
                    <a href="{{ route('reparaciones.show', $notif->data['reparacion_id']) }}" class="text-[#7C3AED] hover:text-[#2D1B69] text-sm font-medium transition-colors">
                        Ver orden →
                    </a>
                @endif
                
                <form method="POST" action="{{ route('notificaciones.leida', $notif->id) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-gray-100 hover:bg-emerald-100 text-gray-600 hover:text-emerald-700 px-3 py-1 rounded-lg text-sm transition-colors">
                        ✓
                    </button>
                </form>
            </div>
        </div>
    </li>
    @endforeach
</ul>
</section>
@endif

{{-- Estadísticas --}}
<section aria-label="Estadísticas del taller" class="mb-8 grid grid-cols-2 gap-4 lg:grid-cols-4 lg:gap-6">
    <article class="rounded-2xl bg-gradient-to-br from-[#7C3AED] to-[#2D1B69] p-4 text-white shadow-lg transition-transform duration-300 hover:scale-105 md:p-6">
        <p class="text-3xl font-bold md:text-4xl">{{ $stats['total'] }}</p>
        <p class="text-purple-200 text-sm mt-1">Total órdenes</p>
    </article>
    <article class="rounded-2xl border border-[#7C3AED]/20 bg-white p-4 shadow-md transition-shadow hover:shadow-lg md:p-6">
        <p class="text-3xl font-bold text-[#7C3AED] md:text-4xl">{{ $stats['en_proceso'] }}</p>
        <p class="text-gray-500 text-sm mt-1">En proceso</p>
    </article>
    <article class="rounded-2xl border border-[#EC4899]/20 bg-white p-4 shadow-md transition-shadow hover:shadow-lg md:p-6">
        <p class="text-3xl font-bold text-[#EC4899] md:text-4xl">{{ $stats['retardos'] }}</p>
        <p class="text-gray-500 text-sm mt-1">Retardos activos</p>
    </article>
    <article class="rounded-2xl border border-[#10B981]/20 bg-white p-4 shadow-md transition-shadow hover:shadow-lg md:p-6">
        <p class="text-3xl font-bold text-[#10B981] md:text-4xl">{{ $stats['completadas'] }}</p>
        <p class="text-gray-500 text-sm mt-1">Entregadas</p>
    </article>
</section>

{{-- Órdenes recientes --}}
<section aria-label="Órdenes en proceso" class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="flex flex-wrap items-center justify-between gap-4 bg-gradient-to-r from-[#2D1B69] to-[#1E1B2E] px-4 py-4 md:px-6">
        <h2 class="text-white text-lg font-bold">Órdenes activas recientes</h2>
        <div class="flex gap-3 justify-center">
            <a href="{{ route('reparaciones.index') }}" class="text-purple-200 hover:text-white text-sm font-medium transition-colors justify-self-end px-4 py-2">
                Ver todas
            </a>
        </div>
    </div>

    <div class="space-y-4 p-4 md:hidden">
        @forelse($ordenesActivas as $orden)
        <x-order-mobile-card :orden="$orden" />
        @empty
        <div class="rounded-2xl bg-gray-50 px-6 py-10 text-center text-gray-400">
            <p>No hay órdenes activas</p>
        </div>
        @endforelse
    </div>

    <div class="hidden overflow-x-auto md:block">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Folio</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Equipo</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nivel</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Técnico</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Hora límite</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($ordenesActivas as $orden)
                <tr class="hover:bg-purple-50/30 transition-colors">
                    <td class="px-6 py-4 font-semibold text-[#2D1B69]">{{ $orden->folio }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $orden->cliente->nombre }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $orden->marca }} {{ $orden->modelo }}</td>

                    {{-- NIVEL - Una sola línea --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="bg-[#7C3AED]/10 text-[#7C3AED] px-2 py-1 rounded-full text-[12px] font-medium whitespace-nowrap">
                            Nivel {{ $orden->nivel->nivel }} — {{ $orden->nivel->nombre }}
                        </span>
                    </td>

                    {{-- ESTADO - Una sola línea --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                        $estadoColors = [
                        'Recibido' => 'bg-slate-100 text-slate-700',
                        'En Revisión' => 'bg-blue-100 text-blue-700',
                        'Esperando Pieza' => 'bg-amber-100 text-amber-700',
                        'Reparado' => 'bg-emerald-100 text-emerald-700',
                        'Retardo' => 'bg-red-100 text-red-700',
                        'Entregado' => 'bg-gray-100 text-gray-500',
                        'Cancelado' => 'bg-rose-100 text-rose-700',
                        ];
                        $colorClass = $estadoColors[$orden->estado] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colorClass }} whitespace-nowrap">
                            {{ $orden->estado }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-gray-600">{{ $orden->tecnico->name ?? 'Sin asignar' }}</td>
                    <td class="px-6 py-4">
                        <span class="{{ $orden->estaRetrasada() ? 'text-red-600 font-medium' : 'text-gray-600' }}">
                            {{ $orden->hora_limite->format('d/m/Y H:i') }}
                        </span>
                        @if($orden->estaRetrasada())
                        <span class="inline-flex items-center gap-1 ml-2 bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-medium">
                            ⚠ Retrasada
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('reparaciones.show', $orden) }}" class="text-[#7C3AED] hover:text-[#2D1B69] font-medium text-sm transition-colors">
                            Ver detalles
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                        <div class="flex flex-col items-center gap-2">
                            <span class="text-4xl">📭</span>
                            <p>No hay órdenes activas</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection
