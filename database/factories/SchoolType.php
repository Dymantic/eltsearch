<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Schools\SchoolType;
use App\Translation;
use Faker\Generator as Faker;

$factory->define(SchoolType::class, function (Faker $faker) {
    return [
        'name' => new Translation(['en' => $faker->word, 'zh' => $faker->word])
    ];
});

$factory->state(SchoolType::class, 'kindergarten', [
    'name' => new Translation(['en' => 'Kindergarten', 'zh' => '幼兒園'])
]);

$factory->state(SchoolType::class, 'elementary', [
    'name' => new Translation(['en' => 'Elementary School', 'zh' => '小學'])
]);
