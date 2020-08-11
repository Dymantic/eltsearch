<?php

namespace App\Policies;

use App\Teachers\PreviousEmployment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PreviousEmploymentPolicy
{
    use HandlesAuthorization;


    public function __construct()
    {
        //
    }

    public function manage(User $user, PreviousEmployment $employment)
    {
        return $employment->teacher->user->is($user);
    }
}
