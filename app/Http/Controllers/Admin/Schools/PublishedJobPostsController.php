<?php

namespace App\Http\Controllers\Admin\Schools;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublishJobPostRequest;
use App\Jobs\MatchJobPost;
use App\Placements\JobPost;
use Illuminate\Http\Request;

class PublishedJobPostsController extends Controller
{
    public function store(PublishJobPostRequest $request)
    {
        $post = $request->getPost();

        $post->publish();

        MatchJobPost::dispatch($post);
    }

    public function destroy(PublishJobPostRequest $request, JobPost $job_post)
    {
        $request->getPost()->retract();
    }
}
