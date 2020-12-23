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
        'billing_country' => $faker->countryCode,
        'billing_address' => $faker->address,
        'billing_city' => $faker->city,
        'billing_state' => '',
        'billing_zip' => $faker->numberBetween(100, 999),
    ];
});

$factory->state(School::class, 'empty', [
    'address'      => null,
    'introduction' => null,
    'area_id'      => null,
]);

$factory->state(School::class, 'incomplete', [
    'address'      => null,
    'introduction' => null,
    'area_id'      => null,
]);
