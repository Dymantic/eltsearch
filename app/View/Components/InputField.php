<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputField extends Component
{
    public string $value;
    public string $helpText;
    public string $type;
    public string $label;
    public string $name;
    public string $error;
    public string $bindTo;

    public function __construct(string $label, string $name, string $value, string $error = '', string $helpText = '', string $type = '', string $bindTo = '')
    {
        $this->value = $value;
        $this->helpText = $helpText;
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->error = $error;
        $this->bindTo = $bindTo;
    }


    public function render()
    {
        return view('components.input-field');
    }

    public function inputType()
    {
        return $this->type ? $this->type : 'text';
    }

    public function wrapperClasses()
    {
        if($this->error) {
            return 'border-b border-red-400';
        }

        return '';
    }

    public function isBound(): bool
    {
        return $this->bindTo !== '';
    }

    public function modelBinding(): string
    {
        return $this->bindTo;
    }
}
