<?php

namespace App\Providers;

use App\Placements\JobMatch;
use App\Placements\JobPost;
use App\Placements\RecruitmentAttempt;
use App\Policies\JobMatchPolicy;
use App\Policies\JobPostPolicy;
use App\Policies\PreviousEmploymentPolicy;
use App\Policies\ReadNotificationsPolicy;
use App\Policies\RecruitmentAttemptPolicy;
use App\Policies\SchoolPolicy;
use App\Schools\School;
use App\Teachers\PreviousEmployment;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        School::class               => SchoolPolicy::class,
        JobPost::class              => JobPostPolicy::class,
        PreviousEmployment::class   => PreviousEmploymentPolicy::class,
        DatabaseNotification::class => ReadNotificationsPolicy::class,
        JobMatch::class             => JobMatchPolicy::class,
        RecruitmentAttempt::class => RecruitmentAttemptPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
