<?php

namespace App\Http\Controllers;

use App\Placements\GuestApplication;
use App\Teachers\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GuestApplicationsProfileImageController extends Controller
{

    public function create()
    {
        return view('front.guest-applications.add-profile-image', ['post' => GuestApplication::jobPost()->toArray()]);
    }

    public function store()
    {
        request()->validate([
            'image' => ['required', 'image'],
        ]);

        $teacher = GuestApplication::teacherProfile();

        $teacher->setAvatar(request('image'));
    }
}
