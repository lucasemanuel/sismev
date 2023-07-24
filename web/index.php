<?php

define('DS', DIRECTORY_SEPARATOR);

// set environment and debug mode
require_once __DIR__ . '/../config/Configurator.php';

\app\config\Configurator::init();

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
