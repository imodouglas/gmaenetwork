<?php

$routes_array = [
    //User routers
    'user' => [
        'home' => [
            'URI' => '/home',
            'page' => 'home'
        ],
        'profile' => [
            'URI' => '/profile',
            'page' => 'profile'
        ],
        'history' => [
            'URI' => '/history',
            'page' => 'history'
        ],
        'referrals' => [
            'URI' => '/referrals',
            'page' => 'referrals'
        ],
        'reset-password' => [
            'URI' => '/reset-password',
            'page' => 'reset-password'
        ]
    ],
    
    'admin' => [
        'home' => [
            'URI' => '/home',
            'page' => 'home'
        ],
        'about' => [
            'URI' => '/about',
            'page' => 'about'
        ]
    ]

];

foreach($routes_array['user'] AS $route){
    route($route['URI'], function(){ 
        $url = userAuth('views/'.$route['page'].'.view.php');
        include $url;
    });
 }