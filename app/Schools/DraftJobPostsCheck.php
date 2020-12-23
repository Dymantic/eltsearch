<?php


namespace App\Schools;


use App\StatusCheck;

class DraftJobPostsCheck implements StatusCheck
{

    public function __construct(private School $school)
    {
    }

    public function check(): bool
    {
        return $this
                ->school
                ->jobPosts()
                ->where('is_public', false)
                ->where('first_published_at', null)
                ->count() > 0;
    }
}
