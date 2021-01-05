<?php

namespace App\Providers;

use App\Events\ApplicationReceived;
use App\Events\JobPostDisabled;
use App\Events\JobPostReinstated;
use App\Events\SchoolProfileDisabled;
use App\Events\SchoolProfileReinstated;
use App\Events\TeacherProfileDisabled;
use App\Events\TeacherProfileReinstated;
use App\Listeners\NotifySchoolOfApplication;
use App\Listeners\NotifySchoolOfDisabledJobPost;
use App\Listeners\NotifySchoolOfDisabling;
use App\Listeners\NotifySchoolOfJobPostReinstatement;
use App\Listeners\NotifySchoolOfReinstatement;
use App\Listeners\NotifyTeacherOfDisabling;
use App\Listeners\NotifyTeacherOfReinstatement;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ApplicationReceived::class => [
            NotifySchoolOfApplication::class
        ],
        TeacherProfileDisabled::class => [
            NotifyTeacherOfDisabling::class
        ],
        TeacherProfileReinstated::class => [
            NotifyTeacherOfReinstatement::class,
        ],
        SchoolProfileDisabled::class => [
            NotifySchoolOfDisabling::class,
        ],
        SchoolProfileReinstated::class => [
            NotifySchoolOfReinstatement::class,
        ],
        JobPostDisabled::class => [
            NotifySchoolOfDisabledJobPost::class,
        ],
        JobPostReinstated::class => [
            NotifySchoolOfJobPostReinstatement::class,
        ]


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
