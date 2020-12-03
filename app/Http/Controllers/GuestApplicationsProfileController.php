<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestApplicationProfileRequest;
use App\Nation;
use App\Placements\GuestApplication;
use App\Teachers\Teacher;
use App\User;
use Illuminate\Http\Request;

class GuestApplicationsProfileController extends Controller
{

    public function create()
    {
        return view('front.guest-applications.create-profile', [
            'email' => GuestApplication::contactDetails()->email,
            'post' => GuestApplication::jobPost(),
            'nations' => Nation::all()->mapWithKeys(fn ($n) => [
                $n->id => $n->nationality
            ])->all(),
            'education_levels' => collect(Teacher::ALLOWED_EDUCATION_LEVELS)
            ->mapWithKeys(fn($l) => [$l => trans('teachers.education_levels.' . $l)])->all()
        ]);
    }

    public function store(GuestApplicationProfileRequest $request)
    {
        GuestApplication::createProfileForApplicant(
            $request->generalInfo(),
            $request->educationInfo(),
            $request->get('password')
        );

        return redirect("/guest-applications/add-experience");
    }
}
