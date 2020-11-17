<?php

namespace App\Http\Requests;

use App\BillingDetails;
use Illuminate\Foundation\Http\FormRequest;

class BillingDetailsRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'city' => ['required'],
            'country' => ['required'],
            'zip' => ['required'],
            'address' => ['required'],
        ];
    }

    public function billingDetails(): BillingDetails
    {
        return new BillingDetails($this->all([
            'city',
            'address',
            'zip',
            'country',
            'state',
        ]));
    }
}
