<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherAvatarController extends Controller
{
    public function store()
    {
        request()->validate([
            'image' =>['required', 'image']
        ]);

        request('teacherProfile')->setAvatar(request('image'));
    }
}
