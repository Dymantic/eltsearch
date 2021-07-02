<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Notifications\ContactMessage;
use App\Recaptcha;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactMessageController extends Controller
{

    public function show()
    {
        return view('front.contact.page', [
            'recaptcha_key' => config('services.recaptcha.site_key')
        ]);
    }

    public function store(ContactMessageRequest $request)
    {
        abort_unless(Recaptcha::accepts($request->get('recaptcha_token', ''), $request->ip()), 422);

        $admins = User::where('account_type', User::ACCOUNT_ADMIN)
                      ->get()
            ->each
            ->notify(new ContactMessage($request->name(), $request->email(), $request->message()));


    }
}
