<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleRegisterController extends Controller
{
    public function redirect()
    {
        request()->session()->put('oauth_login_intention', 'register');

        return Socialite::driver('google')->redirect();
    }
}
