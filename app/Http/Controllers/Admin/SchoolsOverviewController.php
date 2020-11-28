<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Schools\School;
use App\Schools\SchoolPresenter;
use Illuminate\Http\Request;

class SchoolsOverviewController extends Controller
{
    public function show()
    {
        return [
            'total_count'          => School::count(),
            'signed_up_last_month' => School::signedUpSince(now()->subMonth())->count(),
            'recent'               => School::signedUpSince(now()->subMonth())
                                            ->latest()
                                            ->limit(20)
                                            ->get()
                                            ->map(fn($s) => SchoolPresenter::forAdmin($s)),
        ];
    }
}
