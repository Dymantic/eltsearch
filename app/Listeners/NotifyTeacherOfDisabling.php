<?php

namespace App\Listeners;

use App\Events\TeacherProfileDisabled;
use App\Notifications\TeacherProfileDisabled as DisabledNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyTeacherOfDisabling
{

    public function __construct()
    {
        //
    }


    public function handle(TeacherProfileDisabled $event)
    {
        Notification::send($event->teacher->user, new DisabledNotification($event->teacher));
    }
}
