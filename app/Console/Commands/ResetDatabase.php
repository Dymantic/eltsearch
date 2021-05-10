<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reset db completely';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $admin = User::where('account_type', User::ACCOUNT_ADMIN)->get();

        $tables = collect([
            'announcements',
            'areas',
            'countries',
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
            'regions',
            'resume_passes',
            'school_school_type',
            'school_types',
            'school_user',
            'schools',
            'recruitment_attempts',
            'show_of_interests',
            'teachers',
            'tokens',
            'users',
        ]);

        Schema::disableForeignKeyConstraints();
        $tables->each(fn($table) => Schema::dropIfExists($table));
        Schema::enableForeignKeyConstraints();

        Artisan::call('migrate');
        Artisan::call('nations:populate');
        Artisan::call('locations:towns');

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
