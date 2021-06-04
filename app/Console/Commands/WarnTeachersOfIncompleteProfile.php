<?php

namespace App\Console\Commands;

use App\Notifications\FinalWarningForIncompleteProfiles;
use App\Notifications\RemindTeacherOfIncompleteProfile;
use App\Teachers\Teacher;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class WarnTeachersOfIncompleteProfile extends Command
{

    protected $signature = 'teachers:warn-incomplete-profiles';


    protected $description = 'Send notifications to warn teachers of incomplete profiles';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $incomplete = Teacher::with('user')
                             ->incomplete()
                             ->where('created_at', '<', now()->subWeek())
                             ->where(function ($q) {
                                 return $q->where('last_sent_incomplete_reminder', '<', now()->subDays(Teacher::ALLOWED_INCOMPLETE_PERIOD))
                                          ->orWhereNull('last_sent_incomplete_reminder');
                             })
                             ->get();

        $incomplete->each(function (Teacher $teacher) {
            if($teacher->sent_incomplete_reminder_times === 0) {
                Notification::send($teacher->user, new RemindTeacherOfIncompleteProfile($teacher));
            } else {
                Notification::send($teacher->user, new FinalWarningForIncompleteProfiles($teacher));
            }

            $teacher->markAsRemindedOfIncompleteProfile();
        });

        return 0;
    }
}
