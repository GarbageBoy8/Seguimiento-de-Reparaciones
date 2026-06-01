<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FixFlow') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="overflow-x-hidden bg-gradient-to-br from-slate-50 to-gray-100 font-sans text-gray-900 antialiased">
    <main class="flex min-h-screen items-center justify-center px-4 py-6 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div class="mb-5 flex flex-col items-center text-center">
                <a href="/" class="inline-flex items-center justify-center">
                    <x-application-logo class="h-auto w-28 rounded-full object-cover object-center shadow-sm sm:w-32" />
                </a>
                <p class="mt-3 text-sm font-medium text-gray-500">Gestión de reparaciones para talleres</p>
            </div>

            <section class="overflow-hidden rounded-2xl border border-gray-100 bg-white px-5 py-6 shadow-xl shadow-purple-900/5 sm:px-7 sm:py-7">
                {{ $slot }}
            </section>
        </div>
    </main>
</body>

</html>
