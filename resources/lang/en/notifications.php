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
    ]
];
