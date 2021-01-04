<?php

namespace App\Listeners;

use App\Events\SchoolProfileDisabled;
use App\Notifications\SchoolProfileDisabled as DisabledNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifySchoolOfDisabling
{

    public function handle(SchoolProfileDisabled $event)
    {
        Notification::send($event->school->admins, new DisabledNotification($event->school));
    }
}
