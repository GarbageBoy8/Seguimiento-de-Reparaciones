<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'FixFlow') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f1eded] dark:bg-[rgb(234,231,231)] text-neutral-800 flex flex-col min-h-screen">

    {{-- HEADER --}}
    <header class="bg-white w-full px-6 lg:px-8 py-4 text-sm sticky top-0 z-50 shadow-sm">
        @if (Route::has('login'))
        <nav class="flex items-center justify-between w-full max-w-7xl mx-auto">
            
            {{-- Espacio izquierdo --}}
            <div class="flex-1 hidden md:block">
                <span class="font-bold text-[#4B0082] text-xl"></span>
            </div>

            {{-- Botones Centrales de Navegación (Anclas para hacer scroll) --}}
            <div class="flex-1 flex justify-center items-center gap-8 font-medium text-neutral-600">
                <a href="#conocenos" class="hover:text-[#4B0082] transition-colors duration-300">Conócenos</a>
                <a href="#reparalo" class="hover:text-[#4B0082] transition-colors duration-300">Repáralo</a>
                <a href="#no-puedo" class="hover:text-[#4B0082] transition-colors duration-300">No puedo</a>
            </div>

            {{-- Botones Derechos Originales --}}
            <div class="flex-1 flex items-center justify-end gap-4">
                @auth
                <a href="{{ url('/dashboard') }}"
                    class="inline-block px-5 py-2 dark:text-[#070707] border-[#19140035] hover:border-[#1915014a] border text-[#000000] rounded-md text-sm font-medium">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}"
                    class="inline-block px-5 py-2 bg-[#4B0082] text-white rounded-md text-sm font-medium hover:bg-[#3A006F] transition-colors shadow-sm">
                    Iniciar Sesión
                </a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="inline-block px-5 py-2 bg-[#4B0082] text-white rounded-md text-sm font-medium hover:bg-[#3A006F] transition-colors shadow-sm">
                    Registrarse
                </a>
                @endif
                @endauth
            </div>
            
        </nav>
        @endif
    </header>

    {{-- SECCIÓN PRINCIPAL (HERO): Ocupa la pantalla al ingresar, centrada y distribuida --}}
    <section class="relative bg-white w-full px-6 lg:px-8 border-b border-neutral-200 min-h-[calc(100vh-80px)] flex items-center py-16 overflow-hidden">
        
        {{-- Efectos de fondo sutiles (resplandores morados desenfocados) --}}
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-[#4B0082]/[0.03] rounded-full blur-3xl pointer-events-none -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-[#4B0082]/[0.04] rounded-full blur-3xl pointer-events-none translate-x-1/3 translate-y-1/3"></div>

        <div class="relative max-w-7xl mx-auto w-full flex flex-col-reverse lg:flex-row items-center justify-between gap-12 lg:gap-20">
            
            {{-- Columna Izquierda: Información --}}
            <div class="flex-1 flex flex-col items-center lg:items-start text-center lg:text-left">

                <h1 class="text-4xl lg:text-5xl lg:text-6xl font-extrabold text-neutral-900 mb-8 leading-tight uppercase tracking-tight">
                    Tu tecnología en <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4B0082] to-[#8042b5]">manos expertas</span>
                </h1>
                
                {{-- Texto con línea de anclaje sutil a la izquierda en pantallas grandes --}}
                <div class="relative pl-0 lg:pl-6 lg:border-l-4 border-[#4B0082]/30">
                    <p class="text-lg lg:text-xl text-neutral-600 leading-relaxed text-justify lg:text-left">
                        Sabemos que tu tiempo es tan valioso como tu tecnología, por eso en FixFlow hemos eliminado las esperas en mostradores y los traslados innecesarios. La distancia no impide la cercanía: podrás supervisar cada etapa del diagnóstico, autorizar presupuestos y despejar dudas en tiempo real, manteniendo el control total de la reparación desde la palma de tu mano.
                    </p>
                </div>
            </div>

            {{-- Columna Derecha: Tu Logotipo --}}
            <div class="relative flex-1 flex justify-center lg:justify-end w-full">
                {{-- Sombra base y resplandor sutil para el logo --}}
                <div class="absolute inset-0 bg-gradient-to-tr from-[#4B0082]/10 via-transparent to-transparent rounded-full blur-2xl -z-10 scale-110"></div>
                <img src="{{ asset('assets/logo-fix-flow.png') }}" alt="Logo FixFlow" class="w-full max-w-[350px] md:max-w-[450px] lg:max-w-[600px] h-auto object-contain drop-shadow-xl hover:scale-[1.02] transition-transform duration-500">
            </div>

        </div>
    </section>

   