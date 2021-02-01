<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherRegistrationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    protected function getRedirectUrl()
    {
        return parent::getRedirectUrl() . "#teachers";
    }


    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
        ];
    }

    public function registrationFields(): array
    {
        return $this->only('name', 'email', 'password');
    }
}
