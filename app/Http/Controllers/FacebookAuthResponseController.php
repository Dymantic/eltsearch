<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacebookAuthRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthResponseController extends Controller
{
    public function store(FacebookAuthRequest $request)
    {
        if($request->forLogin()) {
            $user = User::findFacebookUser($this->facebookUser());

            if(!$user) {
                return redirect('/login')->withErrors([
                    'facebook_login' => 'You have not registered yet with this facebook account.'
                ]);
            }

            Auth::login($user, true);

            return redirect($user->redirectHome());
        }

        if($request->forRegistration()) {

            $user = User::findFacebookUser($this->facebookUser());

            if($user) {
                Auth::login($user, true);

                return redirect($user->redirectHome());
            }

            $user = User::registerTeacherViaFacebook($this->facebookUser());

            Auth::login($user, true);

            return redirect($user->redirectHome());

        }


    }

    private function facebookUser()
    {
        $fb_user = Socialite::driver('facebook')->user();

        return [
            'name' => $fb_user->getName(),
            'email' => $fb_user->getEmail(),
            'id' => $fb_user->getId(),
            'avatar' => $fb_user->getAvatar(),
        ];
    }
}
