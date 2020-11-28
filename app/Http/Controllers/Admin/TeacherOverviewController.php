<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Teachers\Teacher;
use App\Teachers\TeacherProfilePresenter;
use Illuminate\Http\Request;

class TeacherOverviewController extends Controller
{
    public function show()
    {
        $recent_signups = Teacher::with('previousEmployments', 'nation')
                                 ->signedUpSince(now()->subMonth())
                                 ->latest()
                                ->limit(20)
                                 ->get();

        return [
            'total_count'          => Teacher::count(),
            'signed_up_last_month' => $recent_signups->count(),
            'recent'               => $recent_signups
                ->map(fn($t) => TeacherProfilePresenter::forAdmin($t))
                ->values()->all(),
        ];
    }
}
