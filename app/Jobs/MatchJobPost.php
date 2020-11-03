<?php

namespace App\Jobs;

use App\Notifications\JobPostMatchesFound;
use App\Placements\JobMatch;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class MatchJobPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public JobPost $jobPost;

    public function __construct(JobPost $jobPost)
    {
        $this->jobPost = $jobPost;
    }


    public function handle()
    {
        $matches = $this->jobPost->findMatches();

        $matches->each(function(JobMatch $match) {
            $searching_user = $match->searchingUser();
            if($searching_user) {
                Notification::send($match->searchingUser(), new JobPostMatchesFound($this->jobPost));
            }
        });
    }
}
