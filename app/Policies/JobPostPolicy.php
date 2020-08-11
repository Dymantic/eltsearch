<?php

namespace App\Policies;

use App\Placements\JobPost;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function manage(User $user, JobPost $post)
    {
        return $user->schools->contains($post->school);
    }
}
