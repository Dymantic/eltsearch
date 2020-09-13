<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NumberedCard extends Component
{
    public $index;

    public function __construct($index)
    {
        $this->index = $index;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.numbered-card');
    }
}
