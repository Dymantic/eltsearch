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
        $is_teacher = auth()->user() && auth()->user()->isTeacher();
        $has_application = $post->hasApplicationBy(auth()->user());
        $profile_complete = $is_teacher && auth()->user()->teacher->hasCompleteProfile();


        return view('front.job-posts.post', [
            'post' => JobPostPresenter::forPublic($post),
            'has_application' => $has_application,
            'profile_incomplete' => !$profile_complete && $is_teacher,
            'can_apply' => auth()->guest() || ((!$has_application) && ($profile_complete)),
        ]);
    }

}
