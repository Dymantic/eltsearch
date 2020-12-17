<?php

namespace App\Http\Controllers\Schools;

use App\Exceptions\RecruitmentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RecruitmentAttemptRequest;
use App\Schools\School;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SchoolRecruitmentAttemptsController extends Controller
{

    public function index(School $school)
    {
        return $school
            ->recruitmentAttempts()
            ->with('teacher', 'school')
            ->where('created_at', '>=', now()->subDays(60))
            ->get()
            ->map(fn ($a) => $a->presentForSchool());
    }

    public function store(RecruitmentAttemptRequest $request, School $school)
    {
        try {
            $school->attemptToRecruit($request->teacher(), $request->recruitmentMessage());
        } catch(RecruitmentException $e) {
            abort(Response::HTTP_FORBIDDEN, $e->getMessage());
        }

    }
}
