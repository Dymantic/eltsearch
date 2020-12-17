<?php

namespace App\Http\Requests;

use App\Placements\RecruitmentMessage;
use App\Teachers\Teacher;
use Illuminate\Foundation\Http\FormRequest;

class RecruitmentAttemptRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'teacher_slug'   => ['required', 'exists:teachers,slug'],
            'message'        => ['required'],
            'contact_person' => ['required'],
            'email' => ['required_without:phone', 'email', 'nullable'],
            'phone' => ['required_without:email'],
        ];
    }

    public function teacher(): ?Teacher
    {
        return Teacher::firstWhere('slug', $this->teacher_slug);
    }

    public function recruitmentMessage(): RecruitmentMessage
    {
        return new RecruitmentMessage($this->all([
            'message',
            'contact_person',
            'email',
            'phone',
        ]));
    }

}
