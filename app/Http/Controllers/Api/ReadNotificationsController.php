<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class ReadNotificationsController extends Controller
{
    public function store()
    {
        $notification = DatabaseNotification::findOrFail(request('notification_id'));

        $this->authorize('read', $notification);

        $notification->markAsRead();
    }
}
