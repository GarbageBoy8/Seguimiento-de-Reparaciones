<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-[#1E1B2E]">Recuperar contraseña</h2>
        <p class="mt-2 text-sm leading-relaxed text-gray-600">
            Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="mt-1 block w-full rounded-xl px-4 py-3 text-base" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('login') }}" class="text-center text-sm font-medium text-gray-600 transition hover:text-[#7C3AED]">
                Volver a iniciar sesión
            </a>
            <x-primary-button class="w-full justify-center rounded-xl py-3 sm:w-auto">
                {{ __('Enviar enlace') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
