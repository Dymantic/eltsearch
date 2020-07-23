<?php

namespace App\Http\Requests;

use App\Schools\SchoolProfileInfo;
use Illuminate\Foundation\Http\FormRequest;

class SchoolProfileRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'           => ['required'],
            'area_id'        => ['exists:areas,id'],
            'school_types'   => ['array'],
            'school_types.*' => ['exists:school_types,id']
        ];
    }

    public function schoolProfileInfo(): SchoolProfileInfo
    {
        return new SchoolProfileInfo([
            'name'         => $this->get('name'),
            'introduction' => $this->get('introduction', ''),
            'area_id'      => $this->get('area_id'),
            'school_types' => $this->get('school_types'),
        ]);
    }
}
