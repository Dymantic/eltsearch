<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WaitingButton extends Component
{

    public function __construct(public string $text = '')
    {}


    public function render()
    {
        return view('components.waiting-button');
    }
}
