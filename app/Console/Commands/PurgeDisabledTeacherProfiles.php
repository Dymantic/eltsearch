<?php

namespace App\Console\Commands;

use App\Teachers\Teacher;
use Illuminate\Console\Command;

class PurgeDisabledTeacherProfiles extends Command
{

    protected $signature = 'teachers:purge-disabled';


    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $to_purge = Teacher::disabled()->where('disabled_on', '<', now()->subWeek())->get();

        $to_purge->each(fn (Teacher $teacher) => $teacher->purge());
        return 0;
    }
}
