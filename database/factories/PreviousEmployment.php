<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Teachers\PreviousEmployment;
use App\Teachers\Teacher;
use Faker\Generator as Faker;

$factory->define(PreviousEmployment::class, function (Faker $faker) {
    return [
        'teacher_id'    => factory(Teacher::class),
        'employed_from' => \Illuminate\Support\Carbon::today()->subYear(),
        'employed_to'   => \Illuminate\Support\Carbon::today()->subWeek(),
        'employer'      => $faker->company,
        'job_title'     => $faker->jobTitle,
        'description'   => $faker->paragraph,
    ];
});
