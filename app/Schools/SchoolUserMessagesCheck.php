<?php


namespace App\Schools;


use App\StatusCheck;

class SchoolUserMessagesCheck implements StatusCheck
{

    public function __construct(private School $school)
    {
    }

    public function check(): bool
    {
        $user = auth()->user();

        if(!$user) {
            return false;
        }

        return $user->unreadNotifications()->count() > 0;
    }
}
