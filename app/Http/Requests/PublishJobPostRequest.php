<?php

namespace App\Http\Requests;

use App\Placements\JobPost;
use Illuminate\Foundation\Http\FormRequest;

class PublishJobPostRequest extends FormRequest
{

    public ?JobPost $post = null;

    public function authorize()
    {
        $this->post = JobPost::with('school')->find($this->job_post_id);

        if(!$this->post) {
            return false;
        }

        return $this->user()->schools->contains($this->post->school);
    }


    public function rules()
    {
        return [
            //
        ];
    }

    public function getPost(): JobPost
    {
        return $this->post ?? JobPost::find($this->job_post_id);
    }
}
