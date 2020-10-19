<?php

namespace App\Http\Controllers\Admin\Schools;

use App\Http\Controllers\Controller;
use App\Schools\School;
use App\Schools\SchoolPresenter;
use Illuminate\Http\Request;

class UserSchoolsController extends Controller
{
    public function index()
    {
        return request()->user()->schools->map(fn (School $school) => SchoolPresenter::forAdmin($school));
    }
}
