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
        [x-cloak] {
            display: none !important;
        }

        .bg-circuit {
            background-image: url("data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cg stroke='rgba(255, 255, 255, 0.05)' stroke-width='1.5' fill='none'%3E%3Cpath d='M0 60h30l20 20h40l20-20h10M30 60v30l20 20M70 80v30M90 60v-30l-20-20'/%3E%3Ccircle cx='30' cy='60' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='50' cy='80' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='70' cy='80' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='90' cy='60' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='50' cy='110' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='70' cy='10' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 120px 120px;
        }
    </style>
</head>

<body class="bg-[#1A0033] text-neutral-800 flex flex-col min-h-screen">

    {{-- HEADER --}}
    <header class="bg-white w-full lg:px-8 text-sm sticky top-0 z-50">
        @if (Route::has('login'))
        <nav class="bg-white/95 backdrop-blur-sm px-6 py-4 flex justify-between items-center w-full shadow-sm border-b border-gray-100">
            <div class="flex items-center">
                <a href="/" class="text-3xl font-extrabold tracking-tight text-[#4B0082] md:text-4xl">FixFlow</a>
            </div>



            <div class="hidden items-center space-x-4 md:flex">
                @auth
                <a href="{{ route('panel.inicio') }}" class="px-5 py-2.5 rounded-lg text-white bg-[#4B0082] font-semibold hover:bg-[#5A00C6] transition-colors shadow-md hover:shadow-lg">
                    Centro de Mando
                </a>
                @else
                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-lg text-white bg-[#4B0082] font-semibold hover:bg-[#5A00C6] transition-colors shadow-md hover:shadow-lg">
                    Iniciar Sesión
                </a>
                @endauth
            </div>

            <button type="button" @click="open = !open" class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#4B0082] text-white shadow-sm transition hover:bg-[#5A00C6] md:hidden" aria-label="Abrir menú">
                <svg x-show="!open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-cloak x-show="open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            </div>

            <div x-cloak x-show="open" x-transition @click.outside="open = false" class="absolute left-4 right-4 top-full mt-2 rounded-2xl border border-gray-100 bg-white p-3 shadow-xl md:hidden">
                <div class="flex flex-col gap-1">
                    <a href="#optimiza" @click="open = false" class="rounded-xl px-4 py-3 font-medium text-neutral-700 hover:bg-purple-50 hover:text-[#4B0082]">Optimiza tu taller</a>
                    <a href="#gestiona" @click="open = false" class="rounded-xl px-4 py-3 font-medium text-neutral-700 hover:bg-purple-50 hover:text-[#4B0082]">Gestiona</a>
                    <a href="#agilidad" @click="open = false" class="rounded-xl px-4 py-3 font-medium text-neutral-700 hover:bg-purple-50 hover:text-[#4B0082]">Agilidad</a>
                    @auth
                    <a href="{{ route('panel.inicio') }}" class="mt-2 rounded-xl bg-[#4B0082] px-4 py-3 text-center font-semibold text-white shadow-md transition hover:bg-[#5A00C6]">Centro de Mando</a>
                    @else
                    <a href="{{ route('login') }}" class="mt-2 rounded-xl bg-[#4B0082] px-4 py-3 text-center font-semibold text-white shadow-md transition hover:bg-[#5A00C6]">Iniciar Sesión</a>
                    @endauth
                </div>
            </div>
        </nav>
        @endif
    </header>


    {{-- 1. SECCIÓN DE LAS IMÁGENES (HERO VIBRANTE) --}}
    <div class="relative w-full bg-gradient-to-br from-[#2D004E] via-[#4B0082] to-[#1A0033] flex flex-col overflow-hidden rounded-b-[45px] sm:rounded-b-[75px] lg:rounded-b-[115px] shadow-[0_20px_50px_rgba(0,0,0,0.3)] z-20 pb-28 lg:pb-36">
        
        <div class="absolute inset-0 bg-circuit opacity-40 pointer-events-none"></div>

        <div class="absolute top-[-5%] left-[-10%] w-[500px] h-[500px] bg-[#9D4EDD]/20 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute top-[20%] right-[-10%] w-[600px] h-[600px] bg-[#7B2CBF]/20 rounded-full blur-[120px] pointer-events-none"></div>

        <section class="relative w-full px-4 lg:px-12 pt-16 pb-6 flex items-center z-10">
            <div class="relative max-w-[90rem] mx-auto w-full flex flex-col lg:flex-row items-center justify-between gap-16 lg:gap-12 xl:gap-20">

                <div class="w-full lg:w-[45%] flex flex-col items-center lg:items-start text-center lg:text-left z-10">
                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-[#E0AAFF] shadow-sm backdrop-blur-sm md:mb-8">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span>
                        Plataforma para Talleres
                    </div>

                    <h1 class="mb-5 text-4xl font-extrabold uppercase leading-[1.08] tracking-tight text-white sm:text-5xl lg:mb-6 lg:text-5xl xl:text-6xl">
                        Control Inteligente <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#E0AAFF] to-[#C77DFF]">Para tu Taller</span>
                    </h1>

                    <p class="max-w-2xl text-left text-base leading-relaxed text-white/95 sm:text-lg lg:text-left lg:text-2xl">
                        FixFlow es el sistema integral diseñado para agilizar tus procesos técnicos. Registra equipos, da seguimiento en tiempo real a los estados de cada reparación y mantén el control total de tu flujo de trabajo con profesionalismo.
                    </p>
                </div>

                <div class="relative w-full lg:w-[55%] h-[400px] sm:h-[480px] lg:h-[500px] flex items-center justify-center z-10 lg:pl-10 mt-12 lg:mt-0">
                    <div class="absolute inset-0 bg-gradient-to-tr from-[#7B2CBF]/10 via-[#9D4EDD]/5 to-transparent blur-3xl -z-10 rounded-full scale-75"></div>

                    <div class="relative w-full h-full max-w-2xl mx-auto flex items-center justify-center">
                        <div class="absolute left-0 top-6 w-[58%] z-10 opacity-75 shadow-2xl rounded-2xl border border-white/10 overflow-hidden transform -rotate-3 -translate-x-6 translate-y-4 transition-all duration-500 ease-out hover:opacity-100 hover:-translate-y-12 hover:scale-105 hover:z-30 group">
                            <img src="{{ asset('assets/ordenes.jpg') }}" alt="Órdenes de Reparación" class="w-full h-auto object-cover">
                        </div>

                        <div class="absolute right-0 top-2 w-[58%] z-10 opacity-75 shadow-2xl rounded-2xl border border-white/10 overflow-hidden transform rotate-3 translate-x-6 translate-y-4 transition-all duration-500 ease-out hover:opacity-100 hover:-translate-y-12 hover:scale-105 hover:z-30 group">
                            <img src="{{ asset('assets/clientes.jpg') }}" alt="Clientes del Taller" class="w-full h-auto object-cover">
                        </div>

                        <div class="absolute w-[78%] z-20 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.7)] rounded-2xl border-2 border-[#7B2CBF]/40 overflow-hidden transform transition-transform duration-300 hover:scale-[1.01]">
                            <img src="{{ asset('assets/centro-de-mando.jpg') }}" alt="Centro de Mando Principal" class="w-full h-auto object-cover">
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>


    {{-- 2. SECCIÓN MAIN CON FONDO BLANCO LIMPIO --}}
    <main id="porque-elegir" class="w-full bg-white text-[#1A1A1A] pt-[150px] md:pt-[200px] pb-32 px-6 lg:px-12 relative z-10 -mt-[90px] sm:-mt-[120px]">
        <div class="max-w-[85rem] mx-auto w-full">

            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#0D0D11] tracking-tight uppercase">
                    ¿Por qué elegir <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4B0082] to-[#7B2CBF]">FixFlow</span>?
                </h2>
                <div class="w-16 h-1 bg-gradient-to-r from-[#7B2CBF] to-[#C77DFF] mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 xl:gap-12">

                {{-- Card 1 --}}
                <div class="flex flex-col items-center lg:items-start text-center lg:text-left group transition-transform duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-6 shadow-sm group-hover:shadow-md transition-all">
                        <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-6 18.75h9"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#0D0D11] mb-3 tracking-tight group-hover:text-[#4B0082] transition-colors">
                        Taller en tu Bolsillo
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-light text-justify lg:text-left">
                        Accede a tu plataforma desde cualquier smartphone o tablet. Modifica el estatus de las reparaciones, añade notas de servicio y actualiza órdenes de forma ágil desde el mismo vehículo.
                    </p>
                </div>

                {{-- Card 2 (SVG DE MINING SERVICE CORREGIDO) --}}
                <div class="flex flex-col items-center lg:items-start text-center lg:text-left group transition-transform duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-6 shadow-sm group-hover:shadow-md transition-all">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#0D0D11] mb-3 tracking-tight group-hover:text-[#4B0082] transition-colors">
                        Flujo de Órdenes Nítido
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-light text-justify lg:text-left">
                        Mantén un registro transparente del ciclo de vida de cada equipo. Desde la recepción inicial y el diagnóstico básico, hasta la entrega final reparada, sin perder ningún detalle técnico en el camino.
                    </p>
                </div>

                {{-- Card 3 --}}
                <div class="flex flex-col items-center lg:items-start text-center lg:text-left group transition-transform duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center mb-6 shadow-sm group-hover:shadow-md transition-all">
                        <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.286zm0 0v1.5"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#0D0D11] mb-3 tracking-tight group-hover:text-[#4B0082] transition-colors">
                        Historiales Protegidos
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-light text-justify lg:text-left">
                        La información de tus clientes y las especificaciones de sus dispositivos se guardan de forma centralizada y encriptada. Olvídate de los papeles perdidos o de las confusiones en los diagnósticos.
                    </p>
                </div>

                {{-- Card 4 --}}
                <div class="flex flex-col items-center lg:items-start text-center lg:text-left group transition-transform duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center mb-6 shadow-sm group-hover:shadow-md transition-all">
                        <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#0D0D11] mb-3 tracking-tight group-hover:text-[#4B0082] transition-colors">
                        Productividad al Máximo
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-light text-justify lg:text-left">
                        Optimiza el rendimiento de tu personal asignando mecánicos o técnicos específicos a tareas concretas. Monitorea los tiempos de resolución para acelerar de forma drástica las entregas.
                    </p>
                </div>

            </div>
        </div>

        {{-- Curva de corte cóncava sólida --}}
        <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-[0] z-20 pointer-events-none">
            <svg class="relative block w-[calc(100%+1.5px)] h-[40px] sm:h-[60px] md:h-[90px] -mb-[1.5px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0 Q600,120 1200,0 L1200,120 L0,120 Z" fill="#1A0033"></path>
            </svg>
        </div>
    </main>


    {{-- 3. SECCIÓN LLAMADA A LA ACCIÓN (CTA CONTINUO) --}}
    <section class="relative w-full bg-gradient-to-b from-[#1A0033] via-[#2A0054] to-[#110022] pt-24 pb-16 px-4 lg:px-12 overflow-hidden z-10">

        <div class="absolute inset-0 bg-circuit opacity-35 pointer-events-none"></div>

        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-[#7B2CBF]/15 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="relative max-w-4xl mx-auto text-center z-10 flex flex-col items-center">

            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-[#E0AAFF] text-xs font-semibold uppercase tracking-widest mb-6 shadow-sm backdrop-blur-sm">
                ¿Listo para empezar?
            </div>

            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6 tracking-tight uppercase leading-tight">
                Lleva la administración de tu taller <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#E0AAFF] via-[#C77DFF] to-[#9D4EDD]">al siguiente nivel</span>
            </h2>

            <p class="text-lg md:text-xl text-white/70 max-w-2xl mb-10 font-light leading-relaxed">
                Ponte en contacto con nuestro equipo de soporte técnico para solicitar tus credenciales de acceso, agendar una demostración personalizada o resolver cualquier duda sobre la plataforma.
            </p>

            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-[#7B2CBF] to-[#C77DFF] rounded-xl blur-md opacity-75 group-hover:opacity-100 transition duration-300 group-hover:blur-lg"></div>
                <a href="https://wa.me/tu-numero-aqui" target="_blank" class="relative inline-flex items-center gap-3 px-8 py-4 bg-[#0D0D11] hover:bg-transparent border border-white/10 text-white font-bold text-base rounded-xl transition-all duration-300 transform group-hover:scale-[1.02] tracking-wide uppercase">
                    <svg class="w-5 h-5 text-[#E0AAFF]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.222 3.419.169l2.242 1.616a.75.75 0 001.208-.588V16.5h.062a48.756 48.756 0 006.988-.564c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"></path>
                    </svg>
                    Contactar al Equipo
                </a>
            </div>

        </div>
    </section>


    {{-- 4. SECCIÓN DE PRECIOS CONTINUA --}}
    <section id="precios" class="relative w-full bg-gradient-to-b from-[#110022] to-[#0A0018] pb-24 px-4 lg:px-12 overflow-hidden z-10">
        
        <div class="absolute inset-0 bg-circuit opacity-35 pointer-events-none"></div>
        
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-[#4B0082]/15 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="relative max-w-6xl mx-auto w-full z-10">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight uppercase">
                    Planes hechos a tu <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#E0AAFF] to-[#C77DFF]">medida</span>
                </h2>
                <div class="w-16 h-1 bg-gradient-to-r from-[#7B2CBF] to-[#C77DFF] mx-auto mt-4 rounded-full"></div>
                <p class="text-white/60 mt-4 font-light text-base max-w-xl mx-auto">
                    Muy pronto podrás elegir el plan que mejor se adapte al volumen de reparaciones y al tamaño de tu equipo técnico.
                </p>
            </div>

            <div class="relative">
                
                <div class="absolute inset-0 bg-white/[0.02] backdrop-blur-[5px] z-30 flex flex-col items-center justify-center rounded-3xl p-6">
                    <div class="px-6 py-3 rounded-2xl bg-gradient-to-r from-[#7B2CBF] to-[#9D4EDD] text-white font-bold text-lg md:text-xl uppercase tracking-widest shadow-[0_0_30px_rgba(123,44,191,0.5)] animate-bounce">
                        🚀 Próximamente
                    </div>
                    <p class="text-white/90 text-center mt-4 max-w-sm text-sm md:text-base font-medium drop-shadow-md">
                        Estamos ultimando los detalles de nuestras pasarelas de pago automatizadas.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 opacity-25 select-none pointer-events-none">
                    
                    <div class="bg-white/5 border border-white/10 rounded-2xl p-8 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2 uppercase tracking-wide">Esencial</h3>
                            <p class="text-white/50 text-sm mb-6">Para talleres independientes que inician.</p>
                            <div class="text-3xl font-extrabold text-white mb-6">$?? <span class="text-sm font-normal text-white/50">/ mes</span></div>
                            <ul class="space-y-3 text-sm text-white/70">
                                <li class="flex items-center gap-2">✔ Hasta 100 órdenes al mes</li>
                                <li class="flex items-center gap-2">✔ Soporte estándar</li>
                                <li class="flex items-center gap-2">✔ Registro básico de equipos</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white/5 border-2 border-[#7B2CBF]/40 rounded-2xl p-8 flex flex-col justify-between relative">
                        <div class="absolute top-0 right-6 transform -translate-y-1/2 bg-[#7B2CBF] text-white text-xs font-bold uppercase px-3 py-1 rounded-full">Popular</div>
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2 uppercase tracking-wide text-[#E0AAFF]">Pro Taller</h3>
                            <p class="text-white/50 text-sm mb-6">El balance perfecto para equipos en crecimiento.</p>
                            <div class="text-3xl font-extrabold text-white mb-6">$?? <span class="text-sm font-normal text-white/50">/ mes</span></div>
                            <ul class="space-y-3 text-sm text-white/70">
                                <li class="flex items-center gap-2">✔ Órdenes ilimitadas</li>
                                <li class="flex items-center gap-2">✔ 3 Técnicos simultáneos</li>
                                <li class="flex items-center gap-2">✔ Historial clínico del equipo</li>
                                <li class="flex items-center gap-2">✔ Soporte prioritario</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white/5 border border-white/10 rounded-2xl p-8 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2 uppercase tracking-wide">Multi Sucursal</h3>
                            <p class="text-white/50 text-sm mb-6">Para redes de talleres y grandes laboratorios.</p>
                            <div class="text-3xl font-extrabold text-white mb-6">$?? <span class="text-sm font-normal text-white/50">/ mes</span></div>
                            <ul class="space-y-3 text-sm text-white/70">
                                <li class="flex items-center gap-2">✔ Todo lo del plan Pro</li>
                                <li class="flex items-center gap-2">✔ Técnicos ilimitados</li>
                                <li class="flex items-center gap-2">✔ Panel de analíticas avanzado</li>
                                <li class="flex items-center gap-2">✔ API de integración libre</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>


    {{-- FOOTER --}}
    <footer class="relative z-30 w-full px-6 py-8 text-center border-t border-white/10 bg-[#0D0D11]">
        <p class="text-sm text-white/60">
            &copy; {{ date('Y') }}. Todos los derechos reservados.
        </p>
    </footer>

</body>
</html>
