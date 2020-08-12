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
        return true;
    }

    public function teacher(): Teacher
    {
        return $this->teacherProfile;
    }


    public function rules()
    {
        return [
            'job_post_id' => ['exists:job_posts,id']
        ];
    }

    public function jobPost(): JobPost
    {
        return JobPost::findOrFail($this->job_post_id);
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
