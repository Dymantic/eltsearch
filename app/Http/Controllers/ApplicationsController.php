<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationRequest;
use App\Placements\JobPost;
use App\Placements\JobPostPresenter;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    public function create(JobPost $post)
    {
        return view('front.applications.create', ['post' => JobPostPresenter::forPublic($post)]);
    }

    public function store(JobApplicationRequest $request, JobPost $post)
    {
        $request->teacher()
                ->applyForJob($post, $request->coverLetter(), $request->contactDetails());

        return redirect("/");
    }
}
