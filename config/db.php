<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;dbname=sismec',
    'username' => 'sismec',
    'password' => 'sismec',
    'charset' => 'utf8',
    'attributes' => [PDO::ATTR_CASE => PDO::CASE_LOWER],
    'on afterOpen' => function($event) {
        $event->sender->createCommand("SET sql_mode = ''")->execute();
    }
];
