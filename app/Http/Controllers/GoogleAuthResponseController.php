<?php

namespace App\Http\Controllers;

use App\Http\Requests\OAuthRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthResponseController extends Controller
{
    public function store(OAuthRequest $request)
    {
        $user_data = Socialite::driver('google')->stateless()->user()->user;
        if($request->forLogin()) {
            $user = User::findGoogleUser($user_data);

            if(!$user) {
                return redirect('/login')->withErrors([
                    'google_login' => 'You are not registered with this Google account.'
                ]);
            }

            Auth::login($user, true);

            return redirect($user->redirectHome("#/" . $request->intendedHash()));
        }

        if($request->forRegistration()) {
            $user = User::findFacebookUser($user_data);

            if($user) {
                Auth::login($user, true);

                return redirect($user->redirectHome());
            }

            $user = User::registerTeacherViaGoogle($user_data);

            Auth::login($user, true);

            return redirect($user->redirectHome());

        }
    }
}
