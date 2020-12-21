<?php


namespace App\Teachers;


use App\StatusCheck;

class RecentJobMatchesCheck implements StatusCheck
{

    public function __construct(private Teacher $teacher)
    {
    }


    public function check(): bool
    {
        if(!$this->teacher->jobMatches()) {
            return false;
        }
        return $this
            ->teacher
            ->jobMatches()
            ->where('created_at', '>=', now()->subWeek())
            ->count() > 0;
    }
}
