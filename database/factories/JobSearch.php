<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Placements\JobPost;
use App\Placements\JobSearch;
use App\Teachers\Teacher;
use Faker\Generator as Faker;

$factory->define(JobSearch::class, function (Faker $faker) {
    return [
        'teacher_id'     => factory(Teacher::class),
        'area_ids'       => [],
        'benefits'       => [JobPost::BENEFIT_ARC, JobPost::BENEFIT_INSURANCE],
        'student_ages'   => $faker->randomElements(JobPost::ALLOWED_AGES, 2),
        'contract_type'  => [JobPost::CONTRACT_YEAR],
        'salary'         => $faker->randomElement(JobSearch::ALLOWED_SALARIES),
        'hours_per_week' => $faker->randomElement(JobSearch::ALLOWED_HOURS),
        'weekends'       => $faker->boolean,
    ];
});
