<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'FixFlow') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Estilo personalizado para el patrón tecnológico (Circuito) --}}
    <style>
        .bg-circuit {
            background-image: url("data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cg stroke='rgba(255, 255, 255, 0.05)' stroke-width='1.5' fill='none'%3E%3Cpath d='M0 60h30l20 20h40l20-20h10M30 60v30l20 20M70 80v30M90 60v-30l-20-20'/%3E%3Ccircle cx='30' cy='60' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='50' cy='80' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='70' cy='80' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='90' cy='60' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='50' cy='110' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='70' cy='10' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 120px 120px;
        }
    </style>
</head>

<body class="bg-[#f1eded] text-neutral-800 flex flex-col min-h-screen">

    {{-- HEADER --}}
    <header class="bg-white w-full px-6 lg:px-8 py-4 text-sm sticky top-0 z-50 shadow-sm border-b border-neutral-200">
        @if (Route::has('login'))
        <nav class="flex items-center justify-between w-full max-w-7xl mx-auto">
            
            <div class="flex-1 hidden md:block">
                <span class="font-bold text-[#4B0082] text-xl tracking-tight">FixFlow</span>
            </div>

            <div class="flex-1 flex justify-center items-center gap-8 font-medium text-neutral-600">
                <a href="#conocenos" class="hover:text-[#4B0082] transition-colors duration-300">Conócenos</a>
                <a href="#reparalo" class="hover:text-[#4B0082] transition-colors duration-300">Repáralo</a>
                <a href="#no-puedo" class="hover:text-[#4B0082] transition-colors duration-300">No puedo</a>
            </div>

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

    {{-- WRAPPER GLOBAL PARA EL TEMA OSCURO --}}
    <div class="relative flex-1 bg-gradient-to-br from-[#2D004E] via-[#4B0082] to-[#1A0033] w-full flex flex-col overflow-hidden">
        
        {{-- Fondo de circuito global --}}
        <div class="absolute inset-0 bg-circuit opacity-50 pointer-events-none"></div>
        
        {{-- Resplandores --}}
        <div class="absolute top-[-5%] left-[-10%] w-[500px] h-[500px] bg-[#9D4EDD]/20 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute top-[20%] right-[-10%] w-[600px] h-[600px] bg-[#7B2CBF]/20 rounded-full blur-[120px] pointer-events-none"></div>

        {{-- SECCIÓN PRINCIPAL (HERO) --}}
        <section class="relative w-full px-6 lg:px-8 py-20 lg:py-28 flex items-center z-10">
            <div class="relative max-w-7xl mx-auto w-full flex flex-col lg:flex-row items-center justify-between gap-16 lg:gap-8">
                
                {{-- Columna Izquierda: Información --}}
                <div class="flex-1 flex flex-col items-center lg:items-start text-center lg:text-left z-10">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-[#E0AAFF] text-xs font-semibold uppercase tracking-widest mb-8 shadow-sm backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span>
                        Plataforma para Talleres
                    </div>

                    <h1 class="text-4xl lg:text-5xl xl:text-6xl font-extrabold text-white mb-6 leading-[1.1] uppercase tracking-tight">
                        ​Control Inteligente <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#E0AAFF] to-[#C77DFF]">​Para tu Taller</span>
                    </h1>
                    
                    <p class="text-lg lg:text-xl text-white/80 leading-relaxed text-justify lg:text-left max-w-2xl">
FixFlow es el sistema integral diseñado para agilizar tus procesos técnicos. Registra equipos, da seguimiento en tiempo real a las reparaciones y gestiona tu inventario con profesionalismo.                    </p>

                    <div class="mt-10 flex items-center gap-4">
                        <div class="flex -space-x-3">
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha: Centro de Mando --}}
                <div class="relative flex-1 w-full max-w-lg lg:max-w-xl xl:max-w-2xl mx-auto z-10">
                    <div class="absolute inset-0 bg-[#000000] translate-y-6 blur-2xl opacity-40 rounded-[2rem] -z-10"></div>
                    
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-6 lg:p-8 shadow-2xl relative overflow-hidden group">
                        {{-- Patrón interior de la tarjeta --}}
                        <div class="absolute inset-0 bg-circuit opacity-40 mix-blend-overlay transition-opacity duration-500 group-hover:opacity-70 pointer-events-none"></div>
                        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>

                        <div class="relative z-10">
                            <div class="flex justify-between items-center mb-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shadow-inner border border-white/5 backdrop-blur-md">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-white font-bold text-lg tracking-wide">Centro de Mando</h3>
                                        <p class="text-[#E0AAFF]/70 text-sm">Resumen de hoy</p>
                                    </div>
                                </div>
                                <div class="px-3 py-1.5 rounded-full bg-white/10 text-white text-xs font-medium flex items-center gap-2 border border-white/10 backdrop-blur-md">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    En vivo
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-black/30 backdrop-blur-md rounded-2xl p-5 border border-white/5 transition-transform hover:-translate-y-1 duration-300 relative overflow-hidden">
                                    <p class="text-[#E0AAFF]/80 text-sm font-medium mb-2 relative z-10">Órdenes Activas</p>
                                    <p class="text-4xl font-extrabold text-white relative z-10">24</p>
                                </div>
                                <div class="bg-black/30 backdrop-blur-md rounded-2xl p-5 border border-white/5 transition-transform hover:-translate-y-1 duration-300 relative overflow-hidden">
                                    <p class="text-[#E0AAFF]/80 text-sm font-medium mb-2 relative z-10">Listos para Entrega</p>
                                    <p class="text-4xl font-extrabold text-emerald-400 drop-shadow-[0_0_10px_rgba(52,211,153,0.3)] relative z-10">8</p>
                                </div>
                            </div>

                            <div class="bg-black/30 backdrop-blur-md rounded-2xl p-5 border border-white/5 relative overflow-hidden">
                                <div class="relative z-10 flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="text-white font-semibold text-sm">MacBook Pro 16" - M1 Max</h4>
                                        <p class="text-[#E0AAFF]/60 text-xs mt-1">Ticket #8920 • Juan Pérez</p>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-md bg-amber-500/20 text-amber-400 text-[10px] font-bold uppercase tracking-wider border border-amber-500/30">En Taller</span>
                                </div>
                                
                                <div class="relative z-10 w-full bg-white/10 rounded-full h-2 mb-3 overflow-hidden">
                                    <div class="bg-gradient-to-r from-[#9D4EDD] to-[#E0AAFF] h-full rounded-full w-[75%] relative">
                                        <div class="absolute inset-0 bg-white/20 animate-[pulse_2s_ease-in-out_infinite]"></div>
                                    </div>
                                </div>
                                
                                <div class="relative z-10 flex justify-end items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    <p class="text-[11px] text-[#E0AAFF]/80 font-medium">Diagnóstico completado</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- CONTENEDOR DE SECCIONES INFERIORES --}}
        <main class="relative z-10 w-full max-w-7xl mx-auto pb-24 pt-8 space-y-16 px-6 lg:px-8">

            {{-- SECCIÓN: CONÓCENOS --}}
            <section id="conocenos" class="scroll-mt-24 w-full">
                <div class="relative max-w-4xl mx-auto text-center bg-white/5 backdrop-blur-xl p-10 md:p-12 rounded-2xl border border-white/10 border-t-4 border-t-[#4B0082] shadow-2xl shadow-black/20 transition-all hover:-translate-y-1 hover:border-white/20 overflow-hidden group">
                    <div class="absolute inset-0 bg-circuit opacity-40 mix-blend-overlay transition-opacity duration-500 group-hover:opacity-70 pointer-events-none"></div>
                    
                    <div class="relative z-10">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-[#E0AAFF]/10 text-white border border-[#E0AAFF]/20 text-xs font-bold uppercase tracking-wider mb-4 backdrop-blur-sm">
                            Nuestra Identidad
                        </span>
                        <h2 class="text-3xl font-bold text-white mb-6 drop-shadow-sm">Conócenos</h2>
                        <p class="text-lg text-white/90 leading-relaxed">
                            Somos FixFlow, tu sistema gestor de reparaciones electrónicas. Aquí puedes colocar la información sobre la misión y visión de tu taller o sistema. Nuestro objetivo es optimizar el flujo de trabajo para que nunca pierdas el rastro de un equipo.
                        </p>
                    </div>
                </div>
            </section>

            {{-- SECCIÓN: REPÁRALO --}}
            <section id="reparalo" class="scroll-mt-24 w-full">
                <div class="relative max-w-4xl mx-auto text-center bg-white/5 backdrop-blur-xl p-10 md:p-12 rounded-2xl border border-white/10 border-t-4 border-t-[#4B0082] shadow-2xl shadow-black/20 transition-all hover:-translate-y-1 hover:border-white/20 overflow-hidden group">
                    <div class="absolute inset-0 bg-circuit opacity-40 mix-blend-overlay transition-opacity duration-500 group-hover:opacity-70 pointer-events-none"></div>

                    <div class="relative z-10">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-[#E0AAFF]/10 text-white border border-[#E0AAFF]/20 text-xs font-bold uppercase tracking-wider mb-4 backdrop-blur-sm">
                            Autogestión
                        </span>
                        <h2 class="text-3xl font-bold text-white mb-6 drop-shadow-sm">Repáralo</h2>
                        <p class="text-lg text-white/90 leading-relaxed">
                            ¿Eres técnico o quieres intentar arreglarlo tú mismo? En esta sección puedes incluir tutoriales, venta de refacciones, guías de diagramas esquemáticos o los pasos a seguir para diagnosticar un equipo electrónico.
                        </p>
                    </div>
                </div>
            </section>

            {{-- SECCIÓN: NO PUEDO --}}
            <section id="no-puedo" class="scroll-mt-24 w-full">
                <div class="relative max-w-4xl mx-auto text-center bg-white/5 backdrop-blur-xl p-10 md:p-12 rounded-2xl border border-white/10 border-t-4 border-t-[#4B0082] shadow-2xl shadow-black/20 transition-all hover:-translate-y-1 hover:border-white/20 overflow-hidden group">
                    <div class="absolute inset-0 bg-circuit opacity-40 mix-blend-overlay transition-opacity duration-500 group-hover:opacity-70 pointer-events-none"></div>

                    <div class="relative z-10">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-[#E0AAFF]/10 text-white border border-[#E0AAFF]/20 text-xs font-bold uppercase tracking-wider mb-4 backdrop-blur-sm">
                            Asistencia Experta
                        </span>
                        <h2 class="text-3xl font-bold text-white mb-6 drop-shadow-sm">No puedo</h2>
                        <p class="text-lg text-white/90 leading-relaxed mb-8">
                            ¿La reparación se complicó? No te preocupes, nosotros nos encargamos. Trae tu equipo y déjalo en manos de nuestros expertos.
                        </p>
                    </div>
                </div>
            </section>

        </main>

        {{-- FOOTER --}}
        <footer class="relative z-10 w-full px-6 py-8 text-center border-t border-white/10 mt-auto backdrop-blur-sm bg-black/10">
            <p class="text-sm text-white/60">
                &copy; {{ date('Y') }}. Todos los derechos reservados.
            </p>
        </footer>

    </div>
</body>

</html>