<?php

return [
    [
        'id' => 'single_token',
        'price' => 40,
        'type' => 'token',
        'trans_key' => 'pricing.single_post',
        'icon' => 'svg.icons.token',
        'icon_size' => 'h-6',
    ],
    [
        'id' => 'token_ten_pack',
        'price' => 300,
        'quantity' => 10,
        'type' => 'token',
        'trans_key' => 'pricing.ten_posts_pack',
        'icon' => 'svg.icons.token-pack',
        'icon_size' => 'h-6',
    ],
    [
        'id' => 'resume_pass_month',
        'price' => 50,
        'quantity' => 1,
        'expires' => 30,
        'type' => 'resume_pass',
        'trans_key' => 'pricing.resume_pass',
        'icon' => 'svg.icons.resume-pass',
        'icon_size' => 'h-6',
    ],
    [
        'id' => 'resume_pass_year',
        'price' => 450,
        'quantity' => 1,
        'expires' => 365,
        'type' => 'resume_pass',
        'trans_key' => 'pricing.year_resume_pass',
        'icon' => 'svg.icons.resume-pass-year',
        'icon_size' => 'h-8',
    ]
];
