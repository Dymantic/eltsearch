<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobApplicationRequest;
use Illuminate\Http\Request;

class TeacherJobApplicationsController extends Controller
{

    public function index()
    {
        return request()->teacherProfile->jobApplications()->latest()->get()->map->presentForTeacher();
    }

    public function store(JobApplicationRequest $request)
    {
        $request->teacher()
                ->applyForJob($request->jobPost(), $request->coverLetter(), $request->contactDetails());
    }
}
