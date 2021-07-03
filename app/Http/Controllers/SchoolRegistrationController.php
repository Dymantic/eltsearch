<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolRegistrationRequest;
use App\Recaptcha;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolRegistrationController extends Controller
{
    public function store(SchoolRegistrationRequest $request)
    {
        abort_unless(
            Recaptcha::accepts($request->get('recaptcha_token', ''), $request->ip()),
            422
        );

        request()->validate([
            'name'        => ['required'],
            'email'       => ['required', 'email', Rule::unique('users', 'email')],
            'password'    => ['required', 'min:8', 'confirmed'],
            'school_name' => ['required', Rule::unique('schools', 'name')],
            'preferred_lang' => ['required', Rule::in(['en', 'zh'])],
        ]);

        $user = User::registerSchool(
            request()->only('name', 'email', 'password', 'school_name', 'school_address', 'preferred_lang')
        );

        auth()->login($user);

        return redirect("/schools");
    }
}
