{{-- select-nivel.blade.php --}}
@props([
    'name' => 'nivel_id',
    'id' => null,
    'niveles' => null,
    'selected' => null,
    'placeholder' => '— Seleccionar nivel —',
    'required' => false
])

@php
$id = $id ?? $name;
@endphp

<div x-data="{ 
    open: false, 
    selected: null,
    selectedId: '{{ old($name, $selected) }}'
}" 
class="relative"
style="overflow: visible !important;">

    <!-- Botón selector -->
    <button
        type="button"
        @click="open = !open"
        class="w-full px-4 py-2 text-left bg-white rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all flex justify-between items-center hover:border-gray-400"
        :class="{ 'border-[#7C3AED] ring-2 ring-[#7C3AED]/20': open }">
        <span x-text="selected ? selected : '{{ $placeholder }}'" class="truncate" :class="{ 'text-gray-900': selected, 'text-gray-500': !selected }"></span>
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
            @forelse($niveles as $nivel)
            <div
                @click="selected = 'Nivel {{ $nivel->nivel }} — {{ $nivel->nombre }} (SLA: {{ $nivel->horas_sla }}h)'; selectedId = '{{ $nivel->id }}'; open = false"
                class="px-4 py-3 hover:bg-purple-50 hover:text-[#7C3AED] cursor-pointer transition-colors border-b border-gray-100 last:border-b-0"
                :class="{ 'bg-purple-50 text-[#7C3AED]': selectedId == '{{ $nivel->id }}' }">
                <div class="font-medium">Nivel {{ $nivel->nivel }} — {{ $nivel->nombre }}</div>
                <div class="text-xs text-gray-500 mt-0.5">SLA: {{ $nivel->horas_sla }} horas</div>
                @if($nivel->descripcion)
                <div class="text-xs text-gray-400 mt-1 line-clamp-2">{{ $nivel->descripcion }}</div>
                @endif
            </div>
            @empty
            <div class="px-4 py-8 text-center text-gray-500 text-sm">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                No hay niveles disponibles
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar selectedId si hay un valor por defecto
        @if(old($name, $selected))
        setTimeout(() => {
            const component = document.querySelector('[name="{{ $name }}"]')?.closest('[x-data]');
            if (component && component.__x) {
                const nivelId = '{{ old($name, $selected) }}';
                component.__x.$data.selectedId = nivelId;
                @foreach($niveles as $nivel)
                if (nivelId == '{{ $nivel->id }}') {
                    component.__x.$data.selected = 'Nivel {{ $nivel->nivel }} — {{ $nivel->nombre }} (SLA: {{ $nivel->horas_sla }}h)';
                }
                @endforeach
            }
        }, 100);
        @endif
    });
</script>
@endpush