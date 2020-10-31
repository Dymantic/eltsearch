<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Notifications\DatabaseNotification;

$factory->define(DatabaseNotification::class, function (Faker $faker) {
    return [
        'id' => \Illuminate\Support\Str::uuid(),
        'type' => 'Namespace\ClassName',
        'data' => [],
    ];
});
