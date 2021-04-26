<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FlushAllData extends Command
{

    protected $signature = 'housekeeping:sweep';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncates all tables ** use at your own risk **';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $admin = User::where('account_type', User::ACCOUNT_ADMIN)->get();

        $tables = collect([
            'announcements',
//            'areas',
//            'countries',
            'failed_jobs',
            'job_applications',
            'job_matches',
            'job_posts',
            'job_searches',
            'media',
            'migrations',
            'nations',
            'notifications',
            'password_resets',
            'previous_employments',
            'purchases',
//            'regions',
            'resume_passes',
            'school_school_type',
            'school_types',
            'school_user',
            'schools',
            'recruitment_attempts',
            'show_of_interests',
            'teachers',
//            'tokens',
            'users',
        ]);

        Schema::disableForeignKeyConstraints();
        $tables->each(fn($table) => DB::table($table)->truncate());
        Schema::enableForeignKeyConstraints();

        $admin->each(function ($admin) {
            User::create([
                'name'           => $admin->name,
                'email'          => $admin->email,
                'account_type'   => User::ACCOUNT_ADMIN,
                'password'       => $admin->password,
                'remember_token' => $admin->remember_token,
            ]);
        });

        return 0;
    }
}
