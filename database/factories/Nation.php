<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Nation;
use Faker\Generator as Faker;

$factory->define(Nation::class, function (Faker $faker) {
    $nation = $faker->country;
    return [
        'iso_code'   => $faker->countryCode,
        'nationality' => new \App\Translation(['en' => $nation, 'zh' => "{$nation} [zh]"]),
        'name'     => $nation,
    ];
});
