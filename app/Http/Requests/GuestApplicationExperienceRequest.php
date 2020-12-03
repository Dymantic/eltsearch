<?php

namespace App\Http\Requests;

use App\Teachers\PreviousEmploymentInfo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class GuestApplicationExperienceRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'experience' => ['array'],
            'experience.*.employer' => ['required'],
            'experience.*.job_title'   => ['required'],
            'experience.*.start_month' => ['required', 'integer', 'min:1', 'max:12'],
            'experience.*.start_year'  => ['required', 'integer', 'min:1950', 'max:2100'],
            'experience.*.end_month'   => ['required_with:experience.*.end_year', 'integer', 'min:1', 'max:12', 'nullable'],
            'experience.*.end_year'    => ['required_with:experience.*.end_month', 'integer', 'min:1950', 'max:2100', 'nullable'],
        ];
    }

    public function previousEmployments(): Collection
    {
        return collect($this->experience)->map(fn ($e) => new PreviousEmploymentInfo($e));
    }
}
