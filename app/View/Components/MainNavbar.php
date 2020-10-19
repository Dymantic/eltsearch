<?php

namespace App\View\Components;

use App\User;
use Illuminate\View\Component;

class MainNavbar extends Component
{
    public ?User $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }


    public function render()
    {
        return view('components.main-navbar');
    }

    public function dashboard_url()
    {
        if($this->user->isTeacher()) {
            return '/teachers';
        }

        if($this->user->isSchool()) {
            return '/schools';
        }

        if($this->user->isAdmin()) {
            return '/admin';
        }
    }


}
