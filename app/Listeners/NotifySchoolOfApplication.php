<?php

namespace App\Listeners;

use App\Events\ApplicationReceived;
use App\Notifications\ApplicationReceived as ApplicationReceivedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifySchoolOfApplication
{


    public function handle(ApplicationReceived $event)
    {
        $admins = $event->jobApplication->jobPost->school->admins;
        Notification::send($admins, new ApplicationReceivedNotification($event->jobApplication));
    }
}
