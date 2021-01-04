<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Locations\Area;
use App\Nation;
use App\Teachers\Teacher;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

$factory->define(Teacher::class, function (Faker $faker) {
    return [
        'user_id'                 => factory(User::class)->state('teacher'),
        'slug'                    => Str::random(8),
        'name'                    => $faker->name,
        'nation_id'               => factory(Nation::class),
        'email'                   => $faker->email,
        'date_of_birth'           => Carbon::today()->subYears(35),
        'area_id'                 => factory(Area::class),
        'native_language'         => 'English',
        'other_languages'         => $faker->words(3, true),
        'is_public'               => $faker->boolean,
        'education_level'         => $faker->randomElement(Teacher::ALLOWED_EDUCATION_LEVELS),
        'education_institution'   => $faker->words(3, true),
        'education_qualification' => $faker->words(3, true),
        'years_experience'        => $faker->numberBetween(1, 15),
        'disabled_on'             => null,
    ];
});

$factory->state(Teacher::class, 'private', [
    'is_public' => false,
]);

$factory->state(Teacher::class, 'public', [
    'is_public' => true,
]);

$factory->state(Teacher::class, 'homeless', [
    'area_id' => null,
]);

$factory->state(Teacher::class, 'incomplete', [
    'is_public'               => false,
    'date_of_birth'           => null,
    'nation_id'               => null,
    'years_experience'        => null,
    'native_language'         => '',
    'education_level'         => '',
    'education_qualification' => '',
]);

$factory->state(Teacher::class, 'enabled', [
    'disabled_on'             => null,
]);

$factory->state(Teacher::class, 'disabled', [
    'disabled_on'             => now(),
]);
