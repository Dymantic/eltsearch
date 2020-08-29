<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherEducationRequest;
use App\Teachers\TeacherProfilePresenter;
use Illuminate\Http\Request;

class TeacherEducationProfileController extends Controller
{

    public function show()
    {
        return TeacherProfilePresenter::educationInfo(request('teacherProfile'));
    }


    public function update(TeacherEducationRequest $request)
    {
        $request->teacher()->updateEducationInfo($request->educationInfo());
    }
}
