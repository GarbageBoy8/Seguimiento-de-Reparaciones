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
        selectedId: '{{ old($name, $selected) }}'
    }" 
    class="relative"
    style="overflow: visible !important;"
    x-init="
        if (selectedId) {
            let tecnicoEncontrado = null;
            @foreach($tecnicos as $tecnico)
                if (selectedId == '{{ $tecnico->id }}') {
                    tecnicoEncontrado = '{{ $tecnico->name }}';
                }
            @endforeach
            if (tecnicoEncontrado) selected = tecnicoEncontrado;
        }
    "
>

    <!-- Botón selector -->
    <button
        type="button"
        @click="open = !open"
        class="w-full px-4 py-2 text-left bg-white rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all flex justify-between items-center hover:border-gray-400"
        :class="{ 'border-[#7C3AED] ring-2 ring-[#7C3AED]/20': open }">
        <span x-text="selected ? selected : '— {{ $placeholder }} —'" class="truncate" :class="{ 'text-gray-900': selected, 'text-gray-500': !selected }"></span>
        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200 flex-shrink-0" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Dropdown - se desborda completamente -->
    <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="fixed z-50 bg-white rounded-xl shadow-2xl border border-gray-200 max-h-96 overflow-y-auto"
        :style="{
            width: $el.parentElement.offsetWidth + 'px',
            left: $el.parentElement.getBoundingClientRect().left + 'px',
            top: ($el.parentElement.getBoundingClientRect().bottom + 8) + 'px'
        }">
        
        <div class="py-1">
            <!-- Opción "Sin asignar" -->
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
                
                <div class="flex items-center justify-between gap-3">
                    <div class="font-medium flex-1">{{ $tecnico->name }}</div>
                    @if($showStats && isset($tecnico->ordenes_activas))
                    <div class="flex items-center gap-2 flex-shrink-0">
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
                
                <div class="text-xs text-gray-500 mt-1">
                    {{ $tecnico->email }}
                </div>
            </div>
            @empty
            <div class="px-4 py-8 text-center text-gray-500 text-sm">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
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