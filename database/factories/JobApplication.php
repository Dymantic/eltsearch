<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Placements\JobApplication;
use App\Placements\JobPost;
use App\Teachers\Teacher;
use Faker\Generator as Faker;

$factory->define(JobApplication::class, function (Faker $faker) {
    return [
        'job_post_id'  => factory(JobPost::class),
        'teacher_id'   => factory(Teacher::class),
        'cover_letter' => $faker->paragraph,
        'email'        => $faker->email,
        'phone'        => $faker->phoneNumber
    ];
});
