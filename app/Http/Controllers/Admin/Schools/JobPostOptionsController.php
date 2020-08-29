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
            'engagements'      => [
                ['value' => JobPost::PART_TIME, 'description' => 'Part Time'],
                ['value' => JobPost::FULL_TIME, 'description' => 'Full Time'],
            ],
            "student_ages"     => [
                [
                    "value"       => JobPost::AGE_KINDERGARTEN,
                    "description" => "Kindergarten"
                ],
                [
                    "value"       => JobPost::AGE_ELEMENTARY,
                    "description" => "Elementary school",
                ],
                ["value" => JobPost::AGE_JUNIOR_HIGH, "description" => "Junior high school"],
                ["value" => JobPost::AGE_SENIOR_HIGH, "description" => "Senior high school"],
                ["value" => JobPost::AGE_UNIVERSITY, "description" => "University"],
                ["value" => JobPost::AGE_ADULT, "description" => "Adult"],
            ],
            "benefits"         => [
                ["value" => JobPost::BENEFIT_ARC, "description" => "Provides ARC"],
                [
                    "value"       => JobPost::BENEFIT_INSURANCE,
                    "description" => "Health insurance",
                ],
                ["value" => JobPost::BENEFIT_RENEWAL_BONUS, "description" => "Renewal onus"],
            ],
            "contract_lengths" => [
                ["value" => JobPost::CONTRACT_NONE, "description" => "No contract"],
                ["value" => JobPost::CONTRACT_SIX_MONTHS, "description" => "6 Month contract"],
                ["value" => JobPost::CONTRACT_YEAR, "description" => "1 Year contract"],
                [
                    "value"       => JobPost::CONTRACT_OVER_YEAR,
                    "description" => "Over 1 year contract",
                ],
            ],
            'requirements'     => [
                ['value' => JobPost::REQUIRES_DEGREE, 'description' =>
                    'College Degree'],
                ['value' => JobPost::REQUIRES_POLICE_CHECK, 'description' =>
 'Police Check'],
                ['value' => JobPost::REQUIRES_TEFL, 'description' =>
                    'TEFL Certificate'],
            ],
            'salary_rates'     => [
                ['value' => JobPost::SALARY_RATE_HOUR, 'description' => 'Per Hour'],
                ['value' => JobPost::SALARY_RATE_MONTH, 'description' => 'Per Month'],
                ['value' => JobPost::SALARY_RATE_WEEK, 'description' => 'Per Week'],
            ],
            "schedule_times"   => [
                ["value" => JobPost::SCHEDULE_MORNINGS, "description" => "Mornings"],
                ["value" => JobPost::SCHEDULE_AFTERNOONS, "description" => "Afternoons"],
                ["value" => JobPost::SCHEDULE_EVENINGS, "description" => "Evenings"],
            ],
        ];
    }
}
