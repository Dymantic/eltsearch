<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublicTeachersQueryRequest;
use App\Locations\Area;
use App\PagedData;
use App\Schools\School;
use App\Teachers\Teacher;
use App\Teachers\TeacherProfilePresenter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PublicTeachersController extends Controller
{
    public function index(PublicTeachersQueryRequest $request, School $school)
    {

        $page = Teacher::select('teachers.*')
                       ->complete()
                       ->nearArea($request->schoolArea())
                       ->withNationality($request->nationality())
                       ->withExperienceLevel($request->experienceLevel())
                       ->join('nations', 'nations.id', '=', 'teachers.nation_id')
                       ->orderBy($request->orderColumn(), $request->orderDirection())
                       ->paginate(40);

        return PagedData::forPage($page, fn($teacher) => TeacherProfilePresenter::forSchool($teacher, app()->getLocale()));
    }

    public function show(School $school, $slug)
    {
        if(!$school->hasResumeAccess()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $teacher = Teacher::where('slug', $slug)->firstOrFail();
        return TeacherProfilePresenter::forSchool($teacher, app()->getLocale());
    }
}
