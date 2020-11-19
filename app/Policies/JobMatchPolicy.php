<?php

namespace App\Policies;

use App\Placements\JobMatch;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobMatchPolicy
{
    use HandlesAuthorization;

    public function manage(User $user, JobMatch $jobMatch)
    {
        return $jobMatch->searchingUser()->is($user);
    }
}
