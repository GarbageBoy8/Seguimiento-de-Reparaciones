@extends('plantillas.base')

@section('titulo-pestana', 'Nueva Orden')

@section('contenido-principal')

<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold bg-[#1E1B2E] bg-clip-text text-transparent">
            Nueva orden de reparación
        </h1>
        <p class="text-gray-500 text-sm mt-1">Completa todos los campos para registrar la orden</p>
    </div>

    {{-- Errores de validación --}}
    @if($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4" role="alert">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <p class="font-semibold text-red-800 mb-2">Por favor corrige los siguientes errores:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="text-red-700 text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Formulario --}}
    <form method="POST" action="{{ route('reparaciones.store') }}" class="space-y-6">
        @csrf

        {{-- BLOQUE 1: Datos del cliente --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#7C3AED]/5 to-[#EC4899]/5 px-6 py-4 border-b border-gray-100">
                <legend class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Datos del cliente
                </legend>
            </div>
            <div class="p-6 space-y-4">
                {{-- Selector de cliente existente --}}
                <div>
                    <label for="cliente_id" class="block text-sm font-medium text-gray-700 mb-1">Buscar cliente existente <span class="text-gray-400 text-xs font-normal">(opcional)</span></label>
                    <x-custom-select
                        name="cliente_id"
                        :options="$clientes->pluck('nombre', 'id')->toArray()"
                        :selected="old('cliente_id')"
                        placeholder="Nuevo cliente"
                        :show-create="true"
                        create-text=" Crear nuevo cliente" />
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-xl p-3">
                    <p class="text-amber-700 text-xs flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Si seleccionas un cliente existente, los campos de abajo se ignorarán.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="cliente_nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                        <input type="text" id="cliente_nombre" name="cliente_nombre" value="{{ old('cliente_nombre') }}"
                            class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all" />
                    </div>
                    <div>
                        <label for="cliente_telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" id="cliente_telefono" name="cliente_telefono" value="{{ old('cliente_telefono') }}"
                            class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all" />
                    </div>
                    <div class="md:col-span-2">
                        <label for="cliente_email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-gray-400 text-xs">(para notificaciones)</span></label>
                        <input type="email" id="cliente_email" name="cliente_email" value="{{ old('cliente_email') }}"
                            class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all" />
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE 2: Datos del dispositivo --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#7C3AED]/5 to-[#EC4899]/5 px-6 py-4 border-b border-gray-100">
                <legend class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 3h14a2 2 0 01-2 2H7a2 2 0 01-2-2zm0 0v16a2 2 0 002 2h10a2 2 0 002-2V5"></path>
                    </svg>
                    Datos del dispositivo
                </legend>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        
                        <!-- Con valores personalizados -->
                        <x-tipo-equipo-select
                            name="tipo_equipo"
                            :selected="old('tipo_equipo', 'Laptop')"
                            :required="true" />
                    </div>
                    <div>
                        <label for="marca" class="block text-sm font-medium text-gray-700 mb-1">Marca <span class="text-red-500">*</span></label>
                        <input type="text" id="marca" name="marca" value="{{ old('marca') }}" required
                            class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all" />
                    </div>
                    <div>
                        <label for="modelo" class="block text-sm font-medium text-gray-700 mb-1">Modelo <span class="text-red-500">*</span></label>
                        <input type="text" id="modelo" name="modelo" value="{{ old('modelo') }}" required
                            class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all" />
                    </div>
                    <div>
                        <label for="numero_serie" class="block text-sm font-medium text-gray-700 mb-1">Número de serie <span class="text-gray-400 text-xs">(opcional)</span></label>
                        <input type="text" id="numero_serie" name="numero_serie" value="{{ old('numero_serie') }}"
                            class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all" />
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE 3: Nivel y técnico --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#7C3AED]/5 to-[#EC4899]/5 px-6 py-4 border-b border-gray-100">
                <legend class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Clasificación de la reparación
                </legend>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="nivel_id" class="block text-sm font-medium text-gray-700 mb-1">Nivel de reparación <span class="text-red-500">*</span></label>
                    <select id="nivel_id" name="nivel_id" required class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all">
                        <option value="">— Seleccionar nivel —</option>
                        @foreach($niveles as $nivel)
                        <option value="{{ $nivel->id }}" {{ old('nivel_id') == $nivel->id ? 'selected' : '' }}>
                            Nivel {{ $nivel->nivel }} — {{ $nivel->nombre }} (SLA: {{ $nivel->horas_sla }}h)
                        </option>
                        @endforeach
                    </select>
                    <div id="descripcion-nivel" class="mt-2 text-xs text-gray-500 bg-gray-50 p-2 rounded-lg">
                        Selecciona un nivel para ver su descripción.
                    </div>
                </div>

                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Técnico asignado <span class="text-gray-400 text-xs">(opcional)</span></label>
                    <select id="user_id" name="user_id" class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all">
                        <option value="">— Sin asignar —</option>
                        @foreach($tecnicos as $tecnico)
                        <option value="{{ $tecnico->id }}" {{ old('user_id') == $tecnico->id ? 'selected' : '' }}>
                            {{ $tecnico->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- BLOQUE 4: Problema y costo --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#7C3AED]/5 to-[#EC4899]/5 px-6 py-4 border-b border-gray-100">
                <legend class="text-lg font-semibold text-[#2D1B69] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Descripción del problema
                </legend>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="problema_reportado" class="block text-sm font-medium text-gray-700 mb-1">Problema reportado por el cliente <span class="text-red-500">*</span></label>
                    <textarea id="problema_reportado" name="problema_reportado" rows="4" required
                        class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all resize-none">{{ old('problema_reportado') }}</textarea>
                </div>
                <div>
                    <label for="costo_estimado" class="block text-sm font-medium text-gray-700 mb-1">Costo estimado <span class="text-gray-400 text-xs">(opcional)</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                        <input type="number" id="costo_estimado" name="costo_estimado" value="{{ old('costo_estimado') }}" step="0.01" min="0"
                            class="w-full pl-7 pr-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Botones de acción --}}
        <div class="flex flex-wrap gap-4 pt-4">
            <button type="submit" class="bg-[#7C3AED] hover:bg-[#6D28D9] text-white px-6 py-2.5 rounded-xl font-medium transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Crear orden
            </button>
            <a href="{{ route('panel.inicio') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-xl font-medium transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Cancelar
            </a>
        </div>
    </form>
</div>
<!--     -->
{{-- Datos de niveles para JS (descripción dinámica) --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const selectNivel = document.getElementById('nivel_id');
        const descNivel = document.getElementById('descripcion-nivel');

        if (selectNivel && descNivel) {
            selectNivel.addEventListener('change', function() {
                const nivel = niveles[this.value];
                if (nivel) {
                    descNivel.innerHTML = `
                        <div class="flex items-start gap-2">
                            <span class="text-[#7C3AED]">📋</span>
                            <div>
                                <strong class="font-medium text-gray-700">${nivel.nombre}</strong>
                                <p class="text-gray-500 text-xs mt-0.5">${nivel.descripcion || 'Sin descripción adicional'}</p>
                                <span class="inline-block mt-1 text-[10px] bg-[#7C3AED]/10 text-[#7C3AED] px-2 py-0.5 rounded-full">⏱️ Tiempo estimado: ${nivel.horas_sla} horas</span>
                            </div>
                        </div>
                    `;
                } else {
                    descNivel.innerHTML = 'Selecciona un nivel para ver su descripción.';
                }
            });

            // Trigger inicial si hay un valor seleccionado
            if (selectNivel.value) {
                selectNivel.dispatchEvent(new Event('change'));
            }
        }
    });
</script>
@endpush
@endsection