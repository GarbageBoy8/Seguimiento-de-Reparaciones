{{-- select-tecnico.blade.php --}}
@props([
    'name' => 'user_id',
    'id' => null,
    'tecnicos' => null,
    'selected' => null,
    'placeholder' => 'Sin asignar',
    'required' => false,
    'showStats' => false
])

@php
$id = $id ?? $name;
@endphp

<div 
    x-data="{ 
        open: false, 
        selected: null,
        selectedId: '{{ old($name, $selected) }}',
        init() {
            // Esto se ejecuta nativamente en Alpine al iniciar, sin romper ciclos
            if (this.selectedId) {
                @foreach($tecnicos as $tecnico)
                    if (this.selectedId == '{{ $tecnico->id }}') {
                        this.selected = '{{ $tecnico->name }}';
                    }
                @endforeach
            }
        }
    }" 
    class="relative w-full"
>
    <button
        type="button"
        @click="open = !open"
        class="flex w-full min-w-0 items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-left transition-all hover:border-gray-400 focus:border-[#7C3AED] focus:ring-2 focus:ring-[#7C3AED]/20"
        :class="{ 'border-[#7C3AED] ring-2 ring-[#7C3AED]/20': open }">
        <span x-text="selected ? selected : '— {{ $placeholder }} —'" class="truncate" :class="{ 'text-gray-900': selected, 'text-gray-500': !selected }"></span>
        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200 flex-shrink-0" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute left-0 z-50 mt-2 max-h-80 w-full min-w-0 overflow-y-auto rounded-xl border border-gray-200 bg-white shadow-2xl md:max-h-96"
    >
        <div class="py-1">
            <div
                @click="selected = '— {{ $placeholder }} —'; selectedId = ''; open = false"
                class="px-4 py-3 hover:bg-purple-50 hover:text-[#7C3AED] cursor-pointer transition-colors border-b border-gray-100"
                :class="{ 'bg-purple-50 text-[#7C3AED]': !selectedId }">
                <div class="font-medium text-gray-600">— {{ $placeholder }} —</div>
                <div class="text-xs text-gray-400 mt-0.5">Ningún técnico asignado</div>
            </div>

            @forelse($tecnicos as $tecnico)
            <div
                @click="selected = '{{ $tecnico->name }}'; selectedId = '{{ $tecnico->id }}'; open = false"
                class="px-4 py-3 hover:bg-purple-50 hover:text-[#7C3AED] cursor-pointer transition-colors border-b border-gray-100 last:border-b-0"
                :class="{ 'bg-purple-50 text-[#7C3AED]': selectedId == '{{ $tecnico->id }}' }">
                
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between sm:gap-3">
                    <div class="min-w-0 flex-1 truncate font-medium">{{ $tecnico->name }}</div>
                    @if($showStats && isset($tecnico->ordenes_activas))
                    <div class="flex flex-wrap items-center gap-2 sm:flex-shrink-0">
                        @if($tecnico->ordenes_activas > 0)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            {{ $tecnico->ordenes_activas }} activa{{ $tecnico->ordenes_activas != 1 ? 's' : '' }}
                        </span>
                        @endif
                        <span class="text-xs text-gray-500">
                            Total: {{ $tecnico->ordenes_total ?? 0 }}
                        </span>
                    </div>
                    @endif
                </div>
                
                <div class="mt-1 truncate text-xs text-gray-500">
                    {{ $tecnico->email }}
                </div>
            </div>
            @empty
            <div class="px-4 py-8 text-center text-gray-500 text-sm">
                No hay técnicos disponibles
            </div>
            @endforelse
        </div>
    </div>

    <input type="hidden" name="{{ $name }}" x-model="selectedId">
    
    @if($required)
        @error($name)
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    @endif
</div>
