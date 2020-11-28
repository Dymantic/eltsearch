<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolsQueryRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            //
        ];
    }

    public function order(): string
    {
        $orders = [
            'name' => 'schools.name',
            'signedup' => 'schools.created_at',
            'location' => 'areas.name->en',
        ];
        return $orders[$this->get('order')] ?? 'schools.name';
    }

    public function direction(): string
    {
        return $this->get('direction', 'asc') === 'asc' ? 'asc': 'desc';
    }

    public function search(): string
    {
        return $this->get('q', '') ?? '';
    }
}
