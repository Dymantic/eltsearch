<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobPostsQueryRequest;
use App\PagedData;
use App\Placements\JobPost;
use App\Placements\JobPostPresenter;
use Illuminate\Http\Request;

class JobPostsController extends Controller
{

    public function index(JobPostsQueryRequest $request)
    {

        $page = JobPost::select('job_posts.*')
                       ->join('areas', 'areas.id', '=', 'job_posts.area_id')
                       ->whereNotNull('job_posts.first_published_at')
                       ->where('job_posts.school_name', 'LIKE', "%{$request->search()}%")
                       ->orderBy($request->order(), $request->direction())
                       ->paginate(70);

        return PagedData::forPage($page, fn($p) => JobPostPresenter::forAdmin($p));
    }

    public function show(JobPost $jobPost)
    {
        return JobPostPresenter::forAdmin($jobPost);
    }
}
