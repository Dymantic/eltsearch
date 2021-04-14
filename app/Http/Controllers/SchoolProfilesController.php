<?php

namespace App\Http\Controllers;

use App\Schools\School;
use App\Schools\SchoolPresenter;
use Illuminate\Http\Request;

class SchoolProfilesController extends Controller
{
    public function show(School $school)
    {
        if($school->isDisabled()) {
            abort(404);
        }
        return view('front.schools.show', ['school' => SchoolPresenter::forPublic($school)]);
    }
}
