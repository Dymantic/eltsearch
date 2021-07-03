<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolsQueryRequest;
use App\PagedData;
use App\Schools\School;
use App\Schools\SchoolPresenter;
use Illuminate\Http\Request;

class SchoolsController extends Controller
{

    public function index(SchoolsQueryRequest $request)
    {

        $page = School::select('schools.*')
                       ->leftJoin('areas', 'areas.id', '=', 'schools.area_id')
                       ->where('schools.name', 'LIKE', "%{$request->search()}%")
                       ->orderBy($request->order(), $request->direction())
                       ->paginate(70);


        return PagedData::forPage($page, fn($s) => SchoolPresenter::forAdmin($s));

    }

    public function show(School $school)
    {
        $school->load('area');
        return SchoolPresenter::forAdmin($school);
    }
}
