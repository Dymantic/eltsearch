<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherGeneralInfoRequest;
use Illuminate\Http\Request;

class TeacherGeneralProfileController extends Controller
{
    public function update(TeacherGeneralInfoRequest $request)
    {
        $request->teacher()->updateGeneralInfo($request->generalInfo());
    }
}
