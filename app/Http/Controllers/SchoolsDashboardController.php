<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolsDashboardController extends Controller
{
    public function show()
    {
        return view('front.schools.dashboard');
    }
}
