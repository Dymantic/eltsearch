<?php

namespace App\Http\Requests;

use App\ContactDetails;
use Illuminate\Foundation\Http\FormRequest;

class GuestApplicationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'cover_letter'  => ['required'],
            'email'         => ['required_without:phone', 'email'],
            'phone'         => ['required_without:email'],
        ];
    }

    public function contactDetails(): ContactDetails
    {
        return new ContactDetails([
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
    }
}
