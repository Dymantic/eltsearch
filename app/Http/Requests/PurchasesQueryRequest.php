<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchasesQueryRequest extends FormRequest
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
            'date' => 'purchases.created_at',
            'amount' => 'purchases.price',
        ];

        return $orders[$this->get('order')] ?? 'purchases.created_at';
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
