<?php

namespace App\Http\Controllers\Admin\Schools;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobPostRequest;
use App\Placements\JobPost;
use App\Schools\School;
use Illuminate\Http\Request;

class SchoolJobPostsController extends Controller
{
    public function store(School $school, JobPostRequest $request)
    {
        $school->postJob($request->postInfo(), $request->user());
    }

    public function update(JobPost $post, JobPostRequest $request)
    {
        $post->updateInfo($request->postInfo(), $request->user());
    }

    public function delete(JobPost $post)
    {
        $post->delete();
    }
}
