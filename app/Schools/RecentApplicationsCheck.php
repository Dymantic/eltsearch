<?php


namespace App\Schools;


use App\Placements\JobApplication;
use App\StatusCheck;

class RecentApplicationsCheck implements StatusCheck
{

    public function __construct(private School $school)
    {
    }

    public function check(): bool
    {
        $posts = $this->school->jobPosts()->where('first_published_at', '>=', now()->subMonth())->get();

        if($posts->count() === 0) {
            return false;
        }

        return JobApplication::whereIn('job_post_id', $posts->pluck('id')->all())
                             ->where('created_at', '>=', now()->subWeek())
                             ->count() > 0;
    }
}
