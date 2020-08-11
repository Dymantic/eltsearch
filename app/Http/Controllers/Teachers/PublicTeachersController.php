<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicTeachersController extends Controller
{
    public function store()
    {
        request('teacherProfile')->publish();
    }

    public function destroy()
    {
        request('teacherProfile')->retract();
    }
}
