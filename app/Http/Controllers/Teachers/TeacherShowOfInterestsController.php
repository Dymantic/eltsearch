<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Placements\JobApplication;
use Illuminate\Http\Request;

class TeacherShowOfInterestsController extends Controller
{
    public function index()
    {
        return request('teacherProfile')
            ->jobApplications
            ->flatMap(
                fn (JobApplication $application) => $application->showOfInterests
            )
            ->map->toArray();
    }
}
