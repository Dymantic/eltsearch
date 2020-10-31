<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Notifications\DatabaseNotification;

class ReadNotificationsPolicy
{
    use HandlesAuthorization;

    public function read(User $user, DatabaseNotification $notification)
    {
        return $notification->notifiable->is($user);
    }

    public function delete(User $user, DatabaseNotification $notification)
    {
        return $notification->notifiable->is($user);
    }
}
