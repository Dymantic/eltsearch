<?php

namespace App\Providers;

use App\Placements\JobPost;
use App\Policies\JobPostPolicy;
use App\Policies\PreviousEmploymentPolicy;
use App\Policies\SchoolPolicy;
use App\Schools\School;
use App\Teachers\PreviousEmployment;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        School::class             => SchoolPolicy::class,
        JobPost::class            => JobPostPolicy::class,
        PreviousEmployment::class => PreviousEmploymentPolicy::class,
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
