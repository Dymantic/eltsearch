<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    public function index()
    {
        return [
            'notifications' => auth()->user()->getNotifications(),
            'last_fetched' => now()->timestamp,
        ];
    }

    public function delete(DatabaseNotification $notification)
    {
        $this->authorize('delete', $notification);

        $notification->delete();
    }
}
