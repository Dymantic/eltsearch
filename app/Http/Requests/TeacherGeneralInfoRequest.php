<?php

namespace App\Http\Requests;

use App\Teachers\Teacher;
use App\Teachers\TeacherGeneralInfo;
use Illuminate\Foundation\Http\FormRequest;

class TeacherGeneralInfoRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'email'         => ['email', 'nullable'],
            'date_of_birth' => ['date', 'nullable'],
            'area_id'       => ['exists:areas,id', 'nullable'],
        ];
    }

    public function teacher(): Teacher
    {
        return $this->teacherProfile;
    }

    public function generalInfo(): TeacherGeneralInfo
    {
        return new TeacherGeneralInfo($this->all([
            'name',
            'nationality',
            'date_of_birth',
            'email',
            'area_id',
            'native_language',
            'other_languages',
        ]));
    }
}
