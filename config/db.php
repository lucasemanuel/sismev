<?php

if ( ! file_exists( __DIR__ . '/../.env' ) )
    error_reporting(E_ERROR | E_PARSE);

$env = (object) $_ENV;
$dns = "mysql:host={$env->DB_HOST};port={$env->DB_PORT};dbname={$env->DB_NAME}";

return [
    'class'        => 'yii\db\Connection',
    'dsn'          => $dns,
    'username'     => $env->DB_USER,
    'password'     => $env->DB_PASS,
    'charset'      => 'utf8',
    'attributes'   => [ PDO::ATTR_CASE => PDO::CASE_LOWER ],
    'on afterOpen' => function ($event) {
        $event->sender->createCommand( "SET sql_mode = ''" )->execute();
    }
];