<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OAuthRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }

    public function forLogin(): bool
    {
        return tap($this->session()->get('oauth_login_intention') === 'login', function ($is_login) {
            if ($is_login) {
                $this->session()->forget('oauth_login_intention');
            }
        });
    }

    public function forRegistration(): bool
    {
        return tap(
            $this->session()->get('oauth_login_intention') === 'register',
            function ($is_register) {
                if ($is_register) {
                    $this->session()->forget('oauth_login_intention');
                }
            });
    }

    public function intendedHash(): string
    {
        return $this->session()->pull('oauth_login_hash', '');
    }
}
