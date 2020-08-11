<?php

namespace App\Http\Requests;

use App\Teachers\PreviousEmploymentInfo;
use App\Teachers\Teacher;
use Illuminate\Foundation\Http\FormRequest;

class PreviousEmploymentRequest extends FormRequest
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
            'employer'    => ['required'],
            'job_title'   => ['required'],
            'start_month' => ['required', 'integer', 'min:1', 'max:12'],
            'start_year'  => ['required', 'integer', 'min:1950', 'max:2100'],
            'end_month'   => ['required_with:end_year', 'integer', 'min:1', 'max:12', 'nullable'],
            'end_year'    => ['required_with:end_month', 'integer', 'min:1950', 'max:2100', 'nullable'],
        ];
    }

    public function employmentInfo(): PreviousEmploymentInfo
    {
        return new PreviousEmploymentInfo($this->all([
            'employer',
            'start_month',
            'start_year',
            'end_month',
            'end_year',
            'employed_to',
            'job_title',
            'description',
        ]));
    }
}
