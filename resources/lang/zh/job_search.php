<?php

return [
  'salary' => [
      \App\Placements\JobSearch::SALARY_AVG => 'An average salary for the industry, or higher.',
      \App\Placements\JobSearch::SALARY_HIGH => 'Only salaries higher than the current average.',
  ],

    'hours' => [
        \App\Placements\JobSearch::HOURS_MIN => 'Less than 14 hours a week',
        \App\Placements\JobSearch::HOURS_LOW => 'Less than 20 hours a week',
        \App\Placements\JobSearch::HOURS_MID => 'Less than 30 hours a week',
        \App\Placements\JobSearch::HOURS_MAX => 'As many as possible',
    ]
];
