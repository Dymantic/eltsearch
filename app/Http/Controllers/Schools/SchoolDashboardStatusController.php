<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Schools\School;
use Illuminate\Http\Request;

class SchoolDashboardStatusController extends Controller
{
    public function show(School $school)
    {
        return ['statuses' => $school->checkStatus()->values()->all()];
    }
}
