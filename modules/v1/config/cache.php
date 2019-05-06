<?php

if (YII_ENV_PROD) {
    return [
        'class' => \yii\redis\Cache::className(),
        'redis' => [
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ],
        'keyPrefix' => 'app_',
    ];
} else if (YII_ENV_TEST) {
    return [
        'class' => \yii\redis\Cache::className(),
        'redis' => [
            'hostname' => '127.0.0.1',
            'port' => 6378,
            'database' => 0,
        ],
        'keyPrefix' => 'app_',
    ];
} else if (YII_ENV_DEV) {
    return [
        'class' => \yii\redis\Cache::className(),
        'redis' => [
            'hostname' => '127.0.0.1',
            'port' => 6378,
            'database' => 0,
        ],
        'keyPrefix' => 'app_',
    ];
}