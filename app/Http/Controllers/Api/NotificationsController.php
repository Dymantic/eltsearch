<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    public function index()
    {
        return auth()->user()->getNotifications();
    }

    public function delete(DatabaseNotification $notification)
    {
        $this->authorize('delete', $notification);

        $notification->delete();
    }
}
