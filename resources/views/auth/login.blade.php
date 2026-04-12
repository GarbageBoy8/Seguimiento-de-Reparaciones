<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex flex-col items-center mb-6">
        <h2 class="font-bold text-xl text-[#002A5B] p-1"> Bienvenido de vuelta </h2> 
        <span class="text-sm p-1"> Inicia sesión para continuar </span>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')"
                class="text-sm font-medium text-black dark:text-gray-800" />
            <x-text-input
                id="email"
                class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600
                       dark:bg-gray-200 dark:text-gray-800
                       focus:border-sky-500 focus:ring-sky-500"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="Ingresa tu correo electrónico"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')"
                class="text-sm font-medium text-gray-700 dark:text-gray-800" />
            <x-text-input
                id="password"
                class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600
                       dark:bg-gray-200 dark:text-gray-800 shadow-sm
                       focus:border-sky-500 focus:ring-sky-500"
                type="password"
                name="password"
                placeholder="Ingresa tu contraseña"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me + Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-sky-300 text-sky-600 shadow-sm focus:ring-sky-500" />
                <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Recordarme') }}</span>
            </label>

            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
                class="text-sm text-[#002A5B] hover:text-[#0056D6] dark:text-[#002A5B] font-medium transition-colors">
                {{ __('¿Olvidaste tu contraseña?') }}
            </a>
            @endif
        </div>

        <!-- Botón -->
        <x-primary-button class="w-full justify-center py-2.5 rounded-lg bg-[#0056D6]
                                  hover:bg-[#002A5B] focus:ring-indigo-500 text-sm font-semibold
                                  transition-colors duration-150">
            {{ __('Iniciar sesión') }}
        </x-primary-button>
    </form>
</x-guest-layout>