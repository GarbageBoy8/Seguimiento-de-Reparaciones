<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTallerSubscriptionIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $taller = $request->user()?->taller;

        if (! $taller || ! $taller->suscripcionEstaActiva()) {
            return redirect()->route('billing.expired');
        }

        return $next($request);
    }
}
