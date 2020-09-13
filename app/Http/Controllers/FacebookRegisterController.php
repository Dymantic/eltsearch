<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FacebookRegisterController extends Controller
{
    public function redirect()
    {
        request()->session()->put('fb_login_intention', 'register');
        return Socialite::driver('facebook')->redirect();
    }
}
