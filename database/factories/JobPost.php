<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Placements\JobPost;
use App\Schools\School;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(JobPost::class, function (Faker $faker) {
    return [
        'slug'                   => \Illuminate\Support\Str::random(8),
        'school_id'              => factory(School::class),
        'posted_by'              => factory(User::class)->state('school'),
        'last_edited_by'         => factory(User::class)->state('school'),
        'school_name'            => $faker->company,
        'description'            => $faker->paragraph,
        'area_id'                => factory(\App\Locations\Area::class),
        'position'               => $faker->jobTitle,
        'engagement'             => $faker->randomElement(JobPost::ALLOWED_ENGAGEMENT),
        'hours_per_week'         => $faker->numberBetween(13, 25),
        'min_students_per_class' => $faker->numberBetween(4, 12),
        'max_students_per_class' => $faker->numberBetween(13, 25),
        'student_ages'           => $faker->randomElements(JobPost::ALLOWED_AGES, 2),
        'work_on_weekends'       => $faker->boolean,
        'requirements'           => $faker->randomElements(JobPost::ALLOWED_REQUIREMENTS, 2),
        'salary_rate'            => $faker->randomElement(JobPost::ALLOWED_SALARY_RATES),
        'salary_min'             => $faker->numberBetween(100, 100000),
        'salary_max'             => $faker->numberBetween(100, 100000),
        'start_date'             => Carbon::today(),
        'benefits'               => $faker->randomElements(JobPost::ALLOWED_BENEFITS, 2),
        'contract_length'        => $faker->randomElement(JobPost::ALLOWED_CONTRACT_LENGTHS),
        'schedule'               => $faker->randomElements(JobPost::ALLOWED_SCHEDULE, 2),
        'first_published_at'     => Carbon::yesterday(),
        'is_public'              => $faker->boolean,
        'disabled_on'            => null,
    ];
});

$factory->state(JobPost::class, 'draft', [
    'first_published_at' => null,
    'is_public'          => false,
]);

$factory->state(JobPost::class, 'private', [
    'is_public' => false,
]);

$factory->state(JobPost::class, 'public', [
    'is_public' => true,
]);

$factory->state(JobPost::class, 'current', [
    'first_published_at' => Carbon::yesterday(),
    'is_public'          => true,
]);

$factory->state(JobPost::class, 'expired', [
    'first_published_at' => Carbon::yesterday()->subDays(30),
    'is_public'          => true,
]);

$factory->state(JobPost::class, 'disabled', [
    'first_published_at' => Carbon::yesterday(),
    'is_public'          => true,
    'disabled_on'        => now(),
]);
