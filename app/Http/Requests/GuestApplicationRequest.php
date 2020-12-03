<?php

namespace App\Http\Requests;

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
            'job_post_slug' => ['exists:job_posts,slug'],
            'cover_letter'  => ['required'],
            'email'         => ['required_without:phone', 'email'],
            'phone'         => ['required_without:email'],
        ];
    }

    public function applicationInfo(): array
    {
        return [
            'post_slug' => $this->job_post_slug,
            'cover_letter'  => $this->cover_letter,
            'contact_email' => $this->email,
            'contact_phone' => $this->phone,
        ];
    }
}
