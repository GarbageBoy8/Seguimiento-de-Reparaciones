<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-[#1E1B2E]">Confirma tu contraseña</h2>
        <p class="mt-2 text-sm leading-relaxed text-gray-600">
            Esta es un área segura. Confirma tu contraseña para continuar.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="mt-1 block w-full rounded-xl px-4 py-3 text-base"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full justify-center rounded-xl py-3">
                {{ __('Confirmar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
