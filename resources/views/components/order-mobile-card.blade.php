@props([
    'orden',
    'showCliente' => true,
    'dateLabel' => 'Hora límite',
    'dateValue' => null,
])

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
    $dateValue = $dateValue ?? optional($orden->hora_limite)->format('d/m/Y H:i');
@endphp

<article class="rounded-2xl border border-gray-100 bg-white p-4 shadow-md">
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="truncate font-semibold text-[#2D1B69]">{{ $orden->folio }}</p>
            <p class="mt-1 truncate text-sm text-gray-700">{{ $orden->marca }} {{ $orden->modelo }}</p>
            <p class="text-xs text-gray-400">{{ ucfirst($orden->tipo_equipo) }}</p>
        </div>
        <span class="flex-shrink-0 rounded-full px-2.5 py-1 text-xs font-medium {{ $colorClass }}">
            {{ $orden->estado }}
        </span>
    </div>

    <dl class="mt-4 grid grid-cols-1 gap-3 text-sm">
        @if($showCliente)
        <div>
            <dt class="text-xs font-medium uppercase text-gray-400">Cliente</dt>
            <dd class="mt-0.5 truncate text-gray-700">{{ $orden->cliente->nombre }}</dd>
        </div>
        @endif
        <div class="grid grid-cols-2 gap-3">
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">Nivel</dt>
                <dd class="mt-0.5 truncate text-gray-700">{{ $orden->nivel->nombre }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">Técnico</dt>
                <dd class="mt-0.5 truncate text-gray-700">{{ $orden->tecnico->name ?? 'Sin asignar' }}</dd>
            </div>
        </div>
        <div>
            <dt class="text-xs font-medium uppercase text-gray-400">{{ $dateLabel }}</dt>
            <dd class="mt-0.5 {{ $orden->estaRetrasada() ? 'font-medium text-red-600' : 'text-gray-700' }}">
                {{ $dateValue }}
            </dd>
        </div>
    </dl>

    <a href="{{ route('reparaciones.show', $orden) }}" class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-[#7C3AED] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[#6D28D9]">
        Ver detalles
    </a>
</article>
