<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowOfInterestRequest;
use App\Notifications\InterestShown;
use App\Placements\JobApplication;
use App\Placements\ShowOfInterest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ShowOfInterestController extends Controller
{
    public function store(ShowOfInterestRequest $request, JobApplication $application)
    {
        if($application->hasShowOfInterest()) {
            throw ValidationException::withMessages([
                'application' => 'You have already contacted the teacher. If you wish to reach out again, contact the teacher directly.'
            ]);
        }
        $show_of_interest = $application->showInterest($request->contactPersonInfo());

        $teacher = $show_of_interest->jobApplication->teacher;

        $teacher->user->notify(new InterestShown($show_of_interest));
    }
}
