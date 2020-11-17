<?php

return [

    'status' => [
        'live' => 'Live',
        'draft' => 'Draft',
        'private' => 'Private',
        'expired' => 'Expired',
    ],

    'engagement' => [
        \App\Placements\JobPost::FULL_TIME => 'Full Time',
        \App\Placements\JobPost::PART_TIME => 'Part Time',


    ],

    'student_ages' => [
        \App\Placements\JobPost::AGE_KINDERGARTEN => 'Kindergarten',
        \App\Placements\JobPost::AGE_ELEMENTARY => 'Elementary School',
        \App\Placements\JobPost::AGE_JUNIOR_HIGH => 'Junior High School',
        \App\Placements\JobPost::AGE_SENIOR_HIGH => 'Senior High School',
        \App\Placements\JobPost::AGE_UNIVERSITY => 'University',
        \App\Placements\JobPost::AGE_ADULT => 'Adult',
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

    'required' => [
        'area_id' => 'Location',
        'school_name' => 'School name',
        'position' => 'Position',
        'description' => 'Job description',
        'student_ages' => 'Student Ages',
        'schedule' => 'Schedule / Times of day',
        'salary_rate' => 'Salary information',
        'min_students_per_class' => 'Students per class (min)',
        'max_students_per_class' => 'Students per class (max)',
        'contract_length' => 'Contract',
        'engagement' => 'Full time/Part time',
        'hours_per_week' => 'Hours per week',
    ]


];
