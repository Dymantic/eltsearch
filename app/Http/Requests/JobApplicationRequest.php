<?php

namespace App\Http\Requests;

use App\ContactDetails;
use App\Placements\JobPost;
use App\Teachers\Teacher;
use Illuminate\Foundation\Http\FormRequest;

class JobApplicationRequest extends FormRequest
{

    public function authorize()
    {
        return $this->user()->isTeacher();
    }

    public function teacher(): Teacher
    {
        return $this->user()->teacher;
    }


    public function rules()
    {
        return [
            'job_post_id' => 'exists:job_posts,id',
            'cover_letter' => ['required'],
            'email' => ['required_without:phone', 'email'],
            'phone' => ['required_without:email']
        ];
    }

    public function jobPost(): JobPost
    {
        return JobPost::find($this->job_post_id);
    }

    public function coverLetter(): string
    {
        return $this->cover_letter ?? '';
    }

    public function contactDetails(): ContactDetails
    {
        return new ContactDetails(['phone' => $this->phone, 'email' => $this->email]);
    }
}
