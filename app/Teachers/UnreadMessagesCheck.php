<?php


namespace App\Teachers;


use App\StatusCheck;

class UnreadMessagesCheck implements StatusCheck
{

    public function __construct(private Teacher $teacher)
    {
    }

    public function check(): bool
    {
        return $this->teacher->user->unreadNotifications->count() > 0;
    }
}
