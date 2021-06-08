<?php

namespace App\Console\Commands;

use App\Teachers\Teacher;
use Illuminate\Console\Command;

class PurgeIncompleteTeacherProfiles extends Command
{

    protected $signature = 'teachers:purge-incomplete';


    protected $description = 'Purge teacher profiles that have remained incomplete for too long';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $old_and_incomplete = Teacher::incomplete()
                                     ->where('sent_incomplete_reminder_times', 2)
                                     ->where(
                                         'last_sent_incomplete_reminder',
                                         '<',
                                         now()->subDays(Teacher::ALLOWED_INCOMPLETE_PERIOD)
                                     )
                                     ->get();

        $old_and_incomplete->each(fn(Teacher $t) => $t->purge());

        return 0;
    }
}
