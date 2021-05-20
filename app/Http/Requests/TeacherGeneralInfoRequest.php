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
            'email'            => ['email', 'nullable'],
            'date_of_birth'    => ['date', 'nullable'],
            'years_experience' => ['integer', 'nullable'],
            'nation_other'     => ['required_if:nation_id,null'],
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
            'nation_id',
            'nation_other',
            'date_of_birth',
            'email',
            'native_language',
            'other_languages',
            'years_experience'
        ]));
    }
}
