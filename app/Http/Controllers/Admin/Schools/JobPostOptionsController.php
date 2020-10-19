<?php

namespace App\Http\Controllers\Admin\Schools;

use App\Http\Controllers\Controller;
use App\Placements\JobPost;
use Illuminate\Http\Request;

class JobPostOptionsController extends Controller
{
    public function show()
    {
        return [
            'engagements'      => $this->translatedOptions(JobPost::ALLOWED_ENGAGEMENT, "job_posts.engagement"),
            "student_ages"     => $this->translatedOptions(JobPost::ALLOWED_AGES, "job_posts.student_ages"),
            "benefits"         => $this->translatedOptions(JobPost::ALLOWED_BENEFITS, "job_posts.benefits"),
            "contract_lengths" => $this->translatedOptions(JobPost::ALLOWED_CONTRACT_LENGTHS, "job_posts.contract"),
            'requirements'     => $this->translatedOptions(JobPost::ALLOWED_REQUIREMENTS, "job_posts.requirements"),
            'salary_rates'     => $this->translatedOptions(JobPost::ALLOWED_SALARY_RATES, "job_posts.salary"),
            "schedule_times"   => $this->translatedOptions(JobPost::ALLOWED_SCHEDULE, "job_posts.schedule"),
        ];
    }

    private function translatedOptions($options, $key)
    {
        return collect($options)
            ->map(fn($option) => [
                'value'       => $option,
                'description' => trans("{$key}.{$option}")
            ])->values()->all();
    }
}
