<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'account_type' => $faker->randomElement([User::ACCOUNT_TEACHER, User::ACCOUNT_SCHOOL, User::ACCOUNT_ADMIN]),
        'provider_user_id' => null,
        'platform' => null,
        'remember_token' => Str::random(10),
    ];
});

$factory->state(User::class, 'teacher', [
    'account_type' => User::ACCOUNT_TEACHER,
]);

$factory->state(User::class, 'school', [
    'account_type' => User::ACCOUNT_SCHOOL,
]);

$factory->state(User::class, 'admin', [
    'account_type' => User::ACCOUNT_ADMIN,
]);

$factory->state(User::class, 'facebook', [
    'name' => 'test fb user',
    'email' => 'test@test.test',
    'provider_user_id' => 'test_fb_id',
    'platform' => User::PLATFORM_FACEBOOK,
    'password' => null,
    'account_type' => User::ACCOUNT_TEACHER,
]);

