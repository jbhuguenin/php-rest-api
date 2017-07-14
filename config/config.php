<?php

return [
    'router' => [
        'routes' => [
            'default'   => ['route' => '/', 'controller' => '\\Rest\\Controller\\indexController'],
            'user'      => ['route' => '/user/:id', 'controller' => '\\Rest\\Controller\\userController'],
            'favorites' => ['route' => '/favorites/:id', 'controller' => '\\Rest\\Controller\\userController'],
            'song'      => ['route' => '/song/:id', 'controller' => '\\Rest\\Controller\\songController']
        ]
    ],
    'database' => [
        'host'      => '',
        'dbname'    => '',
        'user'      => '',
        'password'  => ''
    ]
];