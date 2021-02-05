<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Notifications\ContactMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactMessageController extends Controller
{
    public function store(ContactMessageRequest $request)
    {
        $admins = User::where('account_type', User::ACCOUNT_ADMIN)
                      ->get()->each->notify(new ContactMessage($request->name(), $request->email(), $request->message()));


    }
}
