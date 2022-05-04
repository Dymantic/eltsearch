<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPasswordController extends Controller
{
    public function update()
    {
        request()->validate([
            'old_password' => ['required', 'current_password'],
            'password' => ['confirmed', 'min:8'],
        ]);

        request()->user()->resetPassword(request('password'));
    }
}
