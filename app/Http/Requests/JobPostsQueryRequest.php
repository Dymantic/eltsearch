<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobPostsQueryRequest extends FormRequest
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
            'school'    => 'job_posts.school_name',
            'area'      => 'areas.name->en',
            'published' => 'job_posts.first_published_at',
            'position' => 'job_posts.position'
        ];

        return $orders[$this->get('order')] ?? 'job_posts.first_published_at';
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
