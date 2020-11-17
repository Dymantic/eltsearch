<?php

namespace App\Http\Controllers\Admin\Schools;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublishJobPostRequest;
use App\Jobs\MatchJobPost;
use App\Placements\JobPost;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PublishedJobPostsController extends Controller
{
    public function store(PublishJobPostRequest $request)
    {
        $post = $request->getPost();

        if(!$post->readyForPublication()) {
            throw ValidationException::withMessages([
                'job_post_id' => 'Your post is not ready to be published'
            ]);
        }

        $post->publish($post->school->nextToken());

        MatchJobPost::dispatch($post);
    }

    public function destroy(PublishJobPostRequest $request, JobPost $job_post)
    {
        $request->getPost()->retract();
    }
}
