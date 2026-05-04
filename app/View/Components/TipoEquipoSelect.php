<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TipoEquipoSelect extends Component
{
    public $name;
    public $selected;
    public $required;
    
    public function __construct($name = 'tipo_equipo', $selected = null, $required = false)
    {
        $this->name = $name;
        $this->selected = old($name, $selected);
        $this->required = $required;
    }
    
    public function tipos()
    {
        return [
            'Celular' => [
                'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
                'color' => 'text-purple-600',
                'bg' => 'bg-purple-50'
            ],
            'Laptop' => [
                'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                'color' => 'text-blue-600',
                'bg' => 'bg-blue-50'
            ],
            'Tablet' => [
                'icon' => 'M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                'color' => 'text-green-600',
                'bg' => 'bg-green-50'
            ],
            'Consola' => [
                'icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
                'color' => 'text-red-600',
                'bg' => 'bg-red-50'
            ],
            'PC' => [
                'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                'color' => 'text-indigo-600',
                'bg' => 'bg-indigo-50'
            ],
            'Otro' => [
                'icon' => 'M5 12h14M12 5l7 7-7 7',
                'color' => 'text-gray-600',
                'bg' => 'bg-gray-50'
            ],
        ];
    }
    
    public function render()
    {
        return view('components.tipo-equipo-select');
    }
}