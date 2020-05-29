<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Schools\School;
use App\User;
use Faker\Generator as Faker;

$factory->define(School::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->address,
        'user_id' => factory(User::class)->state('school')
    ];
});
