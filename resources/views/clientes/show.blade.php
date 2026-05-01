@extends('plantillas.base')

@section('titulo-pestana', $cliente->nombre)

@section('contenido-principal')

<div class="max-w-6xl mx-auto space-y-6">
    {{-- Perfil del cliente --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        {{-- Header con nombre del cliente --}}
        <div class="bg-gradient-to-r from-[#2D1B69] to-[#1E1B2E] px-6 py-5">
            <div class="flex flex-wrap justify-between items-center gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#7C3AED]/20 flex items-center justify-center">
                        <span class="text-2xl font-bold text-white">
                            {{ substr($cliente->nombre, 0, 2) }}
                        </span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $cliente->nombre }}</h1>
                        <p class="text-purple-200 text-sm mt-1">Perfil del cliente</p>
                    </div>
                </div>
                <a href="{{ route('reparaciones.create') }}?cliente_id={{ $cliente->id }}"
                    class="bg-[#EC4899] hover:bg-[#DB2777] text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nueva orden para este cliente
                </a>
            </div>
        </div>

        {{-- Información del cliente --}}
        <div class="p-6">
            <h2 class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Información de contacto
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Teléfono --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center gap-2 text-gray-500 text-sm mb-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Teléfono
                    </div>
                    <p class="text-gray-800 font-medium">{{ $cliente->telefono ?? '—' }}</p>
                </div>

                {{-- Email --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center gap-2 text-gray-500 text-sm mb-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Email
                    </div>
                    <p class="text-gray-800 font-medium">{{ $cliente->email ?? '—' }}</p>
                </div>

                {{-- Dirección --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center gap-2 text-gray-500 text-sm mb-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Dirección
                    </div>
                    <p class="text-gray-800 font-medium">{{ $cliente->direccion ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Historial de reparaciones --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-[#7C3AED]/5 to-[#EC4899]/5 px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2">
                <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Historial de reparaciones
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Folio</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Equipo</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nivel</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Estado</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Técnico</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Fecha</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reparaciones as $orden)
                    <tr class="hover:bg-purple-50/30 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-semibold text-[#2D1B69]">{{ $orden->folio }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                            {{ $orden->marca }} {{ $orden->modelo }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-[#7C3AED]/10 text-[#7C3AED] px-2 py-1 rounded-full text-xs font-medium">
                                {{ $orden->nivel->nombre }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                            $estadoColors = [
                            'Recibido' => 'bg-slate-100 text-slate-700',
                            'En Revisión' => 'bg-blue-100 text-blue-700',
                            'Esperando Pieza' => 'bg-amber-100 text-amber-700',
                            'Reparado' => 'bg-emerald-100 text-emerald-700',
                            'Entregado' => 'bg-gray-100 text-gray-500',
                            'Cancelado' => 'bg-rose-100 text-rose-700',
                            ];
                            $colorClass = $estadoColors[$orden->estado] ?? 'bg-gray-100 text-gray-600';
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colorClass }}">
                                {{ $orden->estado }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                            {{ $orden->tecnico->name ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                            {{ $orden->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
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
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-400 font-medium">Este cliente no tiene órdenes registradas</p>
                                <a href="{{ route('reparaciones.create') }}?cliente_id={{ $cliente->id }}"
                                    class="text-[#7C3AED] text-sm hover:underline">
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
</div>

@endsection