<?php

namespace App\Http\Controllers;

use App\Purchasing\Package;
use Illuminate\Http\Request;

class ForSchoolsPageController extends Controller
{
    public function show()
    {
        $packages = collect(config('packages'))
            ->map(fn($package) => Package::find($package['id'])->present(app()->getLocale()))
            ->values()->all();
        return view("front.for-schools.page", ['packages' => $packages]);
    }
}
