<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectField extends Component
{
    public string $value;
    public string $helpText;
    public string $label;
    public string $name;
    public string $error;
    public array $options;
    public string $prompt;

    public function __construct(array $options, string $label, string $name, string $value, string $error = '', string $prompt = '---', string $helpText = '')
    {
        $this->options = $options;
        $this->value = $value;
        $this->helpText = $helpText;
        $this->label = $label;
        $this->name = $name;
        $this->error = $error;
        $this->prompt = $prompt;
    }


    public function render()
    {
        return view('components.select-field');
    }

    public function wrapperClasses()
    {
        if($this->error) {
            return 'border-b border-red-400';
        }

        return '';
    }
}
