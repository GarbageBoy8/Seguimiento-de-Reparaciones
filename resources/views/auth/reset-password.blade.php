<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-[#1E1B2E]">Restablecer contraseña</h2>
        <p class="mt-1 text-sm text-gray-500">Crea una contraseña nueva para tu cuenta</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="mt-1 block w-full rounded-xl px-4 py-3 text-base" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Nueva contraseña')" />
            <x-text-input id="password" class="mt-1 block w-full rounded-xl px-4 py-3 text-base" type="password" name="password" required autocomplete="new-password" />
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

        <div>
            <x-primary-button class="w-full justify-center rounded-xl py-3">
                {{ __('Guardar nueva contraseña') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
