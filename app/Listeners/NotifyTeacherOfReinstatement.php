<?php

namespace App\Listeners;

use App\Events\TeacherProfileReinstated;
use App\Notifications\TeacherProfileReinstated as ReinstatementNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyTeacherOfReinstatement
{

    public function __construct()
    {}


    public function handle(TeacherProfileReinstated $event)
    {
        Notification::send($event->teacher->user, new ReinstatementNotification($event->teacher));
    }
}
