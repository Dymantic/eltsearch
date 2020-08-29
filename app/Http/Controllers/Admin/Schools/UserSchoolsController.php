<?php

namespace App\Http\Controllers\Admin\Schools;

use App\Http\Controllers\Controller;
use App\Schools\School;
use Illuminate\Http\Request;

class UserSchoolsController extends Controller
{
    public function index()
    {
        return request()->user()->schools->map(fn (School $school) => [
            'id' => $school->id,
            'name' => $school->name,
            'introduction' => $school->introduction,
            'area_id' => $school->area_id,
            'school_types' => $school->schoolTypes->map->toArray()->values()->all(),
        ]);
    }
}
