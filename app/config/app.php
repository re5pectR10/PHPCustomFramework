<?php
return array(

    'debug' => true,

    'default_controller' => 'UsersController',

    'default_method' => 'index2',

    'enable_default_routing' => false,

    'global_input_escaping' => true,

    'controllers_namespace' => 'Controllers',

    'namespaces' => array(

        'Controllers' => dirname(__DIR__) . '\controllers',
        'Asd'=>  dirname(__DIR__) . '\asd'
    ),

    'session' => array(

        'autostart' => true,

        'type' => 'database',

        'name' => '__sess',

        'lifetime' => 3600,

        'path' => '/',

        'domain' => '',

        'secure' => false,

        'dbConnection' => 'default',

        'dbTable' => 'sessions',
    )
);