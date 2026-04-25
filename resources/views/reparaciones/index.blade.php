@extends('plantillas.base')

@section('titulo-pestana', 'Órdenes')

@section('contenido-principal')

{{-- Header con título y botón --}}
<div class="mb-8">
    <div class="flex flex-wrap justify-between items-center gap-4">
        <h1 class="text-2xl md:text-3xl font-bold bg-[#1E1B2E] bg-clip-text text-transparent">
            Órdenes de reparación
        </h1>
        <a href="{{ route('reparaciones.create') }}"
            class="bg-[#EC4899] hover:bg-[#DB2777] text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-md hover:shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nueva orden
        </a>
    </div>
</div>

{{-- Alerta de éxito --}}
@if(session('success'))
<div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-lg shadow-sm flex items-center gap-3" role="alert">
    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <p class="font-medium">{{ session('success') }}</p>
</div>
@endif

{{-- Tabla de órdenes --}}
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-[#2D1B69] to-[#1E1B2E]">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider">Folio</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider">Cliente</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider">Equipo</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider">Nivel</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider">Estado</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider">Técnico</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider">Hora límite</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($reparaciones as $orden)
                <tr class="hover:bg-purple-50/30 transition-colors duration-200">
                    <td class="px-6 py-4">
                        <span class="font-semibold text-[#2D1B69]">{{ $orden->folio }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-[#7C3AED]/10 flex items-center justify-center">
                                <span class="text-[#7C3AED] text-xs font-medium">
                                    {{ substr($orden->cliente->nombre, 0, 2) }}
                                </span>
                            </div>
                            <span class="text-gray-700">{{ $orden->cliente->nombre }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <span class="text-gray-900 font-medium">{{ $orden->marca }} {{ $orden->modelo }}</span>
                            <span class="text-gray-400 text-[10px] block">{{ ucfirst($orden->tipo_equipo) }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-[#7C3AED]/10 text-[#7C3AED] px-2.5 py-1 rounded-full text-xs font-medium">
                            Nivel {{ $orden->nivel->nivel }} — {{ $orden->nivel->nombre }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                        $estadoConfig = [
                            'Recibido'        => ['bg' => 'bg-slate-100',   'text' => 'text-slate-700',   'icon' => '📥'],
                            'En Revisión'     => ['bg' => 'bg-blue-100',    'text' => 'text-blue-700',    'icon' => '🔧'],
                            'Esperando Pieza' => ['bg' => 'bg-amber-100',   'text' => 'text-amber-700',   'icon' => '⏳'],
                            'Reparado'        => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'icon' => '✅'],
                            'Retardo'         => ['bg' => 'bg-red-100',     'text' => 'text-red-700',     'icon' => '⚠️'],
                            'Entregado'       => ['bg' => 'bg-gray-100',    'text' => 'text-gray-500',    'icon' => '📦'],
                            'Cancelado'       => ['bg' => 'bg-rose-100',    'text' => 'text-rose-700',    'icon' => '❌'],
                        ];
                        $config = $estadoConfig[$orden->estado] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => ''];
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                            <span class="text-xs">{{ $config['icon'] }}</span>
                            {{ $orden->estado }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($orden->tecnico)
                        <div class="flex items-center gap-1.5">
                            <div class="w-6 h-6 rounded-full bg-[#EC4899]/10 flex items-center justify-center">
                                <span class="text-[#EC4899] text-[9px] font-medium">
                                    {{ substr($orden->tecnico->name, 0, 1) }}
                                </span>
                            </div>
                            <span class="text-gray-600 text-sm">{{ $orden->tecnico->name }}</span>
                        </div>
                        @else
                        <span class="text-gray-400 text-xs italic">Sin asignar</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-gray-700 text-sm">{{ $orden->hora_limite->format('d/m/Y') }}</span>
                            <span class="text-gray-400 text-[10px]">{{ $orden->hora_limite->format('H:i') }} hrs</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('reparaciones.show', $orden) }}"
                            class="inline-flex items-center gap-1 text-[#7C3AED] hover:text-[#2D1B69] font-medium text-sm transition-colors group">
                            Ver
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <p class="text-gray-400 font-medium">No hay órdenes registradas</p>
                            <a href="{{ route('reparaciones.create') }}" class="text-[#7C3AED] text-sm hover:underline">
                                Crear primera orden →
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
<div class="mt-6">
    {{ $reparaciones->links() }}
</div>

@endsection