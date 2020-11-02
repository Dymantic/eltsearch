<?php

namespace App\Jobs;

use App\Notifications\SearchMatchesFound;
use App\Placements\JobSearch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class MatchJobSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public JobSearch $jobSearch;

    public function __construct(JobSearch $jobSearch)
    {
        $this->jobSearch = $jobSearch;
    }


    public function handle()
    {
        $matches = $this->jobSearch->findMatches();

        if($matches) {
            Notification::send($this->jobSearch->teacher->user, new SearchMatchesFound($matches));
        }

    }
}
