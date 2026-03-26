<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inicio', function () {
    return view('inicio');
});

use App\Http\Controllers\PanelTecnicoController;

// URL: midominio.com/centro-de-mando
Route::get('/centro-de-mando', [PanelTecnicoController::class, 'mostrarInicio'])->name('panel.inicio');
