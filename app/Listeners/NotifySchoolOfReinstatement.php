<?php

namespace App\Listeners;

use App\Events\SchoolProfileReinstated;
use App\Notifications\SchoolProfileReinstated as ReinstatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifySchoolOfReinstatement
{

    public function handle(SchoolProfileReinstated $event)
    {
        Notification::send($event->school->admins, new ReinstatedNotification($event->school));
    }
}
