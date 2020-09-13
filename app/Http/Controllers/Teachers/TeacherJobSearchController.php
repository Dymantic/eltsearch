<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobSearchRequest;
use App\Placements\JobSearch;
use App\Placements\JobSearchPresenter;
use Illuminate\Http\Request;

class TeacherJobSearchController extends Controller
{

    public function show()
    {
        $search = request('teacherProfile')->jobSearches()->latest()->first();

        return JobSearchPresenter::forTeacher($search ?? new JobSearch());
    }


    public function store(JobSearchRequest $request)
    {
        $request->teacher()->createJobSearch($request->searchInfo());
    }

    public function delete(JobSearch $search)
    {
        $search->delete();
    }
}
