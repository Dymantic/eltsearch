<?php

return [
  'salary' => [
      \App\Placements\JobSearch::SALARY_LOW => 'Any salary',
      \App\Placements\JobSearch::SALARY_MID => 'Above NT$30,000 per month',
      \App\Placements\JobSearch::SALARY_HIGH => 'Above NT$65,000 per month',
  ],

    'hours' => [
        \App\Placements\JobSearch::HOURS_MIN => 'Less than 14 hours a week',
        \App\Placements\JobSearch::HOURS_LOW => 'Less than 20 hours a week',
        \App\Placements\JobSearch::HOURS_MID => 'Less than 30 hours a week',
        \App\Placements\JobSearch::HOURS_MAX => 'As many as possible',
    ]
];
