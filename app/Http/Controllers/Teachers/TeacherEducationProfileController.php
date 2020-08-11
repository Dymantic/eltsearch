<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherEducationRequest;
use Illuminate\Http\Request;

class TeacherEducationProfileController extends Controller
{
    public function update(TeacherEducationRequest $request)
    {
        $request->teacher()->updateEducationInfo($request->educationInfo());
    }
}
