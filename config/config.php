<?php

return [
    'router' => [
        'routes' => [
            'default'   => ['route' => '/', 'controller' => '\\Rest\\Controller\\IndexController'],
            'user'      => ['route' => '/user/:id', 'controller' => '\\Rest\\Controller\\UserController'],
            'favorites' => ['route' => '/favorites/:id', 'controller' => '\\Rest\\Controller\\FavoritesController'],
            'song'      => ['route' => '/song/:id', 'controller' => '\\Rest\\Controller\\SongController']
        ]
    ],
    'database' => [
        'host'      => $_ENV['MYSQL_PORT_3306_TCP_ADDR'],
        'dbname'    => $_ENV['MYSQL_ENV_MYSQL_DATABSE'],
        'user'      => $_ENV['MYSQL_ENV_MYSQL_USER'],
        'password'  => $_ENV['MYSQL_ENV_MYSQL_ROOT_PASSWORD']
    ]
];