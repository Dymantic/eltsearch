<?php

namespace App\Http\Requests;

use App\Locations\Area;
use Illuminate\Foundation\Http\FormRequest;

class PublicTeachersQueryRequest extends FormRequest
{

    public function authorize()
    {
        return $this->route('school')->hasResumeAccess();
    }


    public function rules()
    {
        return [
            //
        ];
    }

    public function orderColumn(): string
    {
        $orders = [
            'nationality'     => 'nations.nationality',
            'name'       => 'teachers.name',
            'experience' => 'teachers.years_experience',
            'age'        => 'teachers.date_of_birth',
        ];

        return $orders[$this->get('order', 'name')] ?? 'teachers.name';
    }

    public function orderDirection(): string
    {
        $directions = [
            'asc'  => 'asc',
            'desc' => 'desc'
        ];

        return $directions[$this->get('direction', 'asc')] ?? 'asc';
    }

    public function schoolArea(): ?Area
    {
        return Area::find($this->get('near', 0));
    }

    public function nationality(): int
    {
        return intval($this->get('nation', 0));
    }

    public function experienceLevel(): int
    {
        return intval($this->get('exp_level', 0));
    }
}
