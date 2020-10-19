<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FacebookLogin extends Component
{

    public $redirect;
    public $text;

    public function __construct($redirect, $text = "Sign up with Facebook")
    {
        $this->redirect = $redirect;
        $this->text = $text;
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
