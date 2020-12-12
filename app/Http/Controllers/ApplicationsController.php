<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationRequest;
use App\Nation;
use App\Placements\GuestApplication;
use App\Placements\JobApplication;
use App\Placements\JobPost;
use App\Placements\JobPostPresenter;
use App\Teachers\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ApplicationsController extends Controller
{
    public function create(JobPost $post)
    {
        if(auth()->check() && auth()->user()->isTeacher()) {
            return redirect("/teachers#/apply-to-post/{$post->slug}");
        }


        GuestApplication::startProcess($post);

        return view('front.guest-applications.create-profile', [
            'email' => '',
            'post' => $post,
            'nations' => Nation::orderBy('nationality')->get()->mapWithKeys(fn ($n) => [
                $n->id => $n->nationality
            ])->all(),
            'education_levels' => collect(Teacher::ALLOWED_EDUCATION_LEVELS)
                ->mapWithKeys(fn($l) => [$l => trans('teachers.education_levels.' . $l)])->all()
        ]);
    }

}
