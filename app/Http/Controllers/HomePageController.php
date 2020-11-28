<?php

namespace App\Http\Controllers;

use App\Announcements\Announcement;
use App\Placements\JobPost;
use App\Placements\JobPostPresenter;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function show()
    {
        $posts = JobPost::live()->latest()->limit(10)->get()->map(fn($post) => JobPostPresenter::forPublic($post));
        $announcement = Announcement::currentPublic(app()->getLocale());

        return view('front.home.page', [
            'posts'        => $posts,
            'announcement' => $announcement,
        ]);
    }
}
