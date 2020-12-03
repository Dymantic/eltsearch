<?php

namespace App\Http\Controllers;

use App\Placements\GuestApplication;
use App\Teachers\Teacher;
use Illuminate\Http\Request;

class GuestApplicationsProfileImageController extends Controller
{
    public function store()
    {
        request()->validate([
            'image' => ['required', 'image']
        ]);

        $teacher = GuestApplication::teacherProfile();

        $teacher->setAvatar(request('image'));
    }
}
