<?php

return [
    'engagement' => [
        \App\Placements\JobPost::FULL_TIME => 'Full Time',
        \App\Placements\JobPost::PART_TIME => 'Part Time',


    ],

    'student_ages' => [
        \App\Placements\JobPost::AGE_KINDERGARTEN => '专业化的使',
        \App\Placements\JobPost::AGE_ELEMENTARY => '专业化的',
        \App\Placements\JobPost::AGE_JUNIOR_HIGH => '专业化的使',
        \App\Placements\JobPost::AGE_SENIOR_HIGH => '化的使',
        \App\Placements\JobPost::AGE_UNIVERSITY => '专业化',
        \App\Placements\JobPost::AGE_ADULT => '专业化的',
    ],

    'requirements' => [
        \App\Placements\JobPost::REQUIRES_DEGREE => 'Graduate Degree',
        \App\Placements\JobPost::REQUIRES_POLICE_CHECK => 'Police Clearance',
        \App\Placements\JobPost::REQUIRES_TEFL => 'TEFL Certificate',
    ],

    'benefits' => [
        \App\Placements\JobPost::BENEFIT_ARC => 'ARC',
        \App\Placements\JobPost::BENEFIT_INSURANCE => 'Health Insurance',
        \App\Placements\JobPost::BENEFIT_RENEWAL_BONUS => 'Renewal Bonus',
    ],

    'contract' => [
        \App\Placements\JobPost::CONTRACT_NONE => 'No Contact',
        \App\Placements\JobPost::CONTRACT_SIX_MONTHS => '6 Month Contract',
        \App\Placements\JobPost::CONTRACT_YEAR => '1 year Contract',
        \App\Placements\JobPost::CONTRACT_OVER_YEAR => 'Long Term Contract',
    ],

    'salary' => [
        \App\Placements\JobPost::SALARY_RATE_HOUR => 'hour',
        \App\Placements\JobPost::SALARY_RATE_WEEK => 'week',
        \App\Placements\JobPost::SALARY_RATE_MONTH => 'month',
    ],

    'schedule' => [
        \App\Placements\JobPost::SCHEDULE_MORNINGS => 'Morning',
        \App\Placements\JobPost::SCHEDULE_AFTERNOONS => 'Afternoon',
        \App\Placements\JobPost::SCHEDULE_EVENINGS => 'Evening',
    ],


];
