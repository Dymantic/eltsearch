<?php

return [

    'application_received' => [
        'subject' => 'New application for :position',
        'message' => 'You have received a new application from :teacher, for the position of :position, at your school :school',
        'action' => 'See Application',
    ],

    'welcome_school' => [
        'subject' => 'Welcome to ELT Search',
        'message' => 'Hi :name, thank you for registering :school with ELT Search. Good luck with your search, we won\'t let you down.',
        'action' => 'Visit dashboard',
    ],

    'purchase_complete' => [
        'subject' => 'Thank you for your purchase',
        'message' => 'Hi :name. A purchase of :package has been successfully completed by :buyer. The amount paid was :price. Thank you very much.',
        'action' => 'View details',
        'you' => 'you',
    ],

    'school_disabled' => [
        'subject' => 'Your school profile has been disabled',
        'message' => 'Hi :name. Your school profile for :school has been temporarily disabled. If you would like to query this decision, please contact ELT Search at services@eltsearch.com. If the profile remains disabled for over 30 days, it will be permanently deleted. While the profile is disabled, it is not visible to the public, and you may not use all the ELT Search functions. Thanks.',
        'action' => '',
    ],

    'school_reinstated' => [
        'subject' => 'Your school profile has been reinstated',
        'message' => 'Hi :name. Your school profile for :school has been reinstated. All the best.',
        'action' => '',
    ],

    'job_post_disabled' => [
        'subject' => 'Your ELT Search job post has been retracted',
        'message' => 'Hi :name. Your job post for the position of :position at :school has been been temporarily retracted and will not be viewable on the site until the issue is resolved. If you would like to query this decision, please contact ELT Search at services@eltsearch.com. Please note that this does not affect the 30 day lifespan of your job post. Thanks.',
        'action' => '',
    ],

    'job_post_reinstated' => [
        'subject' => 'Your ELT Search job post has been reinstated',
        'message' => 'Hi :name. Your job post for the position of :position at :school has been been reinstated and is publicly viewable as long as it is published and not expired. Thanks.',
        'action' => '',
    ],
];
