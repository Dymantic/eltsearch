<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PublicPage extends Component
{
    public $lang;
    public $title;
    public $description;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($lang = 'en', $title = 'ELT Search', $description = '')
    {
        //
        $this->lang = $lang;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.public-page');
    }
}
