<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestApplicationRequest;
use App\Placements\GuestApplication;
use Illuminate\Http\Request;

class GuestApplicationsController extends Controller
{

    public function create()
    {
        return view('front.guest-applications.create-application', [
            'post' => GuestApplication::jobPost()->toArray(),
        ]);
    }

    public function store(GuestApplicationRequest $request)
    {
        $teacher = GuestApplication::teacherProfile();
        $teacher->applyForJob(GuestApplication::jobPost(), $request->cover_letter, $request->contactDetails());

        auth()->login($teacher->user);
        return redirect("/teachers/#applications");
    }
}
