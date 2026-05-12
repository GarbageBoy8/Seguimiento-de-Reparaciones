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
                'label' => 'Celular',
                'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
                'color' => 'text-purple-600',
                'bg' => 'bg-purple-50'
            ],
            'Laptop' => [
                'label' => 'Laptop / Notebook',
                'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                'color' => 'text-blue-600',
                'bg' => 'bg-blue-50'
            ],
            'Tablet' => [
                'label' => 'Tablet',
                'icon' => 'M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                'color' => 'text-green-600',
                'bg' => 'bg-green-50'
            ],
            'Consola' => [
                'label' => 'Consola de Videojuegos',
                // SVG NUEVO que me pediste
                'icon' => 'M12 6v2m0 0v2m0-2h2m-2 0H8m8 6h.01M4 8h16a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2v-6a2 2 0 012-2z',
                'color' => 'text-red-600',
                'bg' => 'bg-red-50'
            ],
            'PC' => [
                'label' => 'PC de Escritorio',
                'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                'color' => 'text-indigo-600',
                'bg' => 'bg-indigo-50'
            ],
            'Otro' => [
                'label' => 'Otro dispositivo',
                'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
                'color' => 'text-gray-600',
                'bg' => 'bg-gray-50'
            ],
        ];
    }
    
    public function render()
    {
        return view('components.tipo-equipo-select', [
            'options' => $this->tipos()
        ]);
    }
}