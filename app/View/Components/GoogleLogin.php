<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GoogleLogin extends Component
{

    public function __construct(public string $redirect, public string $text)
    {
    }


    public function render()
    {
        return view('components.google-login');
    }
}
