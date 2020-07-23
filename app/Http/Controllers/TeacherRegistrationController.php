<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeacherRegistrationController extends Controller
{

    public function create()
    {
        return view('front.teachers.register');
    }

    public function store()
    {
        request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $user = User::registerTeacher(request()->only('name', 'email', 'password'));

        auth()->login($user);

        return redirect("/teachers");
    }
}
