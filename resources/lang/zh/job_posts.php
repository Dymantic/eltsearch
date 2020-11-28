<?php

return [
    'engagement' => [
        \App\Placements\JobPost::FULL_TIME => '全職',
        \App\Placements\JobPost::PART_TIME => '兼職',


    ],

    'student_ages' => [
        \App\Placements\JobPost::AGE_KINDERGARTEN => '幼稚園',
        \App\Placements\JobPost::AGE_ELEMENTARY => '國小生',
        \App\Placements\JobPost::AGE_JUNIOR_HIGH => '國中生',
        \App\Placements\JobPost::AGE_SENIOR_HIGH => '高中生',
        \App\Placements\JobPost::AGE_UNIVERSITY => '大學生',
        \App\Placements\JobPost::AGE_ADULT => '成人',
    ],

    'requirements' => [
        \App\Placements\JobPost::REQUIRES_DEGREE => '畢業證書',
        \App\Placements\JobPost::REQUIRES_POLICE_CHECK => '良民證',
        \App\Placements\JobPost::REQUIRES_TEFL => 'TEFL證書',
        \App\Placements\JobPost::REQUIRES_HEALTH_CHECK => '健康檢查報告',
    ],

    'benefits' => [
        \App\Placements\JobPost::BENEFIT_ARC => '在台居留證',
        \App\Placements\JobPost::BENEFIT_INSURANCE => '保險',
        \App\Placements\JobPost::BENEFIT_RENEWAL_BONUS => '續約津貼',
        \App\Placements\JobPost::BENEFIT_ANNUAL_BONUS => '年終獎金',
    ],

    'contract' => [
        \App\Placements\JobPost::CONTRACT_NONE => '無合約',
        \App\Placements\JobPost::CONTRACT_SIX_MONTHS => '半年/六個月合約',
        \App\Placements\JobPost::CONTRACT_YEAR => '一年合約',
        \App\Placements\JobPost::CONTRACT_OVER_YEAR => '超過一年合約',
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
