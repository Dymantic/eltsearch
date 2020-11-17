<?php

return [
    [
        'id' => 'single_token',
        'name' => 'Single Job Post Token',
        'description' => 'Allows you to publish a single job post. Does not expire',
        'price' => 40,
        'type' => 'token',
        'trans_key' => 'pricing.single_post',
    ],
    [
        'id' => 'token_ten_pack',
        'name' => '10 x Job Post Tokens',
        'description' => 'Bulk pack of job pot tokens, at a discounted price.',
        'price' => 300,
        'quantity' => 10,
        'type' => 'token',
        'trans_key' => 'pricing.ten_posts_pack',
    ],
    [
        'id' => 'resume_pass_month',
        'description' => '30 days access to ELT Searches resume bank',
        'price' => 50,
        'quantity' => 1,
        'expires' => 30,
        'type' => 'resume_pass',
        'trans_key' => 'pricing.resume_pass',
    ],
    [
        'id' => 'resume_pass_year',
        'description' => 'One year access to ELT Searches resume bank',
        'price' => 450,
        'quantity' => 1,
        'expires' => 365,
        'type' => 'resume_pass',
        'trans_key' => 'pricing.year_resume_pass',
    ]
];
