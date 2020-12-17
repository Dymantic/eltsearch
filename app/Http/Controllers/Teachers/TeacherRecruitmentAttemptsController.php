<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Placements\RecruitmentAttempt;
use Illuminate\Http\Request;

class TeacherRecruitmentAttemptsController extends Controller
{
    public function index()
    {
        return request('teacherProfile')
            ->recruitmentAttempts()
            ->latest()
            ->get()
            ->map(fn (RecruitmentAttempt $a) => $a->presentForTeacher());
    }
}
