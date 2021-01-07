<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Placements\JobPostPresenter;
use App\Schools\School;
use Illuminate\Http\Request;

class SchoolJobPostsController extends Controller
{
    public function index(School $school)
    {
        return $school->jobPosts()->latest()->get()->map(fn ($s) => JobPostPresenter::forAdmin($s));
    }
}
