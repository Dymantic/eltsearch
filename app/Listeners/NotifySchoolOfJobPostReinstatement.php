<?php

namespace App\Listeners;

use App\Events\JobPostReinstated;
use App\Notifications\JobPostReinstated as ReinstatementNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifySchoolOfJobPostReinstatement
{

    public function handle(JobPostReinstated $event)
    {
        $admins = $event->jobPost->school->admins;

        Notification::send($admins, new ReinstatementNotification($event->jobPost));
    }
}
