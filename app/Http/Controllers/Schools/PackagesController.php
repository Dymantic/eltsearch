<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Purchasing\Package;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    public function index()
    {
        return collect(config('packages'))
            ->map(fn($package) => Package::find($package['id'])->present(app()->getLocale()))
            ->values()->all();
    }
}
