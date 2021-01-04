<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Schools\School;
use Illuminate\Http\Request;

class DisabledSchoolsController extends Controller
{
    public function store()
    {
        $school = School::findOrFail(request('school_id'));

        $school->disable();
    }

    public function destroy(School $school)
    {
        $school->reinstate();
    }
}
