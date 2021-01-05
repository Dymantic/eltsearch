<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Placements\JobPost;
use Illuminate\Http\Request;

class DisabledJobPostsController extends Controller
{
    public function store()
    {
        $post = JobPost::findOrFail(request('job_post_id'));

        $post->disable();
    }

    public function destroy(JobPost $post)
    {
        $post->reinstate();
    }
}
