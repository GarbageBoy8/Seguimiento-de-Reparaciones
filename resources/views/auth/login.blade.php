<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex flex-col items-center mb-6">
        <h2 class="p-1 text-center text-xl font-bold text-[#1E1B2E]">Bienvenido de vuelta</h2>
        <span class="p-1 text-center text-sm text-gray-500">Inicia sesión para continuar</span>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-sm font-medium text-gray-700" />
            <x-text-input
                id="email"
                class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-3 text-base text-gray-800 focus:border-[#732EE4] focus:ring-[#732EE4]"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="Ingresa tu correo electrónico"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')" class="text-sm font-medium text-gray-700" />
            <x-text-input
                id="password"
                class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-3 text-base text-gray-800 shadow-sm focus:border-[#732EE4] focus:ring-[#732EE4]"
                type="password"
                name="password"
                placeholder="Ingresa tu contraseña"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me + Forgot Password -->
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <label for="remember_me" class="flex cursor-pointer items-center gap-2">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-[#7C3AED] text-[#7C3AED] shadow-sm focus:ring-[#7C3AED]" />
                <span class="text-sm text-[#938EA6]">{{ __('Recordarme') }}</span>
            </label>

            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
                class="text-sm font-medium text-[#1E1B2E] transition-colors hover:text-[#7C3AED]">
                {{ __('¿Olvidaste tu contraseña?') }}
            </a>
            @endif
        </div>

        <!-- Botón -->
        <x-primary-button class="w-full justify-center rounded-xl bg-[#5A00C6] py-3 text-sm font-semibold transition-colors duration-150 hover:bg-[#3F008E] focus:ring-indigo-500">
            {{ __('Iniciar sesión') }}
        </x-primary-button>
    </form>
</x-guest-layout>
