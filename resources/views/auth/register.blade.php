<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-[#1E1B2E]">Crea tu taller</h2>
        <p class="mt-1 text-sm text-gray-500">Registra tu cuenta para empezar a gestionar reparaciones</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Nombre del Taller -->
        <div>
            <x-input-label for="nombre_taller" :value="__('Nombre del Taller')" />
            <x-text-input id="nombre_taller" class="mt-1 block w-full rounded-xl px-4 py-3 text-base" type="text" name="nombre_taller" :value="old('nombre_taller')" required autofocus />
            <x-input-error :messages="$errors->get('nombre_taller')" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Tu nombre')" />
            <x-text-input id="name" class="mt-1 block w-full rounded-xl px-4 py-3 text-base" type="text" name="name" :value="old('name')" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>


        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="mt-1 block w-full rounded-xl px-4 py-3 text-base" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="mt-1 block w-full rounded-xl px-4 py-3 text-base"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />

            <x-text-input id="password_confirmation" class="mt-1 block w-full rounded-xl px-4 py-3 text-base"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col-reverse gap-3 pt-1 sm:flex-row sm:items-center sm:justify-between">
            <a class="text-center text-sm font-medium text-gray-600 transition hover:text-[#7C3AED] focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:ring-offset-2" href="{{ route('login') }}">
                {{ __('¿Ya tienes una cuenta?') }}
            </a>

            <x-primary-button class="w-full justify-center rounded-xl py-3 sm:w-auto">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
