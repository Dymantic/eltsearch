<?php

namespace App\Http\Controllers\Admin\Schools;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublishJobPostRequest;
use App\Placements\JobPost;
use Illuminate\Http\Request;

class PublishedJobPostsController extends Controller
{
    public function store(PublishJobPostRequest $request)
    {
        $request->getPost()->publish();
    }

    public function destroy(PublishJobPostRequest $request, JobPost $job_post)
    {
        $request->getPost()->retract();
    }
}
