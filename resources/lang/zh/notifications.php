<?php

return [

    'application_received' => [
        'subject' => 'New application for :position',
        'message' => 'You have received a new application from :teacher, for the position of :position, at your school :school',
        'action' => 'See Application',
    ],

    'welcome_school' => [
        'subject' => 'Welcome to ELT Search',
        'message' => 'Ni hau :name, she-she ni for registering :school with ELT Search. Good luck with your search, we won\'t let you down.',
        'action' => 'Visit dashboard',
    ],

    'purchase_complete' => [
        'subject' => '感謝您的購買',
        'message' => 'Ni hau :name. A dongxi of :package has been successfully completed by :buyer. The amount paid was :price. Thank you very much.',
        'action' => 'Ni Kan',
        'you' => 'ni',
    ]
];
