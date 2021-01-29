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
        \App\Placements\JobPost::SALARY_RATE_HOUR => '時數',
        \App\Placements\JobPost::SALARY_RATE_WEEK => '每週',
        \App\Placements\JobPost::SALARY_RATE_MONTH => '每月',
    ],

    'schedule' => [
        \App\Placements\JobPost::SCHEDULE_MORNINGS => '上午',
        \App\Placements\JobPost::SCHEDULE_AFTERNOONS => '下午',
        \App\Placements\JobPost::SCHEDULE_EVENINGS => '傍晚',
    ],

    'required' => [
        'area_id' => '地點',
        'school_name' => '學校名稱',
        'position' => '職缺名稱',
        'description' => '工作內容',
        'student_ages' => '學生年齡',
        'schedule' => '教課時段',
        'salary_rate' => '薪資內容',
        'min_students_per_class' => '每班最少幾位學生',
        'max_students_per_class' => '每班最多幾位學生',
        'contract_length' => '聯絡人',
        'engagement' => '全職/兼職',
        'hours_per_week' => '每週教課時數',
    ]


];
