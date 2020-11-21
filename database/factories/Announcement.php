<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Announcements\Announcement;
use App\Translation;
use Faker\Generator as Faker;

$factory->define(Announcement::class, function (Faker $faker) {
    return [
        'body'   => new Translation(['en' => $faker->sentence, 'zh' => $faker->sentence]),
        'starts' => now(),
        'ends'     => now()->addDays(7),
        'type' => $faker->randomElement([
            Announcement::PUBLIC, Announcement::FOR_SCHOOLS, Announcement::FOR_TEACHERS
        ])
    ];
});

$factory->state(Announcement::class, 'public', [
    'type' => Announcement::PUBLIC,
]);

$factory->state(Announcement::class, 'schools', [
    'type' => Announcement::FOR_SCHOOLS,
]);

$factory->state(Announcement::class, 'teachers', [
    'type' => Announcement::FOR_TEACHERS,
]);
