<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomSelect extends Component
{
    public $name;
    public $id;
    public $options;
    public $selected;
    public $placeholder;
    
    public function __construct($name, $options = [], $selected = null, $id = null, $placeholder = '— Seleccione —')
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->options = $options;
        $this->selected = old($name, $selected);
        $this->placeholder = $placeholder;
    }
    
    public function render()
    {
        return view('components.custom-select');
    }
}