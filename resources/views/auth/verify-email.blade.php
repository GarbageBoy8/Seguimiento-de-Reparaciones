<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-[#1E1B2E]">Verifica tu correo</h2>
        <p class="mt-2 text-sm leading-relaxed text-gray-600">
            Antes de continuar, abre el enlace de verificación que enviamos a tu correo. Si no lo recibiste, puedes solicitar otro.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 rounded-xl bg-emerald-50 p-3 text-sm font-medium text-emerald-700">
            {{ __('Enviamos un nuevo enlace de verificación a tu correo electrónico.') }}
        </div>
    @endif

    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button class="w-full justify-center rounded-xl py-3 sm:w-auto">
                    {{ __('Reenviar enlace') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="w-full rounded-xl bg-gray-100 px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:ring-offset-2 sm:w-auto">
                {{ __('Cerrar sesión') }}
            </button>
        </form>
    </div>
</x-guest-layout>
