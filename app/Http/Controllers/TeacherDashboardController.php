<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    public function show()
    {
        return view('front.teachers.dashboard');
    }
}
