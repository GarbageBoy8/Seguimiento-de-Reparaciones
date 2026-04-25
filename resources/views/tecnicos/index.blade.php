@extends('plantillas.base')

@section('titulo-pestana', 'Técnicos del taller')

@section('contenido-principal')

{{-- Header con título y botón --}}
<div class="mb-8">
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold bg-[#1E1B2E] bg-clip-text text-transparent">
                Técnicos del taller
            </h1>
            <p class="text-gray-500 text-sm mt-1">Gestiona los técnicos y su carga de trabajo</p>
        </div>
        <a href="{{ route('tecnicos.create') }}"
            class="bg-[#EC4899] hover:bg-[#DB2777] text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-md hover:shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo técnico
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

{{-- Tabla de técnicos --}}
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-[#2D1B69] to-[#1E1B2E]">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider whitespace-nowrap">Técnico</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider whitespace-nowrap">Email</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider whitespace-nowrap">Órdenes activas</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider whitespace-nowrap">Total histórico</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tecnicos as $tecnico)
                <tr class="hover:bg-purple-50/30 transition-colors duration-200 group">
                    {{-- Nombre con avatar --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#EC4899]/10 flex items-center justify-center flex-shrink-0">
                                <span class="text-[#EC4899] text-sm font-medium uppercase">
                                    {{ substr($tecnico->name, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <span class="font-semibold text-[#2D1B69]">{{ $tecnico->name }}</span>
                                @if($tecnico->esAdmin())
                                <span class="ml-2 text-[10px] bg-[#7C3AED]/10 text-[#7C3AED] px-1.5 py-0.5 rounded-full">Admin</span>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Email --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-600">{{ $tecnico->email }}</span>
                        </div>
                    </td>

                    {{-- Órdenes activas --}}
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        @php
                        $activas = $tecnico->ordenes_activas;
                        $badgeColor = $activas > 3 ? 'bg-red-100 text-red-700' : ($activas > 0 ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700');
                        @endphp
                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold min-w-[50px] {{ $badgeColor }}">
                            {{ $activas }}
                        </span>
                    </td>

                    {{-- Total histórico --}}
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <span class="inline-flex items-center justify-center bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold min-w-[50px]">
                            {{ $tecnico->ordenes_total }}
                        </span>
                    </td>

                    {{-- Acciones --}}
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <form method="POST" action="{{ route('tecnicos.destroy', $tecnico) }}"
                            onsubmit="return confirm('¿Eliminar a {{ $tecnico->name }} del taller?\n\nEsta acción también reasignará sus órdenes actuales.')"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-500 hover:text-red-700 transition-colors flex items-center gap-1 mx-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span class="text-sm">Eliminar</span>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-400 font-medium">No hay técnicos registrados</p>
                            <a href="{{ route('tecnicos.create') }}" class="text-[#7C3AED] text-sm hover:underline">
                                Agregar el primer técnico →
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Leyenda de colores (opcional) --}}
@if($tecnicos->count() > 0)
<div class="mt-4 flex flex-wrap justify-center gap-4 text-xs text-gray-500">
    <div class="flex items-center gap-1.5">
        <span class="w-3 h-3 rounded-full bg-emerald-100"></span>
        <span>0 órdenes activas</span>
    </div>
    <div class="flex items-center gap-1.5">
        <span class="w-3 h-3 rounded-full bg-amber-100"></span>
        <span>1-3 órdenes activas</span>
    </div>
    <div class="flex items-center gap-1.5">
        <span class="w-3 h-3 rounded-full bg-red-100"></span>
        <span>Más de 3 órdenes activas</span>
    </div>
</div>
@endif

@endsection