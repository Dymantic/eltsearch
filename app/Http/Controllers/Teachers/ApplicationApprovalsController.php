<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Placements\JobPost;
use Illuminate\Http\Request;

class ApplicationApprovalsController extends Controller
{
    public function show()
    {
        $post = JobPost::where(['slug' => request('job_post_slug')])->firstOrFail();

        return request('teacherProfile')
            ->applicationApprovalFor($post)
            ->toArray();
    }
}
