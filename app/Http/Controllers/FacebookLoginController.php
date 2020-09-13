<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FacebookLoginController extends Controller
{
    public function redirect()
    {
        request()->session()->put('fb_login_intention', 'login');
        return Socialite::driver('facebook')->redirect();
    }

}
