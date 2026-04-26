@extends('plantillas.base')

@section('titulo-pestana', 'Clientes')

@section('contenido-principal')

{{-- Header con título y botón --}}
<div class="mb-8">
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold bg-[#1E1B2E] bg-clip-text text-transparent">
                Clientes del taller
            </h1>
            <p class="text-gray-500 text-sm mt-1">Gestiona y consulta el historial de tus clientes</p>
        </div>
        <a href="{{ route('clientes.create') }}"
            class="bg-[#EC4899] hover:bg-[#DB2777] text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-md hover:shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo cliente
        </a>
    </div>
</div>

{{-- Tabla de clientes --}}
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-[#2D1B69] to-[#1E1B2E]">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider whitespace-nowrap">Nombre</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider whitespace-nowrap">Teléfono</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider whitespace-nowrap">Email</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider whitespace-nowrap">Órdenes</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-purple-200 uppercase tracking-wider whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($clientes as $cliente)
                <tr class="hover:bg-purple-50/30 transition-colors duration-200 group">
                    {{-- Nombre con avatar --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#7C3AED]/10 flex items-center justify-center flex-shrink-0">
                                <span class="text-[#7C3AED] text-sm font-medium uppercase">
                                    {{ substr($cliente->nombre, 0, 2) }}
                                </span>
                            </div>
                            <span class="font-semibold text-[#2D1B69]">{{ $cliente->nombre }}</span>
                        </div>
                    </td>

                    {{-- Teléfono --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($cliente->telefono)
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-gray-700">{{ $cliente->telefono }}</span>
                        </div>
                        @else
                        <span class="text-gray-400 text-sm italic">—</span>
                        @endif
                    </td>

                    {{-- Email --}}
                    <td class="px-6 py-4">
                        @if($cliente->email)
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-600 text-sm">{{ $cliente->email }}</span>
                        </div>
                        @else
                        <span class="text-gray-400 text-sm italic">—</span>
                        @endif
                    </td>

                    {{-- Órdenes (contador) --}}
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <span class="inline-flex items-center justify-center bg-[#7C3AED]/10 text-[#7C3AED] px-3 py-1 rounded-full text-xs font-semibold min-w-[40px]">
                            {{ $cliente->reparaciones_count }}
                        </span>
                    </td>

                    {{-- Acciones --}}
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <a href="{{ route('clientes.show', $cliente) }}"
                            class="inline-flex items-center gap-1 text-[#7C3AED] hover:text-[#2D1B69] font-medium text-sm transition-colors group">
                            Ver historial
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-400 font-medium">No hay clientes registrados</p>
                            <a href="{{ route('clientes.create') }}" class="text-[#7C3AED] text-sm hover:underline">
                                Crear primer cliente →
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
    {{ $clientes->links() }}
</div>

@endsection