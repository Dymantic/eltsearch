<?php

namespace App\Console\Commands;

use App\Schools\School;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class AwardCurrentSchoolsFreePasses extends Command
{

    protected $signature = 'schools:award-free-passes';

    protected $description = 'Award free tokens and resume pass to signed up schools';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $expiry = Carbon::parse('2022-05-31')->endOfDay();
        $schools = School::all()
            ->each(function (School $school) use ($expiry) {
                $school->awardFreeTokens(6, $expiry);
                $school->awardFreeResumePass($expiry);
            });
        return 0;
    }
}
