<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobApplicationRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TeacherJobApplicationsController extends Controller
{

    public function index()
    {
        return request()->teacherProfile->jobApplications()->latest()->get()->map->presentForTeacher();
    }

    public function store(JobApplicationRequest $request)
    {
        if($request->teacher()->hasApplicationFor($request->jobPost())) {
            throw ValidationException::withMessages([
                'job_post' => 'You have already applied for this post'
            ]);
        }

        $request->teacher()
                ->applyForJob($request->jobPost(), $request->coverLetter(), $request->contactDetails());
    }
}
