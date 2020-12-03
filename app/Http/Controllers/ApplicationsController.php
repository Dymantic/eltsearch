<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationRequest;
use App\Placements\JobApplication;
use App\Placements\JobPost;
use App\Placements\JobPostPresenter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ApplicationsController extends Controller
{
    public function create(JobPost $post)
    {
        if(auth()->check() && auth()->user()->isTeacher()) {
            return redirect("/teachers#/apply-to-post/{$post->slug}");
        }

        return view('front.applications.create', [
            'post' => JobPostPresenter::forPublic($post),
        ]);
    }

    public function store(JobApplicationRequest $request, JobPost $post)
    {
        if($request->teacher()->hasApplicationFor($post)) {
            throw ValidationException::withMessages([
                'job_post' => 'You have already applied for this post'
            ]);
        }

        $request->teacher()
                ->applyForJob($post, $request->coverLetter(), $request->contactDetails());

        return redirect("/");
    }
}
