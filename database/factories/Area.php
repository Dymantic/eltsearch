<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Locations\Area;
use App\Locations\Region;
use Faker\Generator as Faker;

$factory->define(Area::class, function (Faker $faker) {
    return [
        'region_id' => factory(Region::class),
        'name' => new \App\Translation(['en' => $faker->word, 'zh' => $faker->word]),
    ];
});
