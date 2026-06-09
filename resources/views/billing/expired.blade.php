@extends('plantillas.base')

@section('titulo-pestana', 'Suscripción vencida')

@section('contenido-principal')

<div class="mx-auto max-w-3xl">
    <section class="overflow-hidden rounded-2xl bg-white shadow-lg">
        <div class="bg-gradient-to-r from-[#2D1B69] to-[#1E1B2E] px-6 py-8 text-white md:px-8">
            <p class="text-sm font-semibold uppercase tracking-widest text-purple-200">Acceso pausado</p>
            <h1 class="mt-2 text-2xl font-bold md:text-3xl">Tu prueba o suscripción terminó</h1>
            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-purple-100 md:text-base">
                Para seguir usando FixFlow, completa tu pago manual y solicita la reactivación de tu taller.
            </p>
        </div>

        <div class="space-y-5 p-5 md:p-8">
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                Tu información está guardada. Al reactivar tu plan podrás continuar trabajando con tus órdenes, clientes y técnicos.
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Plan actual</p>
                    <p class="mt-1 font-semibold text-[#2D1B69]">{{ auth()->user()->taller->plan->nombre ?? 'Sin plan asignado' }}</p>
                </div>
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Estado</p>
                    <p class="mt-1 font-semibold text-[#2D1B69]">{{ auth()->user()->taller->subscription_status ?? 'Sin estado' }}</p>
                </div>
            </div>

            <a href="https://wa.me/tu-numero-aqui" target="_blank" class="inline-flex w-full items-center justify-center rounded-xl bg-[#7C3AED] px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-[#6D28D9] sm:w-auto">
                Contactar para reactivar
            </a>
        </div>
    </section>
</div>

@endsection
