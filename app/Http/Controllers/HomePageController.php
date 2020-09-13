<?php

namespace App\Http\Controllers;

use App\Placements\JobPost;
use App\Placements\JobPostPresenter;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function show()
    {
        $posts = JobPost::live()->latest()->limit(10)->get()->map(fn ($post) => JobPostPresenter::forPublic($post));
        return view('front.home.page', ['posts' => $posts]);
    }
}
