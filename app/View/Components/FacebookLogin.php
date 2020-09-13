<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FacebookLogin extends Component
{

    public $redirect;

    public function __construct($redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.facebook-login');
    }
}
