<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Locations\Country;
use App\Locations\Region;
use Faker\Generator as Faker;

$factory->define(Region::class, function (Faker $faker) {
    return [
        'country_id' => factory(Country::class),
        'name' => new \App\Translation(['en' => $faker->word, 'zh' => $faker->word]),
    ];
});
