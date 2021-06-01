<?php

namespace App\Http\Controllers;

use App\Purchasing\Package;
use Illuminate\Http\Request;

class ForSchoolsPageController extends Controller
{
    public function show()
    {
        $job_posts = collect(config('packages'))
            ->filter(fn($package) => $package['type'] === 'token')
            ->map(fn($package) => Package::find($package['id'])->present(app()->getLocale()))
            ->values()->all();

        $passes = collect(config('packages'))
            ->filter(fn($package) => $package['type'] === 'resume_pass')
            ->map(fn($package) => Package::find($package['id'])->present(app()->getLocale()))
            ->values()->all();

        return view("front.for-schools.page", [
            'job_posts' => $job_posts,
            'passes' => $passes,
        ]);
    }
}
