<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NewNotificationsStatusController extends Controller
{
    public function show()
    {
        $last_checked = Carbon::createFromTimestamp(request('t'));

        return [
            'has_new'   => auth()
                    ->user()
                    ->notifications()
                    ->where('created_at', '>', $last_checked)
                    ->count() > 0,
            'timestamp' => now()->timestamp
        ];
    }
}
