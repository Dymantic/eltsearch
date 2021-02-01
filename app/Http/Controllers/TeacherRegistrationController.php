<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRegistrationRequest;
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
        $user = User::registerTeacher($request->registrationFields());

        auth()->login($user);

        return redirect("/teachers");
    }
}
