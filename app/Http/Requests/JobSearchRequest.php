<?php

namespace App\Http\Requests;

use App\Placements\JobPost;
use App\Placements\JobSearch;
use App\Placements\JobSearchCriteria;
use App\Teachers\Teacher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobSearchRequest extends FormRequest
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
            'area_ids'        => ['array'],
            'area_ids.*'      => ['exists:areas,id'],
            'student_ages'    => ['array'],
            'student_ages.*'  => [Rule::in(JobPost::ALLOWED_AGES)],
            'benefits'        => ['array'],
            'benefits.*'      => [Rule::in(JobPost::ALLOWED_BENEFITS)],
            'contract_type'   => ['array'],
            'contract_type.*' => [Rule::in(JobPost::ALLOWED_CONTRACT_LENGTHS)],
            'salary'          => [Rule::in(JobSearch::ALLOWED_SALARIES), 'nullable'],
            'hours_per_week'  => [Rule::in(JobSearch::ALLOWED_HOURS), 'nullable'],
            'weekends'        => ['boolean', 'nullable']
        ];
    }

    public function searchInfo(): JobSearchCriteria
    {
        return new JobSearchCriteria($this->all([
            'area_ids',
            'student_ages',
            'benefits',
            'contract_type',
            'salary',
            'hours_per_week',
            'weekends'
        ]));
    }
}
