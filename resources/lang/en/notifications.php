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
        'message' => 'Hi :name. Your school profile for :school has been been temporarily disabled. If you would like to query this decision, please contact ELT Search at services@eltsearch.com. If the profile remains disabled for over 30 days, it will be permanently deleted. While the profile is disabled, it is not visible to the public, and you may not use all the ELT Search functions. Thanks.',
        'action' => '',
    ],

    'school_reinstated' => [
        'subject' => 'Your school profile has been reinstated',
        'message' => 'Hi :name. Your school profile :school has been reinstated. All the best.',
        'action' => '',
    ]
];
