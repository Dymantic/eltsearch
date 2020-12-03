<?php

namespace App\Http\Requests;

use App\Teachers\Teacher;
use App\Teachers\TeacherEducationInfo;
use App\Teachers\TeacherGeneralInfo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuestApplicationProfileRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed'],
            'nation_id' => ['exists:nations,id'],
            'date_of_birth' => ['required', 'date'],
            'native_language' => ['required'],
            'years_experience' => ['required', 'integer'],
            'education_level' => [Rule::in(Teacher::ALLOWED_EDUCATION_LEVELS)],
            'education_institution' => ['required'],
            'education_qualification' => ['required'],
        ];
    }

    public function generalInfo(): TeacherGeneralInfo
    {
        return new TeacherGeneralInfo($this->all([
            'name',
            'email',
            'password_confirmation',
            'nation_id',
            'date_of_birth',
            'native_language',
            'other_languages',
            'years_experience',
        ]));
    }

    public function educationInfo(): TeacherEducationInfo
    {
        return new TeacherEducationInfo($this->all([
            'education_level',
            'education_institution',
            'education_qualification',
        ]));
    }
}
