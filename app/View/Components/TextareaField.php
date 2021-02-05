<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TextareaField extends Component
{
    public string $value;
    public string $helpText;
    public string $label;
    public string $name;
    public string $error;
    public string $height;

    public function __construct(string $label, string $name, string $value, string $error = '', string $helpText = '', string $height = 'h-32')
    {
        $this->value = $value;
        $this->helpText = $helpText;
        $this->label = $label;
        $this->name = $name;
        $this->error = $error;
        $this->height = $height;
    }


    public function render()
    {
        return view('components.textarea-field');
    }

    public function wrapperClasses()
    {
        if($this->error) {
            return 'border-b border-red-400';
        }

        return '';
    }
}
