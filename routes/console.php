<?php

use App\Jobs\VerificarRetardosJob;
use App\Models\SubscriptionPlan;
use App\Models\Taller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Verifica retardos de órdenes cada 15 minutos y notifica al admin del taller
Schedule::job(new VerificarRetardosJob)->everyFifteenMinutes();

Artisan::command('talleres:planes', function () {
    $planes = SubscriptionPlan::orderBy('id')
        ->get(['id', 'nombre', 'slug', 'max_tecnicos', 'permite_clientes_mayoristas', 'activo'])
        ->map(fn (SubscriptionPlan $plan) => [
            'ID' => $plan->id,
            'Nombre' => $plan->nombre,
            'Slug' => $plan->slug,
            'Max tecnicos' => $plan->max_tecnicos,
            'Mayoristas' => $plan->permite_clientes_mayoristas ? 'Si' : 'No',
            'Activo' => $plan->activo ? 'Si' : 'No',
        ]);

    $this->table(['ID', 'Nombre', 'Slug', 'Max tecnicos', 'Mayoristas', 'Activo'], $planes);
})->purpose('Lista los planes de suscripcion disponibles.');

Artisan::command('talleres:ver {taller : ID o codigo_publico del taller}', function (string $taller) {
    $taller = buscarTallerPorIdOCodigo($taller);

    $this->table(['Campo', 'Valor'], [
        ['ID', $taller->id],
        ['Nombre', $taller->nombre],
        ['Codigo publico', $taller->codigo_publico ?? 'Sin codigo'],
        ['Plan', $taller->plan?->nombre ?? 'Sin plan'],
        ['Plan slug', $taller->plan?->slug ?? 'Sin plan'],
        ['Estado suscripcion', $taller->subscription_status],
        ['Trial termina', optional($taller->trial_ends_at)->toDateTimeString() ?? 'No aplica'],
        ['Suscripcion termina', optional($taller->subscription_ends_at)->toDateTimeString() ?? 'Sin vencimiento'],
        ['Acceso activo', $taller->suscripcionEstaActiva() ? 'Si' : 'No'],
        ['Tecnicos actuales', $taller->tecnicosCount()],
        ['Max tecnicos plan', $taller->maxTecnicos()],
        ['Clientes mayoristas', $taller->clientes()->where('es_mayorista', true)->count()],
    ]);
})->purpose('Muestra el estado de suscripcion de un taller.');

Artisan::command(
    'talleres:cambiar-plan
        {taller : ID o codigo_publico del taller}
        {plan : Slug del plan, por ejemplo basico, pro o taller-plus}
        {--meses=1 : Meses de vigencia si se activa como suscripcion pagada}
        {--sin-vencimiento : Deja la suscripcion activa sin fecha de vencimiento}
        {--trial : Cambia el taller a estado trial}
        {--dias-trial=7 : Dias de trial cuando se usa --trial}
        {--confirmar : Ejecuta sin pedir confirmacion interactiva}',
    function (string $taller, string $plan) {
        $taller = buscarTallerPorIdOCodigo($taller);
        $plan = SubscriptionPlan::where('slug', $plan)->firstOrFail();

        $tecnicosActuales = $taller->tecnicosCount();
        $clientesMayoristas = $taller->clientes()->where('es_mayorista', true)->count();

        $this->info("Taller: {$taller->nombre} ({$taller->codigo_publico})");
        $this->info("Plan actual: " . ($taller->plan?->slug ?? 'sin-plan'));
        $this->info("Nuevo plan: {$plan->slug}");

        if ($tecnicosActuales > $plan->max_tecnicos) {
            $this->warn("El taller tiene {$tecnicosActuales} tecnicos y el plan permite {$plan->max_tecnicos}. No se eliminan tecnicos existentes, pero no podran crear mas.");
        }

        if ($clientesMayoristas > 0 && ! $plan->permite_clientes_mayoristas) {
            $this->warn("El taller tiene {$clientesMayoristas} clientes mayoristas y el nuevo plan no permite crear mayoristas. No se modifican clientes existentes.");
        }

        if (! $this->option('confirmar') && ! $this->confirm('¿Aplicar este cambio de plan?', false)) {
            $this->warn('Operacion cancelada.');
            return 1;
        }

        if ($this->option('trial')) {
            $diasTrial = max(1, (int) $this->option('dias-trial'));

            $taller->update([
                'plan_id' => $plan->id,
                'subscription_status' => 'trial',
                'trial_ends_at' => now()->addDays($diasTrial),
                'subscription_ends_at' => null,
                'suscripcion_activa' => true,
            ]);
        } else {
            $meses = max(1, (int) $this->option('meses'));

            $taller->update([
                'plan_id' => $plan->id,
                'subscription_status' => 'active',
                'trial_ends_at' => $taller->trial_ends_at,
                'subscription_ends_at' => $this->option('sin-vencimiento') ? null : now()->addMonths($meses),
                'suscripcion_activa' => true,
            ]);
        }

        $taller->refresh()->load('plan');

        $this->info('Plan actualizado correctamente.');
        $this->table(['Campo', 'Valor'], [
            ['Taller', "{$taller->nombre} ({$taller->codigo_publico})"],
            ['Plan', "{$taller->plan->nombre} ({$taller->plan->slug})"],
            ['Estado', $taller->subscription_status],
            ['Trial termina', optional($taller->trial_ends_at)->toDateTimeString() ?? 'No aplica'],
            ['Suscripcion termina', optional($taller->subscription_ends_at)->toDateTimeString() ?? 'Sin vencimiento'],
            ['Acceso activo', $taller->suscripcionEstaActiva() ? 'Si' : 'No'],
        ]);

        return 0;
    }
)->purpose('Cambia el plan y estado de suscripcion de un taller.');

Artisan::command(
    'talleres:suspender
        {taller : ID o codigo_publico del taller}
        {--confirmar : Ejecuta sin pedir confirmacion interactiva}',
    function (string $taller) {
        $taller = buscarTallerPorIdOCodigo($taller);

        $this->warn("Se suspendera el acceso del taller: {$taller->nombre} ({$taller->codigo_publico}).");

        if (! $this->option('confirmar') && ! $this->confirm('¿Suspender este taller?', false)) {
            $this->warn('Operacion cancelada.');
            return 1;
        }

        $taller->update([
            'subscription_status' => 'expired',
            'subscription_ends_at' => now(),
            'suscripcion_activa' => false,
        ]);

        $this->info('Taller suspendido correctamente.');

        return 0;
    }
)->purpose('Suspende el acceso de un taller.');

function buscarTallerPorIdOCodigo(string $valor): Taller
{
    $query = Taller::with('plan');

    if (ctype_digit($valor)) {
        return $query->where('id', (int) $valor)->firstOrFail();
    }

    return $query->where('codigo_publico', Taller::normalizarCodigoPublico($valor))->firstOrFail();
}
