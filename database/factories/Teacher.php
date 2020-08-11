<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Locations\Area;
use App\Teachers\Teacher;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Teacher::class, function (Faker $faker) {
    return [
        'user_id'         => factory(User::class)->state('teacher'),
        'name'            => $faker->name,
        'nationality'     => $faker->country,
        'email'           => $faker->email,
        'date_of_birth'   => Carbon::today()->subYears(35),
        'area_id'         => factory(Area::class),
        'native_language' => 'English',
        'other_languages' => $faker->words(3, true),
        'is_public'       => $faker->boolean,
        'education_level' => $faker->randomElement(Teacher::ALLOWED_EDUCATION_LEVELS),
        'education_institution' => $faker->words(3, true),
        'education_qualification' => $faker->words(3, true),
    ];
});

$factory->state(Teacher::class, 'private', [
    'is_public' => false,
]);

$factory->state(Teacher::class, 'public', [
    'is_public' => true,
]);
