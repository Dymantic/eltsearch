<?php

namespace App\Http\Requests;

use App\ContactPersonInfo;
use Illuminate\Foundation\Http\FormRequest;

class ShowOfInterestRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'contact_name' => ['required'],
            'email' => ['required_without:phone', 'email', 'nullable'],
            'phone' => ['required_without:email'],
        ];
    }

    public function contactPersonInfo(): ContactPersonInfo
    {
        return new ContactPersonInfo($this->all('contact_name', 'email', 'phone'));
    }
}
