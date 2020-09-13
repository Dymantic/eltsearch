<?php

namespace App\View\Components;

use Illuminate\View\Component;

class IconedCard extends Component
{
    public $icon;
    public $title;

    public function __construct($icon, $title)
    {
        $this->icon = $icon;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.iconed-card');
    }
}
