<?php
return array(

    'default' => array(

        'connection_uri' => 'mysql:host=localhost;dbname=test',

        'username' => 'root',

        'password' => '',

        'pdo_options' => array(

            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",

            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

        )
    ),
);