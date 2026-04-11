<?php

use App\Jobs\VerificarRetardosJob;
use Illuminate\Support\Facades\Schedule;

// Verifica retardos de órdenes cada 15 minutos y notifica al admin del taller
Schedule::job(new VerificarRetardosJob)->everyFifteenMinutes();
