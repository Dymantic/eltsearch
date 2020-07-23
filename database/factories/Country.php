<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Locations\Country;
use App\Translation;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {
    return [
        'name' => new Translation(['en' => $faker->word, 'zh' => $faker->word]),
    ];
});
