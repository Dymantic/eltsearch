<?php

namespace App\Http\Controllers;

use App\Placements\JobPost;
use App\Placements\JobPostPresenter;
use Illuminate\Http\Request;

class JobPostsController extends Controller
{

    public function index()
    {
        $posts = JobPost::live()
                        ->latest()
                        ->get()
                        ->map(fn (JobPost $post) => JobPostPresenter::forPublic($post));

        return view('front.job-posts.index', ['posts' => $posts]);
    }

    public function show(JobPost $post)
    {
        return view('front.job-posts.post', ['post' => JobPostPresenter::forPublic($post)]);
    }
}
