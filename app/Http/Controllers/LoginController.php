<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        $hash = $request->get('hash');

        $response = response()->redirectToIntended($user->redirectHome($hash));
        $response->setTargetUrl($response->getTargetUrl() . $hash);

        return $response;
    }
}
