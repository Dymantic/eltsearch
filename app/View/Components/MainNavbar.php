<?php

namespace App\View\Components;

use App\User;
use Illuminate\Support\Str;
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

    public function translatedUrl($path) {
        $lang = app()->getLocale() !== 'en' ? 'en' : 'zh';
        $path = trim($path, '/');
        $path = Str::startsWith($path, ['en', 'zh']) ? substr($path, 2) : $path;

        return sprintf("/%s/%s", $lang, trim($path, '/'));
    }


}
