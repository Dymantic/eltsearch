<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function redirectPath()
    {
        return auth()->user()->redirectHome();
    }

    public function showResetForm($token)
    {
        return view('front.reset-password', [
            'token' => $token,
            'email' => request('email', ''),
        ]);
    }
}
