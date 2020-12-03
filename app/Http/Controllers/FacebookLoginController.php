<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FacebookLoginController extends Controller
{
    public function redirect()
    {
        request()->session()->put('fb_login_intention', 'login');
        request()->session()->put('fb_login_hash', request('hash', ''));

        return Socialite::driver('facebook')->redirect();
    }

}
