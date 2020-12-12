<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestApplicationExperienceRequest;
use App\Placements\GuestApplication;
use App\Teachers\Teacher;
use Illuminate\Http\Request;

class GuestApplicationExperienceController extends Controller
{

    public function create()
    {
        return view('front.guest-applications.add-experience', ['post' => GuestApplication::jobPost()->toArray()]);
    }

    public function store(GuestApplicationExperienceRequest $request)
    {
        $teacher = GuestApplication::teacherProfile();

        $request->previousEmployments()->each(fn ($e) => $teacher->addPreviousEmployment($e));

        return redirect("/guest-applications/add-profile-image");
    }
}
