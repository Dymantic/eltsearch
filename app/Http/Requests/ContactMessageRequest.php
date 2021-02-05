<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ContactMessageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['email', 'required'],
            'message' => ['required'],
        ];
    }

    public function name(): string
    {
        return $this->get('name', 'anonymous');
    }

    public function email(): string
    {
        return $this->get('email', 'not given');
    }

    public function message(): string
    {
        return $this->get('message', '');
    }

}
