<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Placements\RecruitmentAttempt;
use App\Schools\School;
use App\Teachers\Teacher;
use Faker\Generator as Faker;

$factory->define(RecruitmentAttempt::class, function (Faker $faker) {
    return [
        'school_id' => factory(School::class),
        'teacher_id' => factory(Teacher::class),
        'message' => $faker->sentence,
        'contact_person' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
    ];
});
