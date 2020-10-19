<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Placements\JobApplication;
use App\Placements\ShowOfInterest;
use Faker\Generator as Faker;

$factory->define(ShowOfInterest::class, function (Faker $faker) {
    return [
        'job_application_id' => factory(JobApplication::class),
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
    ];
});
