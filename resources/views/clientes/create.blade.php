@extends('plantillas.base')

@section('titulo-pestana', 'Nuevo Cliente')

@section('contenido-principal')

<div class="max-w-2xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class=" py-2 text-2xl md:text-3xl font-bold bg-[#1E1B2E] bg-clip-text text-transparent">
            Registrar nuevo cliente
        </h1>
        <p class="text-gray-500 text-sm mt-1">Ingresa los datos del cliente para registrarlo en el sistema</p>
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
    <form method="POST" action="{{ route('clientes.store') }}" class="-mt-4 bg-white rounded-2xl shadow-lg overflow-hidden">
        @csrf

        <div class=" p-6 space-y-5">
            {{-- Nombre completo --}}
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre completo <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required autofocus
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all"
                        placeholder="Ej: Juan Pérez González" />
                </div>
            </div>

            {{-- Teléfono --}}
            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">
                    Teléfono <span class="text-gray-400 text-xs font-normal">(opcional)</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all"
                        placeholder="Ej: 5512345678" />
                </div>
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email <span class="text-gray-400 text-xs font-normal">(opcional - para notificaciones)</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all"
                        placeholder="Ej: cliente@email.com" />
                </div>
                <p class="mt-1 text-[10px] text-gray-400">Recibirá notificaciones cuando su equipo esté listo</p>
            </div>

            {{-- Dirección --}}
            <div>
                <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">
                    Dirección <span class="text-gray-400 text-xs font-normal">(opcional)</span>
                </label>
                <div class="relative">
                    <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <textarea id="direccion" name="direccion" rows="2"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#7C3AED]/20 focus:border-[#7C3AED] transition-all resize-none"
                        placeholder="Calle, número, colonia, ciudad, código postal">{{ old('direccion') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Botones de acción --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex flex-wrap gap-3">
            <button type="submit" class="bg-[#7C3AED] hover:bg-[#6D28D9] text-white px-6 py-2.5 rounded-xl font-medium transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Guardar cliente
            </button>
            <a href="{{ route('clientes.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-xl font-medium transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection