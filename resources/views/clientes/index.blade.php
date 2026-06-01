@extends('plantillas.base')

@section('titulo-pestana', 'Clientes')

@section('contenido-principal')

{{-- Header con título y botón --}}
<div class="mb-6 md:mb-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold bg-[#1E1B2E] bg-clip-text text-transparent">
                Clientes del taller
            </h1>
            <p class="text-gray-500 text-sm mt-1">Gestiona y consulta el historial de tus clientes</p>
        </div>
        <a href="{{ route('clientes.create') }}"
            class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#EC4899] px-5 py-2.5 text-sm font-medium text-white shadow-md transition-all hover:bg-[#DB2777] hover:shadow-lg sm:w-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo cliente
        </a>
    </div>
</div>

{{-- Filtros --}}
<section class="mb-6 rounded-2xl border border-purple-100 bg-white p-4 shadow-md md:p-5">
    <form method="GET" action="{{ route('clientes.index') }}" class="grid gap-3 lg:grid-cols-[minmax(260px,1fr)_auto_auto] lg:items-end">
        <div>
            <label for="buscar_cliente" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Buscar cliente</label>
            <div class="relative">
                <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.1-5.15a6.25 6.25 0 11-12.5 0 6.25 6.25 0 0112.5 0z"></path>
                </svg>
                <input id="buscar_cliente" type="search" name="buscar" value="{{ $buscar }}"
                    maxlength="100" placeholder="Nombre del cliente"
                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm text-gray-700 placeholder:text-gray-400 focus:border-[#7C3AED] focus:outline-none focus:ring-2 focus:ring-[#7C3AED]/20 lg:min-h-[42px] lg:py-2.5">
            </div>
        </div>

        <label class="flex items-center gap-3 rounded-xl border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 lg:min-h-[42px] lg:py-2.5">
            <input type="checkbox" name="mayoristas" value="1" @checked($soloMayoristas)
                class="h-4 w-4 rounded border-gray-300 text-amber-500 focus:ring-amber-400/30">
            Mostrar solo mayoristas
        </label>

        <div class="flex flex-col gap-2 sm:flex-row lg:items-end">
            <button type="submit" class="flex w-full items-center justify-center rounded-xl bg-[#1E1B2E] px-5 py-3 text-sm font-medium text-white transition hover:bg-[#2D1B69] lg:min-h-[42px] lg:w-auto lg:py-0">
                Buscar
            </button>
            @if($soloMayoristas || $buscar !== '')
            <a href="{{ route('clientes.index') }}" class="flex w-full items-center justify-center rounded-xl bg-gray-100 px-5 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-200 lg:min-h-[42px] lg:w-auto lg:py-0">
                Limpiar
            </a>
            @endif
        </div>
    </form>
</section>

{{-- Cards móviles --}}
<div class="space-y-4 md:hidden">
    @forelse($clientes as $cliente)
    <article class="rounded-2xl border {{ $cliente->es_mayorista ? 'border-amber-200 bg-amber-50/70' : 'border-gray-100 bg-white' }} p-4 shadow-md">
        <div class="flex items-start gap-3">
            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-[#7C3AED]/10">
                <span class="text-sm font-medium uppercase text-[#7C3AED]">{{ substr($cliente->nombre, 0, 2) }}</span>
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex min-w-0 flex-wrap items-center gap-2">
                    <h2 class="truncate font-semibold text-[#2D1B69]">{{ $cliente->nombre }}</h2>
                    @if($cliente->es_mayorista)
                    <span class="rounded-md border border-amber-200 bg-amber-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-amber-800">
                        Mayorista
                    </span>
                    @endif
                </div>
                <p class="truncate text-sm text-gray-500">{{ $cliente->email ?? 'Sin email' }}</p>
                <p class="text-sm text-gray-500">{{ $cliente->telefono ?? 'Sin teléfono' }}</p>
            </div>
            <span class="rounded-full bg-[#7C3AED]/10 px-2.5 py-1 text-xs font-semibold text-[#7C3AED]">
                {{ $cliente->reparaciones_count }} orden{{ $cliente->reparaciones_count === 1 ? '' : 'es' }}
            </span>
        </div>
        <a href="{{ route('clientes.show', $cliente) }}" class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-[#7C3AED] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[#6D28D9]">
            Ver historial
        </a>
    </article>
    @empty
    <div class="rounded-2xl bg-white px-6 py-12 text-center shadow-md">
        <p class="font-medium text-gray-400">
            {{ $soloMayoristas || $buscar !== '' ? 'No hay clientes que coincidan con tu búsqueda' : 'No hay clientes registrados' }}
        </p>
        <a href="{{ route('clientes.create') }}" class="mt-2 inline-flex text-sm text-[#7C3AED] hover:underline">
            Crear primer cliente
        </a>
    </div>
    @endforelse
</div>

{{-- Tabla de clientes --}}
<div class="hidden overflow-hidden rounded-2xl bg-white shadow-lg md:block">
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
                {{-- CAMBIO AQUÍ: La fila se pinta de color ámbar si el cliente es mayorista --}}
                <tr class="{{ $cliente->es_mayorista ? 'bg-amber-50/60 hover:bg-amber-100/70 font-medium' : 'hover:bg-purple-50/30' }} transition-colors duration-200 group">
                    
                    {{-- Nombre con avatar --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#7C3AED]/10 flex items-center justify-center flex-shrink-0">
                                <span class="text-[#7C3AED] text-sm font-medium uppercase">
                                    {{ substr($cliente->nombre, 0, 2) }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-[#2D1B69]">{{ $cliente->nombre }}</span>
                                {{-- CAMBIO AQUÍ: Insignia de corona al lado del nombre si es mayorista --}}
                                @if($cliente->es_mayorista)
                                    <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider shadow-sm border border-amber-200 whitespace-nowrap">
                                        Mayorista
                                    </span>
                                @endif
                            </div>
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
                            <p class="text-gray-400 font-medium">
                                {{ $soloMayoristas || $buscar !== '' ? 'No hay clientes que coincidan con tu búsqueda' : 'No hay clientes registrados' }}
                            </p>
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
