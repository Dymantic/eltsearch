<?php

namespace App\Listeners;

use App\Events\JobPostDisabled;
use App\Notifications\JobPostDisabled as DisabledNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifySchoolOfDisabledJobPost
{

    public function handle(JobPostDisabled $event)
    {
        $admins = $event->jobPost->school->admins;

        Notification::send($admins, new DisabledNotification($event->jobPost));
    }
}
