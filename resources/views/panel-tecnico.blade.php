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
        <section aria-label="Alertas de retardo" class="mb-8 bg-white rounded-2xl shadow-lg border border-amber-200 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-50 to-white px-6 py-4 border-b border-amber-200">
                <div class="flex justify-between items-center flex-wrap gap-4">
                    <h2 class="text-lg font-bold text-[#2D1B69] flex items-center gap-2">
                        <span class="text-2xl">⚠️</span> Alertas de retardo ({{ $notificaciones->count() }})
                    </h2>
                    <form method="POST" action="{{ route('notificaciones.leer-todas') }}">
                        @csrf
                        <button type="submit" class="bg-[#7C3AED] hover:bg-[#6D28D9] text-white px-4 py-2 rounded-xl text-sm font-medium transition-all shadow-sm">
                            Marcar todas como leídas
                        </button>
                    </form>
                </div>
            </div>
            <ul class="divide-y divide-amber-100">
                @foreach($notificaciones as $notif)
                    <li class="p-4 hover:bg-amber-50/50 transition-colors">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="flex-1">
                                <strong class="text-[#2D1B69] font-semibold">{{ $notif->data['folio'] }}</strong>
                                <span class="text-gray-600 mx-2">—</span>
                                <span class="text-gray-700">{{ $notif->data['mensaje'] }}</span>
                                <span class="text-gray-500 text-sm ml-2">(Técnico: {{ $notif->data['tecnico'] }})</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('reparaciones.show', $notif->data['reparacion_id']) }}" class="text-[#7C3AED] hover:text-[#2D1B69] text-sm font-medium transition-colors">
                                    Ver orden →
                                </a>
                                <form method="POST" action="{{ route('notificaciones.leida', $notif->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-gray-100 hover:bg-emerald-100 text-gray-600 hover:text-emerald-700 px-3 py-1 rounded-lg text-sm transition-colors">
                                        ✓ Leída
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
    <section aria-label="Estadísticas del taller" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <article class="bg-gradient-to-br from-[#7C3AED] to-[#2D1B69] rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-300">
            <p class="text-4xl font-bold">{{ $stats['total'] }}</p>
            <p class="text-purple-200 text-sm mt-1">Total órdenes</p>
        </article>
        <article class="bg-white border border-[#7C3AED]/20 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <p class="text-4xl font-bold text-[#7C3AED]">{{ $stats['en_proceso'] }}</p>
            <p class="text-gray-500 text-sm mt-1">En proceso</p>
        </article>
        <article class="bg-white border border-[#EC4899]/20 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <p class="text-4xl font-bold text-[#EC4899]">{{ $stats['retardos'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Retardos activos</p>
        </article>
        <article class="bg-white border border-[#10B981]/20 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <p class="text-4xl font-bold text-[#10B981]">{{ $stats['completadas'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Entregadas</p>
        </article>
    </section>

    {{-- Órdenes recientes --}}
    <section aria-label="Órdenes en proceso" class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-[#2D1B69] to-[#1E1B2E] px-6 py-4 flex flex-wrap justify-between items-center gap-4">
            <h2 class="text-white text-lg font-bold">Órdenes activas recientes</h2>
            <div class="flex gap-3 justify-center">
                <a href="{{ route('reparaciones.index') }}" class="text-purple-200 hover:text-white text-sm font-medium transition-colors justify-self-end px-4 py-2">
                    Ver todas 
                </a>
                <a href="{{ route('reparaciones.create') }}" class="bg-[#EC4899] hover:bg-[#DB2777] text-white px-4 py-2 rounded-xl text-sm font-medium transition-all shadow-md ">
                    + Nueva orden
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
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
                            <td >
                                <span class="bg-[#7C3AED]/10 text-[#7C3AED] px-2 py-1 rounded-full text-[12px] font-medium">
                                    Nivel {{ $orden->nivel->nivel }} — {{ $orden->nivel->nombre }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $estadoColors = [
                                        'pendiente' => 'bg-amber-100 text-amber-700',
                                        'en_proceso' => 'bg-blue-100 text-blue-700',
                                        'completada' => 'bg-emerald-100 text-emerald-700',
                                        'entregada' => 'bg-gray-100 text-gray-700',
                                    ];
                                    $colorClass = $estadoColors[$orden->estado] ?? 'bg-gray-100 text-gray-600';
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colorClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $orden->estado)) }}
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