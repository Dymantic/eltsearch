<?php

namespace App\Policies;

use App\Placements\RecruitmentAttempt;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecruitmentAttemptPolicy
{
    use HandlesAuthorization;


    public function __construct()
    {
        //
    }

    public function dismiss(User $user, RecruitmentAttempt $recruitmentAttempt)
    {
        return $user->isTeacher() && $user->teacher->id === $recruitmentAttempt->teacher_id;
    }
}
