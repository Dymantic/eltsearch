<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherGeneralInfoRequest;
use App\Teachers\TeacherProfilePresenter;
use Illuminate\Http\Request;

class TeacherGeneralProfileController extends Controller
{

    public function show()
    {
        return TeacherProfilePresenter::forTeacher(request()->get('teacherProfile'));
    }

    public function update(TeacherGeneralInfoRequest $request)
    {
        $request->teacher()->updateGeneralInfo($request->generalInfo());
    }
}
