<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeachersQueryRequest extends FormRequest
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
            'name' => 'teachers.name',
            'signed_up' => 'teachers.created_at',
            'nationality' => 'nations.nationality',
        ];
        return $orders[$this->get('order')] ?? 'teachers.name';
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
