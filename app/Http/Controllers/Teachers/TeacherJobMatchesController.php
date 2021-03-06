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
        $match_query = request('teacherProfile')->jobMatches();

        if(!$match_query) {
            return [];
        }

        return $match_query
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
