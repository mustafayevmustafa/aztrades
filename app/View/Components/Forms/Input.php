<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Input extends Component
{
    public ?string $type, $name, $label, $value;

    public function __construct($type = null, $name = null,$label = null, $value = null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;

    }


    public function render()
    {
        return view('components.forms.input');
    }
}
