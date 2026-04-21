<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f1eded] dark:bg-[rgb(234,231,231)] text-[#d7d7d2] flex flex-col h-screen overflow-hidden">

    <header class="bg-white w-full px-6 lg:px-8 py-4 text-sm">
        @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
            <a href="{{ url('/dashboard') }}"
                class="inline-block px-5 py-1.5 dark:text-[#070707] border-[#19140035] hover:border-[#1915014a] border text-[#000000] dark:border-[#3E3E3A] dark:hover:border-[#000000] rounded-sm text-sm leading-normal">
                Dashboard
            </a>
            @else
            <a href="{{ route('login') }}"
                class="inline-block px-5 py-1.5 bg-[#5A00C6] text-white rounded-lg text-sm leading-normal hover:bg-[#3F008E]">
                Iniciar Sesión
            </a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="inline-block px-5 py-1.5 bg-[#5A00C6] text-white rounded-lg text-sm leading-normal hover:bg-[#3F008E]">
                Registrarse
            </a>
            @endif
            @endauth
        </nav>
        @endif
    </header>

    <section class="flex-1 flex items-center justify-center bg-white w-full overflow-hidden">
        <div class="w-full h-full">
            <img src="{{ asset('assets/logo-fix-flow.png') }}" alt="Logo" class="w-full h-full object-cover">
        </div>
    </section>

</body>

</html>