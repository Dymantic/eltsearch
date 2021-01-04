<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Teachers\Teacher;
use Illuminate\Http\Request;

class DisabledTeachersController extends Controller
{
    public function store()
    {
        $teacher = Teacher::findOrFail(request('teacher_id'));

        $teacher->disable();
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->reinstate();
    }
}
