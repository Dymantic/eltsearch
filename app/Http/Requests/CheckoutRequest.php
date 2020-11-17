<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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

    public function paymentDetails()
    {
        return [
            'token' => $this->token,
            'name' => $this->name,
            'email' => auth()->user()->email,
        ];
    }
}
