<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Purchasing\Purchase;
use App\Schools\School;
use App\User;
use Faker\Generator as Faker;

$factory->define(Purchase::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->state('school'),
        'customer_id' => factory(School::class),
        'customer_type' => School::class,
        'package_id' => 'fake',
        'price' => $faker->numberBetween(1000,50000),
        'paid' => $faker->boolean,
        'currency' => 'usd',
        'card_last_four' => '1234',
        'card_type' => $faker->randomElement(['visa', 'MasterCard', 'Discover', 'Amex']),
        'gateway_ref_no' => '123456',
        'gateway_status' => $faker->randomElement(['AUTHRECEIVED', 'PENDING']),
        'gateway_error' => $faker->sentence,
        'ref_no' => \Illuminate\Support\Str::random(3) . now()->format('Ymd'),
    ];
});
