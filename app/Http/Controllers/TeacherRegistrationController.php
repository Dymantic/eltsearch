<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRegistrationRequest;
use App\Recaptcha;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeacherRegistrationController extends Controller
{

    public function create()
    {
        return view('front.teachers.register');
    }

    public function store(TeacherRegistrationRequest $request)
    {
        abort_unless(
            Recaptcha::accepts($request->get('recaptcha_token', ''), $request->ip()),
            422
        );
        $user = User::registerTeacher($request->registrationFields());

        auth()->login($user);

        return redirect("/teachers");
    }
}
