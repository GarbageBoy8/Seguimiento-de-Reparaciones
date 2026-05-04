@props([
'name',
'id' => null,
'options' => [],
'selected' => null,
'placeholder' => '— Seleccione —',
'showCreate' => true,
'createText' => 'Nuevo'
])

@php
$id = $id ?? $name;
@endphp

<div x-data="{ 
    open: false, 
    selected: null,
    selectedId: '{{ $selected }}'
}" class="relative">

    <!-- Botón selector -->
    <button
        type="button"
        @click="open = !open"
        class="w-full px-4 py-2 text-left bg-white rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all flex justify-between items-center hover:border-gray-400">
        <span x-text="selected ? selected : '{{ $placeholder }}'" class="truncate"></span>
        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Dropdown -->
    <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow-lg border border-gray-200 max-h-60 overflow-y-auto">
        <div class="py-1">
            @if($showCreate)
            <div
                @click="selected = null; selectedId = ''; open = false"
                class="px-4 py-2 hover:bg-purple-50 hover:text-[#7C3AED] cursor-pointer transition-colors flex items-center gap-2"
                :class="{ 'bg-purple-50 text-[#7C3AED]': selectedId === '' }">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>{{ $createText }}</span>
            </div>
            @endif

            {{ $slot ?? '' }}

            @foreach($options as $optionValue => $optionLabel)
            <div
                @click="selected = '{{ is_array($optionLabel) ? $optionLabel['label'] : $optionLabel }}'; selectedId = '{{ $optionValue }}'; open = false"
                class="px-4 py-2 hover:bg-purple-50 hover:text-[#7C3AED] cursor-pointer transition-colors"
                :class="{ 'bg-purple-50 text-[#7C3AED]': selectedId == '{{ $optionValue }}' }">
                @if(is_array($optionLabel))
                <div class="font-medium">{{ $optionLabel['label'] }}</div>
                @if(isset($optionLabel['subtitle']))
                <div class="text-xs text-gray-500">{{ $optionLabel['subtitle'] }}</div>
                @endif
                @else
                {{ $optionLabel }}
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <input type="hidden" name="{{ $name }}" x-model="selectedId">
</div>