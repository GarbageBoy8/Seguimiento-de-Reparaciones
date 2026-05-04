@props([
    'name' => 'tipo_equipo',
    'selected' => null,
    'required' => false
])

@php
    $selected = old($name, $selected);
@endphp

<div x-data="tipoEquipoSelect(@js($selected))" class="space-y-3">
    <label class="block text-sm font-semibold text-gray-700 mb-3">
        TIPO DE DISPOSITIVO
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
        @foreach($tipos() as $valor => $config)
            <button
                type="button"
                @click="select('{{ $valor }}')"
                class="relative group transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:ring-offset-2 rounded-xl"
            >
                <div 
                    class="p-4 rounded-xl border-2 transition-all duration-200 w-full"
                    :class="{
                        'border-[#7C3AED] bg-purple-50 shadow-md': selected === '{{ $valor }}',
                        'border-gray-200 hover:border-[#7C3AED] hover:bg-purple-50': selected !== '{{ $valor }}'
                    }"
                >
                    <div class="flex flex-col items-center text-center space-y-2">
                        <!-- Icono - Negro por defecto, morado en hover y seleccionado -->
                        <svg 
                            class="w-8 h-8 transition-colors duration-200"
                            :class="{ 
                                'text-[#7C3AED]': selected === '{{ $valor }}',
                                'text-gray-900 group-hover:text-[#7C3AED]': selected !== '{{ $valor }}'
                            }"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"/>
                        </svg>
                        
                        <!-- Texto - Negro por defecto, morado en hover y seleccionado -->
                        <span 
                            class="text-sm font-medium transition-colors duration-200"
                            :class="{ 
                                'text-[#7C3AED]': selected === '{{ $valor }}',
                                'text-gray-900 group-hover:text-[#7C3AED]': selected !== '{{ $valor }}'
                            }"
                        >
                            {{ $valor }}
                        </span>
                        
                        <!-- Indicador de selección -->
                        <div 
                            x-show="selected === '{{ $valor }}'"
                            class="absolute -top-1 right-1"
                            x-transition
                        >
                            <svg class="w-5 h-5 text-[#7C3AED]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </button>
        @endforeach
    </div>
    
    <!-- Input hidden para enviar el valor -->
    <input type="hidden" name="{{ $name }}" x-model="selected" @if($required) required @endif>
</div>

<script>
    function tipoEquipoSelect(initialValue) {
        return {
            selected: initialValue || '',
            select(value) {
                this.selected = value;
            }
        }
    }
</script>