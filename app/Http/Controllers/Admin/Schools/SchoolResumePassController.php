<?php

namespace App\Http\Controllers\Admin\Schools;

use App\DateFormatter;
use App\Http\Controllers\Controller;
use App\Schools\School;
use Illuminate\Http\Request;

class SchoolResumePassController extends Controller
{
    public function show(School $school)
    {
        if(!$school->hasResumeAccess()) {
            return [
                'has_access' => false,
                'expires_on' => '',
                'days_remaining' => 0,
            ];
        }

        $pass = $school->resumePasses()
                       ->where('expires_on', '>=', now())
                       ->orderBy('expires_on', 'desc')
                       ->first();

        return [
            'has_access' => true,
            'expires_on' => DateFormatter::pretty($pass->expires_on),
            'days_remaining' => now()->diffInDays($pass->expires_on),
        ];
    }
}
