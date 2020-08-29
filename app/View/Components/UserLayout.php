<?php

namespace App\View\Components;

use App\User;
use Illuminate\View\Component;

class UserLayout extends Component
{
    public User $teacher;

    public function __construct(User $teacher)
    {
        $this->teacher = $teacher;
    }


    public function render()
    {
        return view('components.user-layout');
    }

    public function name()
    {
        return $this->teacher->name;
    }

    public function email()
    {
        return $this->teacher->email;
    }

    public function avatar()
    {
        return 'foo';
    }

    public function script()
    {
        if($this->teacher->isTeacher()) {
            return 'teacher-app.js';
        }

        if($this->teacher->isSchool()) {
            return 'school-app.js';
        }

        if($this->teacher->isAdmin()) {
            return 'admin-app.js';
        }
    }

    public function account()
    {
        if($this->teacher->isTeacher()) {
            return 'teacher';
        }

        if($this->teacher->isSchool()) {
            return 'school';
        }
    }

}
