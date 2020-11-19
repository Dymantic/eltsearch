<?php

namespace App\Http\Controllers\Teachers;

use App\DateFormatter;
use App\Http\Controllers\Controller;
use App\Placements\JobMatch;
use App\Placements\JobPostPresenter;
use Illuminate\Http\Request;

class TeacherJobMatchesController extends Controller
{
    public function index()
    {
        return request('teacherProfile')
            ->jobMatches()
            ->latest()
            ->get()
            ->map(fn ($match) => [
                'id' => $match->id,
                'matched_on' => DateFormatter::pretty($match->created_at),
                'post' => JobPostPresenter::forAdmin($match->jobPost),
            ])->values()->all();
    }

    public function destroy(JobMatch $match)
    {
        $match->dismiss();
    }
}
