<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Purchasing\Purchase;
use App\Purchasing\ResumePass;
use App\Schools\School;
use Faker\Generator as Faker;

$factory->define(ResumePass::class, function (Faker $faker) {
    return [
        'school_id'   => factory(School::class),
        'expires_on'  => now()->addDays(30),
        'purchase_id' => factory(Purchase::class)
    ];
});

$factory->state(ResumePass::class, 'expired', [
    'expires_on' => now()->subDays(7),
]);
