<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StepHeader extends Component
{

    public function __construct(public int $step, public int $of)
    {
    }


    public function render()
    {
        return view('components.step-header');
    }

    public function colourForPosition($point)
    {
        if($point <= $this->step) {
            return 'bg-sky-blue';
        }

        return 'bg-gray-400';
    }
}
