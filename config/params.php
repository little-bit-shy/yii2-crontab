<?php

if (YII_ENV_PROD) {
    return [
        'adminEmail' => 'admin@example.com',
    ];
} else if (YII_ENV_TEST) {
    return [
        'adminEmail' => 'admin@example.com',
    ];
} else if (YII_ENV_DEV) {
    return [
        'adminEmail' => 'admin@example.com',
    ];
}
