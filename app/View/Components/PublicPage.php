<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PublicPage extends Component
{
    public $lang;
    public $title;
    public $description;
    public $alpine;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($lang = 'en', $title = 'ELT Search', $description = '', $alpine = false)
    {
        $this->lang = $lang;
        $this->title = $title;
        $this->description = $description;
        $this->alpine = $alpine;
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
