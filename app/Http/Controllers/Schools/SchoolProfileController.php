<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolProfileRequest;
use App\Schools\School;
use App\Schools\SchoolProfileInfo;
use Illuminate\Http\Request;

class SchoolProfileController extends Controller
{
    public function update(School $school, SchoolProfileRequest $request)
    {
        $school->updateProfile($request->schoolProfileInfo());
    }
}
