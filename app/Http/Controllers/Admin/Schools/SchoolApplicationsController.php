<?php

namespace App\Http\Controllers\Admin\Schools;

use App\Http\Controllers\Controller;
use App\Placements\JobApplication;
use App\Placements\JobApplicationPresenter;
use App\Placements\JobPost;
use App\Schools\School;
use Illuminate\Http\Request;

class SchoolApplicationsController extends Controller
{
    public function index(School $school)
    {
        return $school
            ->jobPosts()
            ->with('jobApplications')
            ->get()
            ->flatMap(fn (JobPost $post) => $post->jobApplications)
            ->sortByDesc(fn (JobApplication $application) => $application->created_at)
            ->map(fn (JobApplication $application) => JobApplicationPresenter::forSchool($application))
            ->values()->all();
    }
}
