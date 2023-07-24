<?php

$env = (object) $_ENV;

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'bsVersion' => '4.x',
    'version' => $env->APP_VERSION ?? '1.0.2'
];
