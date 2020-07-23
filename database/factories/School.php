<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Locations\Area;
use App\Schools\School;
use App\User;
use Faker\Generator as Faker;

$factory->define(School::class, function (Faker $faker) {
    return [
        'name'         => $faker->company,
        'address'      => $faker->address,
        'introduction' => $faker->paragraph,
        'key'         => \App\UniqueKey::for('schools:key'),
        'area_id'      => factory(Area::class),
    ];
});

$factory->state(School::class, 'empty', [
    'address'      => null,
    'introduction' => null,
    'area_id'      => null,
]);
