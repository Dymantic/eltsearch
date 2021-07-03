<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrationPageController extends Controller
{
    public function show()
    {
        return view('front.register.show', [
            'recaptcha_key' => config('services.recaptcha.site_key')
        ]);
    }
}
