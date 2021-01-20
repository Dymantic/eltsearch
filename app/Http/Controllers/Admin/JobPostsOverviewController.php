<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Placements\JobPost;
use App\Placements\JobPostPresenter;
use Illuminate\Http\Request;

class JobPostsOverviewController extends Controller
{
    public function show()
    {
        return [
            'total_live'          => JobPost::live()->count(),
            'posted_in_last_week' => JobPost::publishedSince(now()->subWeek()->startOfDay())->count(),
            'recent'              => JobPost::publishedSince(now()->subMonth())
                                            ->latest()
                                            ->get()
                                            ->map(fn($post) => JobPostPresenter::forAdmin($post))
                                            ->values()->all(),
        ];
    }
}
