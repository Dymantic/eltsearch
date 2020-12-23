<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherDashboardStatusController extends Controller
{
    public function show()
    {
        return ['statuses' => request('teacherProfile')->checkStatus()->values()->all()];
    }
}
