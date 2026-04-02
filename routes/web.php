<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\PanelTecnicoController;
use App\Http\Controllers\ReparacionController;
use App\Http\Controllers\SeguimientoController;
use Illuminate\Support\Facades\Route;

// ─── Públicas ─────────────────────────────────────────────────────────────────

Route::get('/', fn() => view('welcome'));

// Portal del cliente (sin autenticación, solo con token)
Route::get('/seguimiento/{token}', [SeguimientoController::class, 'show'])->name('seguimiento.show');
Route::post('/seguimiento/{token}/mensaje', [SeguimientoController::class, 'mensaje'])->name('seguimiento.mensaje');
Route::get('/seguimiento/{token}/mensajes', [SeguimientoController::class, 'mensajesJson'])->name('seguimiento.mensajes.json');

// ─── Autenticadas ─────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    // Panel principal
    Route::get('/centro-de-mando', [PanelTecnicoController::class, 'index'])->name('panel.inicio');

    // Reparaciones (resource + escalar)
    Route::resource('reparaciones', ReparacionController::class)->only(['index', 'create', 'store', 'show', 'update']);
    Route::post('/reparaciones/{reparacion}/escalar', [ReparacionController::class, 'escalar'])->name('reparaciones.escalar');

    // Chat del técnico (JSON)
    Route::get('/reparaciones/{reparacion}/mensajes', [MensajeController::class, 'index'])->name('reparaciones.mensajes.index');
    Route::post('/reparaciones/{reparacion}/mensajes', [MensajeController::class, 'store'])->name('reparaciones.mensajes.store');

    // Clientes
    Route::resource('clientes', ClienteController::class)->only(['index', 'create', 'store', 'show']);

    // Notificaciones (solo admin)
    Route::post('/notificaciones/{id}/leida', [NotificacionController::class, 'marcarLeida'])->name('notificaciones.leida');
    Route::post('/notificaciones/leer-todas', [NotificacionController::class, 'marcarTodasLeidas'])->name('notificaciones.leer-todas');
});

require __DIR__ . '/auth.php';
