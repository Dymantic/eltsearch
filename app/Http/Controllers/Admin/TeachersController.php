<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeachersQueryRequest;
use App\PagedData;
use App\Teachers\Teacher;
use App\Teachers\TeacherProfilePresenter;
use Illuminate\Http\Request;

class TeachersController extends Controller
{

    public function index(TeachersQueryRequest $request)
    {
        $page = Teacher::select('teachers.*')
                         ->join('nations', 'nations.id', '=', 'teachers.nation_id')
                         ->where('teachers.name', 'LIKE', "%{$request->search()}%")
                         ->orderBy($request->order(), $request->direction())
                         ->paginate(70);

        return PagedData::forPage($page, fn($t) => TeacherProfilePresenter::forAdmin($t));
    }

    public function show(Teacher $teacher)
    {
        return TeacherProfilePresenter::forAdmin($teacher);
    }
}
