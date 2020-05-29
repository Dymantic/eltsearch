<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolRegistrationController extends Controller
{
    public function store()
    {
        request()->validate([
            'name'           => ['required'],
            'email'          => ['required', 'email', Rule::unique('users', 'email')],
            'password'       => ['required', 'min:8', 'confirmed'],
            'school_name'    => ['required', Rule::unique('schools', 'name')],
            'school_address' => ['required'],
        ]);

        User::registerSchool(
            request()->only('name', 'email', 'password', 'school_name', 'school_address')
        );

        return redirect("/schools");
    }
}
