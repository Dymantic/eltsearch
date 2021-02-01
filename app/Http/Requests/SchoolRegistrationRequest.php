<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SchoolRegistrationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    protected function getRedirectUrl()
    {
        return parent::getRedirectUrl() . "#schools";
    }


    public function rules()
    {
        return [
            'name'           => ['required'],
            'email'          => ['required', 'email', Rule::unique('users', 'email')],
            'password'       => ['required', 'min:8', 'confirmed'],
            'school_name'    => ['required', Rule::unique('schools', 'name')],
            'preferred_lang' => ['required', Rule::in(['en', 'zh'])],
        ];
    }

    public function registrationFields(): array
    {
        return $this->only([
            'name',
            'email',
            'password',
            'school_name',
            'school_address',
            'preferred_lang'
        ]);
    }
}
