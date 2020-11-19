<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Placements\JobMatch;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use Faker\Generator as Faker;

$factory->define(JobMatch::class, function (Faker $faker) {
    return [
        'job_post_id'   => factory(JobPost::class),
        'job_search_id' => factory(JobSearch::class),
        'dismissed'     => false,
    ];
});

$factory->state(JobMatch::class, 'dismissed', [
    'dismissed' => true,
]);
