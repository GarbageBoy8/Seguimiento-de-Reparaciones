<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelTecnicoController extends Controller
{
    public function mostrarInicio()
    {
        // Busca el archivo panel-tecnico.blade.php
        return view('panel-tecnico');
    }
}