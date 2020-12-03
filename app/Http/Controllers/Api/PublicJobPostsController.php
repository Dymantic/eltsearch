<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Placements\JobPost;
use App\Placements\JobPostPresenter;
use Illuminate\Http\Request;

class PublicJobPostsController extends Controller
{
    public function show(JobPost $post)
    {
        return JobPostPresenter::forTeacher($post);
    }
}
