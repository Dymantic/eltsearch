<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherAreaController extends Controller
{
    public function update()
    {
        request()->validate([
            'area_id' => ['exists:areas,id'],
        ]);

        request('teacherProfile')->setLocation(request('area_id'));
    }
}
