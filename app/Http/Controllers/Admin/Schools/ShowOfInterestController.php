<?php

namespace App\Http\Controllers\Admin\Schools;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowOfInterestRequest;
use App\Placements\JobApplication;
use App\Placements\ShowOfInterest;
use Illuminate\Http\Request;

class ShowOfInterestController extends Controller
{
    public function store(ShowOfInterestRequest $request, JobApplication $application)
    {
        $application->showInterest($request->contactPersonInfo());
    }
}
