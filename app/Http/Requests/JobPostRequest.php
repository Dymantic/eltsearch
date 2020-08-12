<?php

namespace App\Http\Requests;

use App\Placements\JobPost;
use App\Placements\JobPostInfo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobPostRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'school_name'            => ['required'],
            'area_id'                => ['exists:areas,id', 'nullable'],
            'engagement'             => [Rule::in(JobPost::ALLOWED_ENGAGEMENT), 'nullable'],
            'hours_per_week'         => ['integer', 'nullable'],
            'min_students_per_class' => ['integer', 'nullable'],
            'max_students_per_class' => ['integer', 'nullable'],
            'student_ages'           => ['array'],
            'student_ages.*'         => [Rule::in(JobPost::ALLOWED_AGES), 'nullable'],
            'work_on_weekends'       => ['boolean', 'nullable'],
            'requirements'           => ['array'],
            'requirements.*'         => [Rule::in(JobPost::ALLOWED_REQUIREMENTS), 'nullable'],
            'salary_rate'            => [Rule::in(JobPost::ALLOWED_SALARY_RATES), 'nullable'],
            'salary_min'             => ['integer', 'nullable'],
            'salary_max'             => ['integer', 'nullable'],
            'start_date'             => ['date', 'nullable'],
            'benefits'               => ['array'],
            'benefits.*'             => [Rule::in(JobPost::ALLOWED_BENEFITS), 'nullable'],
            'contract_length'        => [Rule::in(JobPost::ALLOWED_CONTRACT_LENGTHS), 'nullable'],
        ];
    }

    public function postInfo(): JobPostInfo
    {
        return new JobPostInfo($this->all([
            'school_name',
            'description',
            'area_id',
            'position',
            'engagement',
            'hours_per_week',
            'min_students_per_class',
            'max_students_per_class',
            'student_ages',
            'work_on_weekends',
            'requirements',
            'salary_rate',
            'salary_min',
            'salary_max',
            'start_date',
            'benefits',
            'contract_length',
            'schedule',
        ]));
    }
}
