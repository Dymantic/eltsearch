<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacebookAuthRequest extends FormRequest
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
        return tap($this->session()->get('fb_login_intention') === 'login', function ($is_login) {
            if ($is_login) {
                $this->session()->forget('fb_login_intention');
            }
        });
    }

    public function forRegistration(): bool
    {
        return tap(
            $this->session()->get('fb_login_intention') === 'register',
            function ($is_register) {
                if ($is_register) {
                    $this->session()->forget('fb_login_intention');
                }
            });
    }

    public function intendedHash(): string
    {
        return $this->session()->pull('fb_login_hash', '');
    }
}
