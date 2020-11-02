<?php

return [
  'salary' => [
      \App\Placements\JobSearch::SALARY_AVG => 'An average salary for the industry, or higher.',
      \App\Placements\JobSearch::SALARY_HIGH => 'Only salaries higher than the current average.',
  ],

    'hours' => [
        \App\Placements\JobSearch::HOURS_LOW => 'Under 20 hours a week',
        \App\Placements\JobSearch::HOURS_MAX => '20 hours or more per week',
    ]
];
