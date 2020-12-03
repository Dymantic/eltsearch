<?php

namespace App\View\Components;

use App\User;
use Illuminate\View\Component;

class UserLayout extends Component
{
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function render()
    {
        return view('components.user-layout');
    }

    public function name()
    {
        return $this->user->name;
    }

    public function email()
    {
        return $this->user->email;
    }

    public function avatar()
    {
        if($this->user->isTeacher()) {
            return $this->user->teacher->getAvatar();
        }

        if($this->user->isSchool()) {
            return '';
        }

        if($this->user->isAdmin()) {
            return '/images/eric.jpg';
        }

        return '';
    }

    public function script()
    {
        if($this->user->isTeacher()) {
            return 'teacher-app.js';
        }

        if($this->user->isSchool()) {
            return 'school-app.js';
        }

        if($this->user->isAdmin()) {
            return 'admin-app.js';
        }

        return '';
    }

    public function account()
    {
        if($this->user->isTeacher()) {
            return 'teacher';
        }

        if($this->user->isSchool()) {
            return 'school';
        }

        if($this->user->isAdmin()) {
            return 'admin';
        }

        return null;
    }

    public function preferred_lang()
    {
        return $this->user->preferred_lang ?? 'en';
    }

}
