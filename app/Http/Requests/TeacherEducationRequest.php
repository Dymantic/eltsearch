<?php

namespace App\Http\Requests;

use App\Teachers\Teacher;
use App\Teachers\TeacherEducationInfo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherEducationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function teacher(): Teacher
    {
        return $this->teacherProfile;
    }


    public function rules()
    {
        return [
            'education_level' => [Rule::in(Teacher::ALLOWED_EDUCATION_LEVELS), 'nullable'],
        ];
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
