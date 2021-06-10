<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use Illuminate\Http\Request;

class JobSearchOptionsController extends Controller
{
    public function show()
    {
        return [
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
                ["value" => JobPost::BENEFIT_RENEWAL_BONUS, "description" => "Renewal bonus"],
            ],
            "contract_lengths" => [
                ["value" => JobPost::CONTRACT_NONE, "description" => "No contract"],
                ["value" => JobPost::CONTRACT_SIX_MONTHS, "description" => "6 month_contract"],
                ["value" => JobPost::CONTRACT_YEAR, "description" => "1 year contract"],
                [
                    "value"       => JobPost::CONTRACT_OVER_YEAR,
                    "description" => "Over 1 year contract",
                ],
            ],
            "hours"            => [
                ["value" => JobSearch::HOURS_LOW, "description" => "Less than 20 hours per week"],
                ["value" => JobSearch::HOURS_MAX, "description" => "20 hours or more a week"],
            ],
            "salary_ranges"    => [
                ["value" => JobSearch::SALARY_AVG, "description" => "An average salary for the industry or above"],
                ["value" => JobSearch::SALARY_HIGH, "description" => "A higher than average salary"],
            ],
            "engagements"      => [
                ["value" => JobPost::FULL_TIME, "description" => "Full Time"],
                ["value" => JobPost::PART_TIME, "description" => "Part Time"],
            ],
            "schedule_times"   => [
                ["value" => JobPost::SCHEDULE_MORNINGS, "description" => "Mornings"],
                ["value" => JobPost::SCHEDULE_AFTERNOONS, "description" => "Afternoons"],
                ["value" => JobPost::SCHEDULE_EVENINGS, "description" => "Evenings"],
            ],
        ];
    }
}
